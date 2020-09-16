<?php

namespace Drupal\budweiser_api_football\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Budweiser Api Football settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'budweiser_api_football_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['budweiser_api_football.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['api_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Url'),
      '#description' => $this->t('Example: https://myapiurl.com'),
      '#required' => TRUE,
      '#default_value' => $this->config('budweiser_api_football.settings')->get('api_url'),
    ];
    $form['api_host'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RapidAPI host'),
      '#required' => TRUE,
      '#default_value' => $this->config('budweiser_api_football.settings')->get('api_host'),
    ];
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RapidAPI key'),
      '#required' => TRUE,
      '#default_value' => $this->config('budweiser_api_football.settings')->get('api_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
//    if ($form_state->getValue('example') != 'example') {
//      $form_state->setErrorByName('example', $this->t('The value is not correct.'));
//    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('budweiser_api_football.settings')
      ->set('api_url', $form_state->getValue('api_url'))
      ->set('api_host', $form_state->getValue('api_host'))
      ->set('api_key', $form_state->getValue('api_key'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
