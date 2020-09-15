<?php

namespace Drupal\ab_cdp_connector\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Ab InBev CDP Connector settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ab_cdp_connector_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ab_cdp_connector.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $ad_cdp_connector_items;
    $form['ab_cdp_connector_configuration'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('CDP Settings'),
      '#weight' => 7,
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );

    $form['ab_cdp_connector_configuration']['ab_cdp_connector_general_custom_on'] = [
      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_general_custom_on'),
      '#description' => $this->t('If is enable the CDP integration for custom form process.'),
      '#title' => $this->t('Active CDP integration in Custom Form?'),
      '#type' => 'checkbox',
    ];
    $form['ab_cdp_connector_configuration']['ab_cdp_connector_webform_env'] = [
      '#type'          => 'select',
      '#title'         => t('Environment'),
      '#options'       => array(
        '9648/41e45454b77308046627548e0b4fe2ddbc0893d2'  => t('Dev'),
        '10086/9c06ed6fa48e0fb6952ed42773cca1cc1d43684e' => t('Prod'),
      ),
      '#default_value' =>$this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_webform_env', ''),
      '#required'      => true,
    ];
    $form['ab_cdp_connector_configuration']['ab_cdp_connector_zone'] = [
      '#type'          => 'select',
      '#title'         => 'Zone',
      '#options'       => array(
        'midam_source/col_web_form'  => "Colombia",
        'midam_source/mex_web_form'  => "México",
        'midam_source/ecu_web_form'  => "Ecuador",
        'midam_source/per_web_form'  => "Perú",
        'saz_source/bol_web_form'  => "Bolivia",
        'africa_source/zaf_web_form' => "South Africa",
      ),
      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_zone', ''),
      '#required'      => true,
    ];

    $form['ab_cdp_connector_configuration']['ab_cdp_connector_brand'] = [
      '#type'          => 'textfield',
      '#title'         => 'Brand',
      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_brand', ''),
      '#required'      => true,
    ];

    $form['ab_cdp_connector_configuration']['ab_cdp_connector_campaign'] = [
      '#type'          => 'textfield',
      '#title'         => 'Campaign',
      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_campaign', ''),
      '#required'      => true,
    ];

//    $form['ab_cdp_connector_configuration']['ab_cdp_connector_write_key'] = [
//      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_write_key', ''),
//      '#description' => $this->t('CDP Write Key'),
//      '#title' => $this->t('CDP Write Key'),
//      '#type' => 'textfield',
//    ];
//
//    $form['ab_cdp_connector_configuration']['ab_cdp_connector_endpoint_url'] = [
//      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_endpoint_url', ''),
//      '#description' => $this->t('CDP Endpoint Url'),
//      '#title' => $this->t('CDP Endpoint Url'),
//      '#type' => 'textfield',
//    ];
//
    $form['ab_cdp_connector_configuration']['ab_cdp_connector_form_type'] = [
      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_form_type', ''),
      '#description' => $this->t('Form type'),
      '#title' => $this->t('Form type'),
      '#type' => 'textfield',
    ];
    $form['ab_cdp_connector_configuration']['ab_cdp_connector_custom_form_id'] = [
      '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_custom_form_id', ''),
      '#description' => $this->t('Custom Form Id'),
      '#title' => $this->t('Custom Form Id'),
      '#type' => 'textfield',
    ];
//
//    $form['ab_cdp_connector_configuration_items'] = array(
//      '#type' => 'fieldset',
//      '#title' => $this->t('CDP Configuration Items'),
//      '#weight' => 8,
//      '#collapsible' => TRUE,
//      '#collapsed' => FALSE,
//    );
//
//    foreach ($ad_cdp_connector_items as $key => $value) {
//      $form['ab_cdp_connector_configuration_items']['fieldset_' . $value] = array(
//        '#type' => 'fieldset',
//        '#title' => t('Item ' . $value),
//        '#weight' => $key,
//        '#description' => 'CDP field : '.$value,
//        '#collapsible' => TRUE,
//        '#collapsed' => TRUE,
//      );
//      $form['ab_cdp_connector_configuration_items']['fieldset_' . $value]['ab_cdp_connector_general_custom_on_' . $value] = [
//        '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_general_custom_on_' . $value),
//        '#title' => t('Active'),
//        '#type' => 'checkbox',
//      ];
//      $form['ab_cdp_connector_configuration_items']['fieldset_' . $value]['ab_cdp_connector_general_custom_position_' . $value] = [
//        '#default_value' => $this->config('ab_cdp_connector.settings')->get('ab_cdp_connector_general_custom_position_' . $value, ''),
//        '#title' => t('Position'),
//        '#type' => 'textfield',
//      ];
//    }

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
//    global $ad_cdp_connector_items;
    $this->config('ab_cdp_connector.settings')
      ->set('ab_cdp_connector_general_custom_on', $form_state->getValue('ab_cdp_connector_general_custom_on'))
      ->set('ab_cdp_connector_webform_env', $form_state->getValue('ab_cdp_connector_webform_env'))
      ->set('ab_cdp_connector_zone', $form_state->getValue('ab_cdp_connector_zone'))
      ->set('ab_cdp_connector_brand', $form_state->getValue('ab_cdp_connector_brand'))
      ->set('ab_cdp_connector_campaign', $form_state->getValue('ab_cdp_connector_campaign'))
      ->set('ab_cdp_connector_form_type', $form_state->getValue('ab_cdp_connector_form_type'))
      ->set('ab_cdp_connector_custom_form_id', $form_state->getValue('ab_cdp_connector_custom_form_id'))
      ->save();
//    foreach ($ad_cdp_connector_items as $key => $value) {
//      $this->config('ab_cdp_connector.settings')
//        ->set('ab_cdp_connector_general_custom_on_' . $value, $form_state->getValue('ab_cdp_connector_general_custom_on_' . $value))
//        ->set('ab_cdp_connector_general_custom_position_' . $value, $form_state->getValue('ab_cdp_connector_general_custom_position_' . $value))
//        ->save();
//    }
    parent::submitForm($form, $form_state);
  }
}
