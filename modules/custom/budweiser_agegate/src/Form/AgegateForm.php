<?php

/**
 * @file
 * Contains \Drupal\agegate\Form\AgegateForm.
 */

namespace Drupal\agegate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Routing\TrustedRedirectResponse;

class AgegateForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'agegate_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['#attached']['library'][] = 'ab_core/app';
    $config = $this->config('agegate.settings');
    $cc_cookies = \Drupal::request()->cookies->all();
    $ag_cookie = isset($cc_cookies['Drupal_visitor_dob']) ? $cc_cookies['Drupal_visitor_dob'] : '';

    if (isset($ag_cookie) && !empty($ag_cookie)): list($year, $month, $day) = explode('-', $ag_cookie);
    else:user_cookie_delete($ag_cookie);endif;
    //var_dump($day);
    $day = !empty($day) ? $day : '';
    $month = !empty($month) ? $month : '';
    $year = !empty($year) ? $year : '';
    $remember = !empty($ag_cookie) ? 1 : 0;

    /* $form['logo_club'] = [
         '#type' => 'markup',
         '#markup' => '<div class="logo-club-colombia"></div>',
     ];*/

    if (!empty($config->get('agegate_description'))) {
      $form['custom_agegate_description'] = [
        '#type' => 'markup',
        '#markup' => '<div class="description">' . $config->get('agegate_description') . '</div>',
      ];
    }
    if ((bool)$config->get('agegate_use_numpad') === true) {
      $form['custom_agegate_num_pad'] = [
        '#type' => 'markup',
        '#markup' => '<div class="numpad"><span class="key num1">1</span><span class="key num2">2</span><span class="key num3">3</span><span class="key num4">4</span><span class="key num5">5</span><span class="key num6">6</span><span class="key num7">7</span><span class="key num8">8</span><span class="key num9">9</span><span class="key del">' . t('del') . '</span><span class="key num0">0</span><span class="key empty">&nbsp;</span></div>',
      ];
    }


    $form['dob'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="block-title"><h2 class="title">Para hacer parte de este reino del fútbol debes ser mayor de edad.</h2></div>',
      '#weight' => 0
    );

    $form['row-1']= array(
      '#type' => 'container'
    );

    $form['row-1']['row-1-2']= array(
      '#type' => 'container'
    );

