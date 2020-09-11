<?php

namespace Drupal\budweiser_core\EventSubscriber;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Budweiser Core route subscriber.
 */
class BudweiserCoreRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    $route = $collection->get('user.pass');
    $route->setPath('/recover-password');
    $collection->add('user.pass', $route);

    $route_register = $collection->get('user.register');
    $route_register->setPath('/bud-futbol');
    $collection->add('user.register', $route_register);
  }

}
