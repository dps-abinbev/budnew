<?php

/**
 * @file
 * Contains \Drupal\agegate\AgePathProcessor.
 */

namespace Drupal\agegate;

use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Path processor for agegate.
 */
class AgePathProcessor implements InboundPathProcessorInterface {

  /**
   * {@inheritdoc}
   *
   * TODO: add a check for the user age based on logged in user.
   */
  public function processInbound($path, Request $request) {
    // Get saved settings and other needed objects.
    $config = \Drupal::config('agegate.settings');
    $alias_manager = \Drupal::service('path.alias_manager');
    $user = \Drupal::currentUser();
    $session = \Drupal::request()->getSession();

    if ($user->id() == 0 && !((bool) $session->get('age_verified'))) {
      \Drupal::service('page_cache_kill_switch')->trigger();
      kint($session->get('age_verified'));
    }

    // Skip processing when session is set and the value is 1.
    // var_dump($session->get('age_verified'));
    if ($session->get('age_verified')) {
      return $path;
    }

    // Explode the form field to get each line.
    $skip_urls = explode("\n", $config->get('agegate_urls_to_skip'));
    $skip_urls[] = '/admin';
    $skip_urls[] = '/agegate';

    // For each one of the lines we want to trim white space and empty lines.
    foreach ($skip_urls as $key => $url) {
      if (empty($url)) {
        unset($lines[$key]);
      }
      // To be sure we match the proper string, we need to trim it.
      $url = trim($url);

      // Now because Drupal 8 works with paths that start from '/', we need to
      // prepend it if needed.
      if (strpos($url, '/') !== 0) {
        $url = '/' . $url;
      }

      // If the URL is equal alias in the admin field then allow original path.
      $request_alias = $alias_manager->getAliasByPath($request->getRequestUri());
      $url_alias = $alias_manager->getAliasByPath($url);
      if ($url == $alias_manager->getAliasByPath($request->getRequestUri())) {
        // Leave $path intact.
        return $path;
      }
    }

    // Now we need to explode the agegate_user_agents field to separate
    // lines.
    $user_agents = explode("\n", $config->get('agegate_user_agents'));
    $http_user_agent = \Drupal::request()->server->get('HTTP_USER_AGENT');

    // For each one of the lines we want to trim white space and empty lines.
    foreach ($user_agents as $key => $user_agent) {
      // If a user has string from $user_agent.
      if (empty($user_agent)) {
        unset($lines[$key]);
      }
      // To be sure we match proper string, we need to trim it.
      $user_agent = trim($user_agent);

      if ($http_user_agent == $user_agent) {
        // Leave $path intact.
        return $path;
      }
    }

    // If user ID and the session is not set, show age verification form.
    if ($user->id() == 0 && !$session->get('age_verified')) {
      // Save path to session so we can redirect user from the form.
      $session->set('agegate_path', $path);
      $session->set('querystring',  $_SERVER['QUERY_STRING']);
      
      // We could do a 301 redirect here using below method:
      // new RedirectResponse(\Drupal::url('agegate.form'), 301);
      // But since you shouldn't be firing a redirect from anywhere else besides
      // a controller or a form, we just render form on the URL we're on.
      // if($path != "/agegate") {
      //   $response = new RedirectResponse('/agegate');
      //   $response->send();
      //   return;
      // } else {
      // }
      return '/agegate';
    }

    if((bool) $session->get('age_verified') === FALSE) {
      $session->set('age_verified', TRUE);
    }

    // Allow user access for cases not captured above. This should most likely
    // never happen.
    return $path;
  }
}
