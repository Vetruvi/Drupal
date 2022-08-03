<?php

namespace Drupal\multi_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @ingroup multi_module
 */
class CallsSettingsForm extends FormBase {

  /**
   * @return string
   */
  public function getFormId() {
    return 'multi_module_settings';
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
    $form['calls_settings']['#markup'] = 'Настройки форм для создания сущностей. Управляйте полями здесь.';
    return $form;
  }

}
