<?php

namespace Drupal\ab_cdp_connector\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Ab InBev CDP Connector event subscriber.
 */
class AbCdpConnectorSubscriber implements EventSubscriberInterface {

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs event subscriber.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  public function ab_cdp_connector_load(GetResponseEvent $event) {
    global $ad_cdp_connector_items;
    $ad_cdp_connector_items = array(
      'name',
      'surname',
      'email',
      'gender',
      'idnumber',
      'province',
      'country',
      'town',
      'cellphone',
      'dayofbirth',
      'optin',
      'tyc'
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => ['ab_cdp_connector_load'],
    ];
  }

}
