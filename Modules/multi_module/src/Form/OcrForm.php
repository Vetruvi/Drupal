<?php

namespace Drupal\multi_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

class OcrForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'Mailer_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form = parent::buildForm($form, $form_state);
    $config = $this->config('multi_module.settings');

    $form['url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Сыллка на изображение'),
      '#default_value' => $config->get('OCR.url')
    );

    $form['add']['block_image'] = array(
      '#type' => 'managed_file',
      '#name' => 'block_image',
      '#title' => t('Выберите файл:'),
      '#upload_location' => 'public://images',
    );

    $form['language'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Язык текста на изображении'),
      '#default_value' => $config->get('OCR.language')
    );

    $form['actions']['submit1'] = [
      '#type' => 'submit',
      '#value' => $this->t('Вывести текст с изображения'),
      "#weight" => 1,
      '#submit' => array([$this, 'submitFormOne']),
      '#limit_validation_errors' => array()
    ];


    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('multi_module.settings');
    $config->set('OCR.url', $form_state->getValue('url'));
    $config->set('OCR.language', $form_state->getValue('language'));
    $config->set('OCR.name_file', $form_state->getValue('block_image'));
    $form_file = $form_state->getValue('block_image', 0);
    if (isset($form_file[0]) && !empty($form_file[0])) {
      $file = File::load($form_file[0]);
      $file->save();
    }
    $config->save();
    return parent::submitForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitFormOne(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('multi_module.OCR_content');
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['multi_module.settings'];
  }

}