//    $form['row-1']['row-1-2']['header'] = array(
//      '#markup' => '<p>Ingresa tu fecha de nacimiento.</p>',
//    );
    $form['row-1']['row-1-2']['sectionYear'] = array(
      '#type' => 'container',
      '#attributes' => array('class' => array('tab')),
    );

    $form['row-1']['row-1-2']['sectionYear']['header'] = array(
      '#markup' => '<p>Ingresa tu año de nacimiento.</p>',
      '#prefix' => '<div class="header">',
      '#suffix' => '</div>',
    );
    $form['row-1']['row-1-2']['sectionYear']['year'] = [
      '#prefix' => '<div class="field-content">',
      '#suffix' => '</div>',
    ];
    $form['row-1']['row-1-2']['sectionYear']['year']['year1'] = [
      '#type' => 'number',
      '#placeholder' => 'A',
      '#required' => true,
      '#pattern' => '[1-2]*',
      '#min' => 1,
      '#max' => 2,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('A'),
        'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
      ),
    ];
    $form['row-1']['row-1-2']['sectionYear']['year']['year2'] = [
      '#type' => 'number',
      '#placeholder' => 'A',
      '#required' => true,
      '#pattern' => '[0-9]*',
      '#min' => 0,
      '#max' => 9,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('A'),
        'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
      ),
    ];
    $form['row-1']['row-1-2']['sectionYear']['year']['year3'] = [
      '#type' => 'number',
      '#placeholder' => 'A',
      '#required' => true,
      '#pattern' => '[0-9]*',
      '#min' => 0,
      '#max' => 9,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('A'),
        'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
      ),
    ];
    $form['row-1']['row-1-2']['sectionYear']['year']['year4'] = [
      '#type' => 'number',
      '#placeholder' => 'A',
      '#required' => true,
      '#pattern' => '[0-9]*',
      '#min' => 0,
      '#max' => 9,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('A'),
        'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
      ),
    ];

    $form['row-1']['row-1-2']['sectionMonth'] = [
      '#type' => 'container',
      '#attributes' => array('class' => array('tab')),
    ];

    $form['row-1']['row-1-2']['sectionMonth']['header'] = [
      '#markup' => '<p>Ingresa tu mes de nacimiento</p>',
      '#prefix' => '<div class="header">',
      '#suffix' => '</div>',
    ];
    $form['row-1']['row-1-2']['sectionMonth']['month'] = [
      '#prefix' => '<div class="field-content">',
      '#suffix' => '</div>',
    ];
    $form['row-1']['row-1-2']['sectionMonth']['month']['month1'] = [
    '#type' => 'number',
    '#placeholder' => 'M',
    '#required' => TRUE,
    '#pattern' => '[0-1]*',
    //      '#default_value' => $month,
    '#min' => 0,
    '#max' => 1,
    '#attributes' => array(
      'maxlength' => 1,
      'placeholder' => $this->t('M'),
      'oninput' => 'javascript: if (this.value.length >= this.maxLength) {this.value = this.value.slice(0, this.maxLength); document.getElementById("edit-year").focus();}'
    ),
  ];
    $form['row-1']['row-1-2']['sectionMonth']['month']['month2'] = [
      '#type' => 'number',
      '#placeholder' => 'M',
      '#required' => TRUE,
      '#pattern' => '[0-9]*',
      //      '#default_value' => $month,
      '#min' => 0,
      '#max' => 9,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('M'),
        'oninput' => 'javascript: if (this.value.length >= this.maxLength) {this.value = this.value.slice(0, this.maxLength); document.getElementById("edit-year").focus();}'
      ),
    ];

    $form['row-1']['row-1-2']['sectionDay'] = [
      '#type' => 'container',
      '#attributes' => array('class' => array('tab')),
    ];
    $form['row-1']['row-1-2']['sectionDay']['header'] = [
      '#markup' => '<p>Ingresa tu día de nacimiento</p>',
      '#prefix' => '<div class="header">',
      '#suffix' => '</div>',
    ];
    $form['row-1']['row-1-2']['sectionDay']['day'] = [
      '#prefix' => '<div class="field-content">',
      '#suffix' => '</div>',
    ];
    $form['row-1']['row-1-2']['sectionDay']['day']['day1'] = [
      //'#title' => $this->t('Día'),
      '#type' => 'number',
      '#placeholder' => 'D',
      '#required' => TRUE,
      '#pattern' => '[0-3]*',
//      '#default_value' => $day,
      '#min' => 0,
      '#max' => 3,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('D'),
        'oninput' => 'javascript: if (this.value.length >= this.maxLength) {this.value = this.value.slice(0, this.maxLength); document.getElementById("edit-month--2").focus();}'
      ),
    ];
    $form['row-1']['row-1-2']['sectionDay']['day']['day2'] = [
      //'#title' => $this->t('Día'),
      '#type' => 'number',
      '#placeholder' => 'D',
      '#required' => TRUE,
      '#pattern' => '[0-9]*',
      //      '#default_value' => $day,
      '#min' => 0,
      '#max' => 9,
      '#attributes' => array(
        'maxlength' => 1,
        'placeholder' => $this->t('D'),
        'oninput' => 'javascript: if (this.value.length >= this.maxLength) {this.value = this.value.slice(0, this.maxLength); document.getElementById("edit-month--2").focus();}'
      ),
    ];

   /*  $form['row-2-1'] = array(
      '#type' => 'container'
    ); */

