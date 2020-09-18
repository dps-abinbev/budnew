<?php

namespace Drupal\budweiser_api_football\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\taxonomy\Entity\Term;

/**
 * Defines 'budweiser_api_football_teams_queue' queue worker.
 *
 * @QueueWorker(
 *   id = "budweiser_api_teams_queue",
 *   title = @Translation("Teams Queue"),
 *   cron = {"time" = 60}
 * )
 */
class BudweiserTeamsApi extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $database = \Drupal::database();
    $tid = $database->select('taxonomy_term__field_api_id', 'apiId')
      ->fields('apiId', array('entity_id'))
      ->condition('field_api_id_value', $data['team_id'])
      ->execute()
      ->fetchField();
    if($tid){
      $term = Term::load($tid);
      $term->name->setValue($data['name']);
      $term->field_logo->setValue($data['logo']);
    }else{
      $term = \Drupal\taxonomy\Entity\Term::create([
        'vid' => 'teams',
        'name' => $data['name'],
        'field_api_id' => [$data['team_id']],
        'field_logo' => [$data['logo']],
      ]);
    }
    $term->save();
  }

  public function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
  }

}
