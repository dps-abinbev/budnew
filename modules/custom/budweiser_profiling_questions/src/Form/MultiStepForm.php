<?php

namespace Drupal\budweiser_profiling_questions\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Budweiser Profiling Questions form.
 */
class MultiStepForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'budweiser_profiling_questions_multistep';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $num_step = isset($_SESSION['store_answers']) ? count($_SESSION['store_answers'])+1 : 1;
    if($num_step > 1){
      $five_nids = $_SESSION['five_nids'];
    }else{
      $nids = \Drupal::entityQuery('node')
        ->condition('type','player_profiling_questions')
        ->execute();
      shuffle($nids);
      $five_nids = array_slice($nids, 0, 5);
      $_SESSION['five_nids'] = $five_nids;
    }
    $nid = $five_nids[$num_step-1];
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    $answers = $node->field_answers->getValue();
    $options = [];
    foreach ($answers as $element) {
      $p = \Drupal\paragraphs\Entity\Paragraph::load( $element['target_id'] );
      $answer = $p->field_answer->getValue()[0]['value'];
//      $value = $p->field_value->getValue();
      $options[$element['target_id']] = $answer;
    }
    $question = $node->title->getValue()[0]['value'];
    $items = [];

    for($i = 1; $i<=5; $i++){
      $active = $i == $num_step ? 'active' : '';
      $items[] = [
        '#markup' => $i,
        '#wrapper_attributes' => [
          'class' => [$active],
        ],
      ];
    }

    $form['steps'] = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => $items,
      '#attributes' => ['class' => 'list-step-form'],
      '#wrapper_attributes' => ['class' => 'container-step-form'],
    ];

    $form['num_step'] = [
      '#type' => 'value',
      '#value' => $num_step,
    ];

    $form['nid'] = [
      '#type' => 'value',
      '#value' => $nid,
    ];

    $form['question'] = [
      '#type' => 'item',
      '#markup' => "<h3>{$question}</h3>",
    ];

    $form['answers'] = [
      '#type' => 'radios',
//      '#required' => TRUE,
      '#options' => $options,
      '#default_value' => key($options),
      '#validated' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Continuar'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = [
      'nid' => $form_state->getValue('nid'),
      'answer' => $form_state->getValue('answers'),
    ];
    if(isset($_SESSION['store_answers'])){
      $_SESSION['store_answers'][] = $data;
    }else{
      $_SESSION['store_answers'] = [
        $data,
      ];
    }
//    If step is final save data
    if($form_state->getValue('num_step') == 5){
      $connection = \Drupal::database();
      $uid = \Drupal::currentUser()->id();
      $query = $connection->insert('budweiser_profiling_answers')
        ->fields(['nid', 'uid', 'target_id', 'status', 'created']);
      foreach ($_SESSION['store_answers'] as $record) {
        $value = [
          'nid' => $record['nid'],
          'uid' => intval($uid),
          'target_id' => $record['answer'],
          'status' => 1,
          'created' => \Drupal::time()->getRequestTime(),
        ];
        $query->values($value);
      }
      $query->execute();
      unset($_SESSION['store_answers']);
      unset($_SESSION['five_nids']);
      $this->messenger()->addStatus($this->t('Your answers has been saved'));
      $form_state->setRedirect('<front>');
    }
  }
}