//    $form['row-2-1'] = array(
//      '#type' => 'markup',
//      '#markup' => '<div class="block-labels">
//            <div class="row">
//              <div class="col-4 col-sm"><p class="dd">Día</p></div>
//              <div class="col-4 col-sm"><p class="mm">Mes</p></div>
//              <div class="col-4 col-sm"><p class="yy">Año</p></div>
//            </div>
//          </div>'
//    );

    $form['row-2-2'] = array(
      '#type' => 'container'
    );

    $form['row-2-2'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="block-btn">
                <div class="btn btn-agegate"><span>entrar</span></div>
            </div>'
    );

    $form['row-3'] = array(
      '#type' => 'container'
    );
    $form['row-4'] = array(
      '#type' => 'container'
    );

    $form['row-3']['remember'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Recordar mis datos'),
      '#required' => false,
      '#default_value' => $remember,
    ];

    $form['row-3']['advertisement'] = [
      '#markup' => '<p>*No selecciones esta opción si compartes este computador con menores de edad.
       Este sitio web utiliza cookies que se quedarán almacenadas en el computador con el fin de mejorar
       su experiencia. Al proporcionar su fecha de nacimiento, también se acepta el uso de cookies.
       Más información haga clic <a href="">aquí.</a></p>',
    ];

    $form['row-3']['submit'] = [
      '#type' => 'submit',
      '#value' => t('entrar'),
    ];

    $form['row-4']['legal'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="recordar-datos">No deberías seleccionar "recordar mis datos" si compartes este computador con menores de edad.</div>',
    );

    /* $form['beers_bg_form'] = [
         '#type' => 'markup',
         '#markup' => '<div class="beers-bg"></div>',
     ];*/

    $form['#attached']['library'][] = 'agegate/agegate';
    $form['#attached']['library'][] = 'agegate/validate';

    if (!empty($config->get('agegate_disclaimer'))) {
      $form['custom_agegate_disclaimer'] = [
        '#type' => 'markup',
        '#markup' => '<div class="disclaimer">' . $config->get('agegate_disclaimer') . '</div>',
      ];
    }

    $form['facebook'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="facebook_wrapper">
           <div class="row">
            <div class="col-sm col-facebook">
             <div
             id="block-fboauth-connect"
             class="fb-login-button d-block mr-auto"
             data-scope="email, public_profile"
             data-max-rows="1"
             data-size="large"
             data-button-type="login_with"
             data-show-faces="false"
             onlogin="Drupal.behaviors.sabm_age_gate_face.checkLoginState()"
             data-use-continue-as="true"
             data-auto-logout-link="false">
             conectar con facebook
           </div>
          </div>
          <div class="col-sm">
            <div class="legal-facebook"><p>*Al hacer Facebook connect aceptas los términos y condiciones y las políticas de privacidad de nuestro website</p></div>
          </div>
          </div>
          </div>',
    );

    // $form['#cache'] = ['max-age' => 0];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
      $config = $this->config('agegate.settings');
      $form_values = $form_state->getValues();

      $dob = array();

      $dob['year'] = $form_values['year1'].$form_values['year2'].$form_values['year3'].$form_values['year4'];
      $dob['month'] = $form_values['month1'].$form_values['month2'];
      $dob['day'] = $form_values['day1'].$form_values['day2'];

      if((int)$dob['year'] <= 1900 || (int)$dob['year'] >= 2100){
        $form_state->setErrorByName('year1');
        $form_state->setErrorByName('year2');
        $form_state->setErrorByName('year3');
        $form_state->setErrorByName('year4', $this->t('El año es incorrecto'));
      }

    if((int)$dob['month'] < 0 || (int)$dob['month'] > 12){
      $form_state->setErrorByName('month1');
      $form_state->setErrorByName('month2', $this->t('El mes es incorrecto'));
    }
    if((int)$dob['day'] < 0 || (int)$dob['day'] > 31){
      $form_state->setErrorByName('day1');
      $form_state->setErrorByName('day2', $this->t('El día es incorrecto'));
    }

      $date = $dob['year'] . '-' . $dob['month'] . '-' . $dob['day'];
      //$date = $dob['year'] . '-' . $dob['month'] . '-' . '01';

      if ($dob['month'] != -1) {
          // Get rid of future dates.
          if ((int) $dob['year'] > date('Y')) {
              $dob['year'] = date('Y');
          }
          // We are going to run off midnight for these calculations.
          // Set $date_now to the unix time of today at midnight. This depends on
          // your server settings.
          $date_now = strtotime('today midnight');
          // Form values of day month year are converted to unix time.
          $date_posted = strtotime($date);
          // Simple math calculationt to determine difference.
          $difference = $date_now - $date_posted;
          // Add the Age to $accepted_age with a default of 18.
          $accepted_age = (int) $config->get('agegate_age_limit') * 31556926;
          // Compare the accepted_age with years of difference.
          if ($difference <= $accepted_age) {
              // Throw an error if user age is less than the age selected.
              // !variable: Inserted as is, with no sanitization or formatting.
              $form_state->setErrorByName('dob', t('You need to be @age or over to access the site.', [
                  '@age' => (int) $config->get('agegate_age_limit'),
              ]));
            return new \Symfony\Component\HttpFoundation\RedirectResponse('https://google.com');
          }
      } else {
          drupal_set_message(t('Debes seleccionar un mes.'), 'error');
      }

      if (!empty($form_values['remember']) && $form_values['remember'] == 1) {
          user_cookie_save(['dob' => $date]);
      }

      // Throw an error if user has not confirmed his age.
      // if (!empty($form_values['confirmation']) && $form_values['confirmation'] != 1) {
      //   $form_state->setErrorByName('confirmation', t('You need to confirm your age.'));
      // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    $config = $this->config('agegate.settings');
    $form_values = $form_state->getValues();

    $dob = array();

    $dob['year'] = $form_values['year1'].$form_values['year2'].$form_values['year3'].$form_values['year4'];
    $dob['month'] = $form_values['month1'].$form_values['month2'];
    $dob['day'] = $form_values['day1'].$form_values['day2'];

    $date = $dob['year'] . '-' . $dob['month'] . '-' . $dob['day'];
    //$date = $dob['year'] . '-' . $dob['month'] . '-' . '01';


    if ((int)$dob['year'] > date('Y')) {
      $dob['year'] = date('Y');
    }
    // We are going to run off midnight for these calculations.
    // Set $date_now to the unix time of today at midnight. This depends on
    // your server settings.
    $date_now = strtotime('today midnight');
    // Form values of day month year are converted to unix time.
    $date_posted = strtotime($date);
    // Simple math calculationt to determine difference.
    $difference = $date_now - $date_posted;
    // Add the Age to $accepted_age with a default of 18.
    $accepted_age = (int)$config->get('agegate_age_limit') * 31556926;
    // Compare the accepted_age with years of difference.
    if ($difference <= $accepted_age) {
      \Drupal::logger('agegate')->notice('entro 2');
      $redirect = new \Drupal\Core\Routing\TrustedRedirectResponse('https://www.tapintoyourbeer.com/age_check.cfm');
      return $redirect->send();
    } else {

      if (!empty($form_values['remember']) && $form_values['remember'] == 1) {
        user_cookie_save(['dob' => $date]);
      }


      $form_values = $form_state->getValues();
      $temp_month = $form_values['month'];
      $temp_day = $form_values['day'];

      $beer_type = $temp_day % 3;

      if ($beer_type == 0) {
        $user_beer_type = 'dorada';
      } elseif ($beer_type == 1) {
        $user_beer_type = 'negra';
      } else {
        $user_beer_type = 'roja';
      }

      user_cookie_save(['user_beer_type' => $user_beer_type]);

      // Add TRUE to session age_verified.
      $session = \Drupal::request()->getSession();
      $session->set('age_verified', 1);
      setcookie('STYXKEY_age_verified', 1, time() + (86400 * 30), "/");

      // Set user beer type
      //$session->set('user_beer_type', $user_beer_type);

      // Add a redirect to requested page. Using $form_state built in redirects.
      $redirect = $session->get('agegate_path');

      if ($_COOKIE['STYXKEY_url']) {
        $response = new TrustedRedirectResponse(Url::fromUri($_COOKIE['STYXKEY_url'])->toString());
        $form_state->setResponse($response);
      } elseif (!empty($redirect)) {
        $redirect = $session->get('agegate_path') . '?' . $session->get('querystring');

        $form_state->setRedirect($redirect);
      } else {
        // For everything else, redirect to homepage.
        $options = [];
        if ($session->get('querystring') != null) {
          parse_str($session->get('querystring'), $get_array);
          $options = $get_array;
        }
        $url = Url::fromRoute('<front>', $options);
        $form_state->setRedirectUrl($url);
      }

    }
  }
}
