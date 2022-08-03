<?php
//Путь к папке с кодом
namespace Drupal\multi_module\Form;
//Файлы с кодом из которых будут наследоватся методы для создания кнопок
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
//Класс в котором создаются кнопки наследует методы из FormBase
class ChangeModForm extends FormBase {
//Возврат названия формы
  public function getFormId() {
    return 'multi_module_form';
  }
  //Функция реализующая создание форм в данном случае кнопок
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions']['submit1'] = [
      '#type' => 'submit', //Тип формы
      '#value' => $this->t('Десереализация файлов'), //Название кнопки
      "#weight" => 1, //Приоритетность формы (насколько она будет стоять впереди в даннос случае) чем больше показатель тем больше приоритет
      '#limit_validation_errors' => array() //Проверяет были ли задействованы другие формы (в данном случае не используется так как не нужен)
    ];
    $form['actions']['submit2'] = [
      '#type' => 'submit',
      '#value' => $this->t('Отправка сообщений через чат бота в WhatsApp'),
      "#weight" => 1,
      '#submit' => array([$this, 'submitFormTwo']),//Указание на то какую функцию будет использовать данная форма
      '#limit_validation_errors' => array()
    ];
    $form['actions']['submit3'] = [
      '#type' => 'submit',
      '#value' => $this->t('Распазнавание текста на изображении'),
      "#weight" => 1,
      '#submit' => array([$this, 'submitFormThree']),
      '#limit_validation_errors' => array()
    ];
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //Функция для проверки форм на исполнение какого либо условия в данном случае не используется
  }
  //Функции для определения действия при нажатии кнопок
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('multi_module.route');
  }

  public function submitFormTwo(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('multi_module.sender');
  }

  public function submitFormThree(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('multi_module.OCR_form');
  }
}
