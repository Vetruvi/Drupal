<?php

namespace Drupal\mailer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Language\LanguageInterface;

/**
 * @ingroup unserialize
 */
class Send extends ControllerBase {
  public function content()
  {
    $config = \Drupal::config('mailer.settings');
    $Route = $config->get('Mail.Mail_id');
    $Route1 = $config->get('Mail.Mail_bot_id');
    $Route2 = $config->get('Mail.attachment_url');
    $Route3 = $config->get('Mail.attachment_type');
    $Route4 = $config->get('Mail.phone');
    $Route5 = $config->get('Mail.key_api');
    $Route6 = $config->get('Mail.Text');
      $post = http_build_query([
        'message_id' => $Route,
        'whatsapp_bot_id' => $Route1,
        'attachment_url' => $Route2,
        'attachment_type' => $Route3,
        'message' => $Route6,
        'phone' => $Route4,
      ]);
    $request = \Drupal::httpClient()->post('https://chatter.salebot.pro/api/' . $Route5 . '/whatsapp_message', [
    'body' => $post,
    'headers' => array('Content-Type' => 'Massange')
    ]);
    return array(
      '#type' => 'markup',
      '#markup' => t('Сообщение успешно отправлено'),
    );
  }
}
