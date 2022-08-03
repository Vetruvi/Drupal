<?php

namespace Drupal\multi_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\ConfigFormBaseTrait;

/**
 * @ingroup multi-module
 */
class CallsArray extends ControllerBase {
  public function content()
  {
    $config = \Drupal::config('multi_module.settings');
    $Route = $config->get('Unserialize.Route');
    $Delete = ['GET  a:0:{}', 'POST ', "\n"];
    $handle = fopen($Route, "r");
    $text = fread($handle, filesize($Route));
    fclose($handle);
    $handle = fopen($Route, 'w');
    fwrite($handle, str_replace($Delete, '', $text));
    $res = file_get_contents($Route);
    $under = unserialize($res);
    $results = print_r($under, true);
    return array(
      '#type' => 'markup',
      '#markup' => t("<pre>$results<br>"),
    );
  }
}
