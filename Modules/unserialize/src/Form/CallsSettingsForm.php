<?php

namespace Drupal\unserialize\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @ingroup unserialize
 */
class CallsSettingsForm extends FormBase {

  /**
   * @return string
   */
  public function getFormId() {
    return 'unserialize_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['calls_settings']['#markup'] = 'Settings form for unserialize. Manage field settings here.';
    return $form;
  }

}
