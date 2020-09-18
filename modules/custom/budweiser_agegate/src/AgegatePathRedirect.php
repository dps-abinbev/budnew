<?php

/**
 * @file
 * Contains \Drupal\agegate\AgegatePathRedirect.
 */

// http://drupal.stackexchange.com/questions/205621/implementing-an-age-check-using-inboundpathprocessorinterface

namespace Drupal\agegate;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Routing\RouteMatch;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AgegatePathRedirect.
 */
class AgegatePathRedirect implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST] = 'checkSystemPaths';
    return $events;
  }

  /**
   * Redirect from original system paths to their new locations.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $response
   *   The created response object that will be returned.
   * @param string $event
   *   The string representation of the event.
   * @param \Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher $event_dispatcher
   *   Event dispatcher that lazily loads listeners and subscribers from the dependency injection
   *   container.
   */
  public function checkSystemPaths(GetResponseEvent $response, $event, ContainerAwareEventDispatcher $event_dispatcher) {
    // $routeMatch = RouteMatch::createFromRequest($response->getRequest());
    // $route_name = $routeMatch->getRouteName();

    $config = \Drupal::config('agegate.settings');
    $alias_manager = \Drupal::service('path.alias_manager');
    $user = \Drupal::currentUser();
    $session = \Drupal::request()->getSession();

    if (((bool) $session->get('age_verified') ) && $_COOKIE['STYXKEY_age_verified']) {
      return;
    }

    // Explode the form field to get each line.
    $skip_urls = explode("\n", $config->get('agegate_urls_to_skip'));
    $skip_urls[] = '/admin';
    $skip_urls[] = '/agegate';
    $skip_urls[] = '/rss.xml';
    $skip_urls[] = '/sitemap.xml';
    $skip_urls[] = '/club-colombia-terminos-y-condiciones';
    $skip_urls[] = '/club-colombia-politicas-de-privacidad';
    $skip_urls[] = '/club-colombia-politica-de-proteccion-de-datos';

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
      $request_alias = $alias_manager->getAliasByPath($response->getRequest()->getRequestUri());
      $url_alias = $alias_manager->getAliasByPath($url);
      if ($url == $alias_manager->getAliasByPath($response->getRequest()->getRequestUri())) {
        return;
      }
    }

    // Now we need to explode the agegate_user_agents field to separate
    // lines.
    $user_agents = explode("\n", $config->get('agegate_user_agents'));
    $http_user_agent = \Drupal::request()->server->get('HTTP_USER_AGENT');
    \Drupal::logger('fb_debug')->notice($http_user_agent);

    // For each one of the lines we want to trim white space and empty lines.
    foreach ($user_agents as $key => $user_agent) {
      // If a user has string from $user_agent.
      if (empty($user_agent)) {
        unset($lines[$key]);
      }
      // To be sure we match proper string, we need to trim it.
      $user_agent = trim($user_agent);

      //if ($http_user_agent == $user_agent) {
      if( strpos($http_user_agent, $user_agent) !== false) {
        return;
      }
    }

    $this->gotoAgegate($response);
  }

  protected function gotoAgegate(GetResponseEvent $response) {
    $url = (!strpos($_SERVER['REQUEST_URI'], 'PANTHEON_STRIPPED')) ? $_SERVER['REQUEST_URI'] : $_COOKIE['STYXKEY_url'];
    //dpm($_SERVER['REQUEST_URI']);
    if(!isset($_COOKIE['STYXKEY_url']) && $url) {
      $host = \Drupal::request()->getSchemeAndHttpHost();
      setcookie('STYXKEY_url', $host.'/'.$url, time() + (86400 * 30), "/");
    }
    $requestUriOrigin = $url;
    $pos = strpos($requestUriOrigin, '?');
    //kpr($_SERVER);

    if ($pos !== false) {
      $requestUriOrigin = substr_replace($requestUriOrigin, '&', $pos, strlen('?'));
    }

    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();
    //$session = \Drupal::request()->getSession();
    //$session->set('querystring', $_SERVER['QUERY_STRING']);
    if( strpos($response->getRequest()->getRequestUri(), '/agegate') !== 0 && (!in_array("administrator", $roles)) && $requestUriOrigin ) {
      $response->setResponse(new RedirectResponse('/agegate'."?destination=".$requestUriOrigin, Response::HTTP_TEMPORARY_REDIRECT));
    }
  }

}
