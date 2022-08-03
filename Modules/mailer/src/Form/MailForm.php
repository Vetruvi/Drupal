<?php  

namespace Drupal\mailer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Url;

class MailForm extends ConfigFormBase {
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
    $config = $this->config('mailer.settings');
    $form['mail_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Номер блока дял отправки'),
      '#default_value' => $config->get('Mail.Mail_id')
    );
    $form['mail_bot_id']= array(
      '#type' => 'textfield',
      '#attributes' => array(
        ' type' => 'number',
    ),
      '#title' => $this->t('Идентификатор вотсап бота, от которого нужно отправить сообщение'),
      '#default_value' => $config->get('Mail.Mail_bot_id')
    );
    $form['attachment_url']= array(
      '#type' => 'textfield',
      '#title' => $this->t('url файла'),
      '#default_value' => $config->get('Mail.attachment_url')
    );
    $form['attachment_type']= array(
      '#type' => 'textfield',
      '#title' => $this->t('тип отображения файла'),
      '#default_value' => $config->get('Mail.attachment_type')
    );
    $form['phone']= array(
      '#type' => 'textfield',
      '#title' => $this->t('Номер телефона'),
      '#default_value' => $config->get('Mail.phone')
    );
    $form['key_api']= array(
      '#type' => 'textfield',
      '#title' => $this->t('Ключ api'),
      '#default_value' => $config->get('Mail.key_api')
    );
    $form['route_csv']= array(
      '#type' => 'textfield',
      '#title' => $this->t('путь к файлу csv'),
      '#default_value' => $config->get('Mail.csv')
    );
    $form['txt_pattern']= array(
      '#type' => 'textfield',
      '#title' => $this->t('путь к txt файлу с шаблоном'),
      '#default_value' => $config->get('Mail.txt')
    );
    $form['massage_text']= array(
      '#type' => 'textarea',
      '#title' => $this->t('текст сообщения'),
      '#default_value' => $config->get('Mail.Text')
    );
    $form['actions']['submit1'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send mail'),
      "#weight" => 1,
      '#submit' => array([$this, 'submitFormOne']),
      '#limit_validation_errors' => array()
    ];
    $form['actions']['submit2'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send info of csv file'),
      "#weight" => 2,
      '#submit' => array([$this, 'submitFormTwo']),
      '#limit_validation_errors' => array()
    ];

    return parent::buildForm($form, $form_state);
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('mailer.settings');
    $config->set('Mail.Mail_id', $form_state->getValue('mail_id'));
    $config->set('Mail.Mail_bot_id', $form_state->getValue('mail_bot_id'));
	  $config->set('Mail.attachment_url', $form_state->getValue('attachment_url'));
	  $config->set('Mail.attachment_type', $form_state->getValue('attachment_type'));
	  $config->set('Mail.phone', $form_state->getValue('phone'));
	  $config->set('Mail.csv', $form_state->getValue('route_csv'));
    $config->set('Mail.txt', $form_state->getValue('txt_pattern'));
    $config->set('Mail.key_api', $form_state->getValue('key_api'));
	  $config->set('Mail.Text', $form_state->getValue('massage_text'));
    $config->save();
    return parent::submitForm($form, $form_state);   
  }
  /**
   * {@inheritdoc}
   */
    public function submitFormOne(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('mailer.content');
    parent::submitForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitFormTwo(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('mailer.csv');
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */


  protected function getEditableConfigNames() {
    return ['mailer.settings'];
  }


}

?>