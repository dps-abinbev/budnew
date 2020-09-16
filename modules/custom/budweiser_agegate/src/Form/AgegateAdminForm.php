<?php

/**
 * @file
 * Contains \Drupal\agegate\Form\AgegateAdminForm.
 */

namespace Drupal\agegate\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class AgegateAdminForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'agegate_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('agegate.settings');

    $form['agegate_age_limit'] = [
      '#type' => 'select',
      '#title' => $this->t('Age Limit'),
      '#options' => [
        21 => $this->t('21'),
        20 => $this->t('20'),
        19 => $this->t('19'),
        18 => $this->t('18'),
        17 => $this->t('17'),
        16 => $this->t('16'),
        15 => $this->t('15'),
        14 => $this->t('14'),
      ],
      '#default_value' => $config->get('agegate_age_limit'),
      '#description' => $this->t('Set this to the age limit you require.'),
    ];
    $form['age_gate_escape_crawlers'] = array(
      '#type'          => 'select',
      '#options'       => array(1 => 'On', 0 => 'Off'),
      '#title'         => t('Allow crawlers to index the site.'),
      '#description'   => t('Based on a regexp, it allows crawlers to index pages behind the agegate.'),
      '#default_value' => $config->get('age_gate_escape_crawlers'),
    );

    // REGEXT to identify crawlers.
    $form['age_gate_crawler_regexp'] = array(
      '#title'         => t('Enter crawlers regexp'),
      '#type'          => 'textfield',
      '#maxlength'     => 4096,
      '#default_value' => $config->get('age_gate_crawler_regexp') ?? '(googlebot\/|Googlebot-Mobile|Googlebot-Image|Google favicon|Mediapartners-Google|bingbot|slurp|java|wget|curl|Commons-HttpClient|Python-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail.RU_Bot|discobot|heritrix|findthatfile|europarchive.org|NerdByNature.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web-archive-net.com.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks-robot|it2media-domain-crawler|ip-web-crawler.com|siteexplorer.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e.net|GrapeshotCrawler|urlappendbot|brainobot|fr-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf.fr_bot|A6-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j-asr|Domain Re-Animator Bot|AddThis)',
      '#required'      => true,
      '#description'   => t('Enter the regexp you want to use in order to allow crawlers index the page.'),
    );
    $form['agegate_urls_to_skip'] = [
      '#type' => 'textarea',
      '#title' => $this->t('URLs to skip'),
      '#rows' => 3,
      '#cols' => 20,
      '#default_value' => $config->get('agegate_urls_to_skip'),
      '#description' => $this->t('Enter the node relative urls of the pages that the age gate should ignore. In example, user or node/62 or cookie-policy. One per line.'),
    ];

    $form['agegate_use_numpad'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable number pad'),
      '#default_value' => $config->get('agegate_use_numpad'),
      '#required' => FALSE,
    ];

    $form['agegate_description'] = [
      '#type' => 'textarea',
      '#title' => t('Form description'),
      '#rows' => 3,
      '#cols' => 20,
      '#default_value' => $config->get('agegate_description'),
      '#description' => $this->t('Add any description information or links you want to display under the form. Links & HTML tags: are allowed.'),
    ];

    $form['agegate_disclaimer'] = [
      '#type' => 'textarea',
      '#title' => t('Form disclaimer'),
      '#rows' => 3,
      '#cols' => 20,
      '#default_value' => $config->get('agegate_disclaimer'),
      '#description' => $this->t('Add any disclaimer information or links you want to display under the form. Links & HTML tags: are allowed.'),
    ];

    $form['agegate_redirect'] = [
      '#type' => 'textfield',
      '#title' => t('Form redirect url'),
      '#default_value' => $config->get('agegate_redirect'),
      '#description' => $this->t('URL to redirect if validation fails.'),
    ];

    $form['agegate_user_agents'] = [
      '#type' => 'textarea',
      '#title' => t('Search User Agents'),
      '#rows' => 3,
      '#cols' => 20,
      '#default_value' => $config->get('agegate_user_agents'),
      '#description' => '<p>' . $this->t('Add any extra search bots you do not want to be blocked from indexing your site. The default is Google "Googlebot" "Googlebot-Mobile" "Googlebot-Image", "Bing "bingbot", MSN "msnbot", Yahoo "slurp".') . '</p>',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('agegate.settings');

    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['agegate.settings'];
  }

}
