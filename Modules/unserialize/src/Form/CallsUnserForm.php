<?php

namespace Drupal\unserialize\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Url;

class CallsUnserForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'Unserialize_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('unserialize.settings');
    $form['Unserialize_text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Route to serialize file'),
      '#default_value' => $config->get('Unserialize.Route')
    );
    $form['actions']['submit1'] = [
      '#type' => 'submit',
      '#value' => $this->t('Next to create entity'),
      "#weight" => 1,
      '#submit' => array([$this, 'submitFormOne']),
      '#limit_validation_errors' => array()
    ];

    $form['actions']['submit2'] = [
      '#type' => 'submit',
      '#value' => $this->t('Unserialize arrays'),
      "#weight" => 2,
      '#button_type' => 'primary',
      '#submit' => array([$this, 'submitFormTwo']),
      '#limit_validation_errors' => array()
    ];
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (mb_strlen($form_state->getValue('Unserialize_text')) < 1) {
      $form_state->setErrorByName('Route', $this->t('This is not be route.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('unserialize.settings');
    $query = \Drupal::database()->select('calls');
    $query->addExpression('MAX(id)'); // <--
    $max = $query->execute()->fetchField();
    $config->set('Unserialize.Route', $form_state->getValue('Unserialize_text'));
    $config->set('Unserialize.Id', $max);
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitFormOne(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('entity.unserialize_calls.collection');
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitFormTwo(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('unserialize.content');
    parent::submitForm($form, $form_state);
  }

  protected function getEditableConfigNames() {
    return ['unserialize.settings'];
  }


}
