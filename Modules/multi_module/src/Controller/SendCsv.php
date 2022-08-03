<?php

namespace Drupal\multi_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Language\LanguageInterface;

/**
 * @ingroup multi_module
 */
class SendCsv extends ControllerBase {
  public function content() {
    $config = \Drupal::config('multi_module.settings');
    $Route = $config->get('Mail.Mail_id');
    $Route1 = $config->get('Mail.Mail_bot_id');
    $Route4 = $config->get('Mail.phone');
    $Route5 = $config->get('Mail.key_api');
    $Route6 = $config->get('Mail.csv');
    $Route7 = $config->get('Mail.txt');
    $res = [];
    if (($fp = fopen($Route6, "r")) !== FALSE) {
      while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
        $res[] = $data;
      }
      fclose($fp);
    }
    foreach ($res as $item) {
      if ($item['0'] == $Route4) {
        $newvar = $item;
        break;
      }
    }
    $phone = array_slice($newvar, 0, 1);
    $phone = implode('', $phone);
    $name_comp = array_slice($newvar, 1, 1);
    $name_comp = implode('', $name_comp);
    $inn = array_slice($newvar, 2, 1);
    $inn = implode('', $inn);
    $name_box = array_slice($newvar, 3, 1);
    $name_box = implode('', $name_box);;
    $numb = array_slice($newvar, 4, 1);
    $numb = implode('', $numb);
    $name = array_slice($newvar, 5, 1);
    $name = implode('', $name);
    $name = iconv( "WINDOWS-1251", "UTF-8",  $name);
    $handle = fopen($Route7, "r");
    $file = file_get_contents($Route7);
    $swap_array_replace = array('#phone', '#name_comp', '#inn', '#name_box', '#number', '#name',);
    $swap_array_search = array($phone, $name_comp, $inn, $name_box, $numb, $name);
    $swap = str_replace($swap_array_replace, $swap_array_search, $file);
    fclose($handle);
      $post = http_build_query([
        'message_id' => $Route,
        'whatsapp_bot_id' => $Route1,
        'attachment_url' => '',
        'attachment_type' => '',
        'message' => $swap,
        'phone' => $phone,
      ]);
    $request = \Drupal::httpClient()->post('https://chatter.salebot.pro/api/' . $Route5 . '/whatsapp_message', [
    'body' => $post,
    'headers' => array('Content-Type' => 'application/x-www-form-urlencoded')
    ]);
    $response = (string)$request->getBody();
    return array(
      '#type' => 'markup',
      '#markup' => t('Сообщение: <br>' . $swap . '<br> Было успешно отправлено.'),
    );
  }
}
