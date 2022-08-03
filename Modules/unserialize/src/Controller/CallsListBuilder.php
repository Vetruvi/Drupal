<?php

namespace Drupal\unserialize\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;


/**
 * @ingroup unserialize
 */
class CallsListBuilder extends EntityListBuilder {

  /**
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  /**
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }


  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('Content Entity calls implements a Contacts model. These contacts are fieldable entities. You can manage the fields on the <a href="@adminlink">Calls admin page</a>.', [
        '@adminlink' => $this->urlGenerator->generateFromRoute('unserialize.calls_settings'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Call ID');
    $header['phone'] = $this->t('phone');
    $header['user'] = $this->t('user');
    $header['cmd'] = $this->t('cmd');
    $header['crm_token'] = $this->t('crm_token');
    $header['callid'] = $this->t('callid');
    $header['type'] = $this->t('type');
    $header['status'] = $this->t('status');
    $header['diversion'] = $this->t('diversion');
    $header['start'] = $this->t('start');
    $header['duration'] = $this->t('duration');
    $header['link'] = $this->t('link');
    $header['ext'] = $this->t('ext');
    $header['telnum'] = $this->t('telnum');
    $header['groupRealName'] = $this->t('groupRealName');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\unserialize\Entity\Calls */
    session_start();
    $config = \Drupal::config('unserialize.settings');
    $Route = $config->get('Unserialize.Route');
    $Delete = ['GET  a:0:{}', 'POST ', "\n"];
    $handle = fopen($Route, "r");
    $text = fread($handle, filesize($Route));
    fclose($handle);
    $handle = fopen($Route, 'w');
    fwrite($handle, str_replace($Delete, '', $text));
    $res = file_get_contents($Route);
    $under = unserialize($res);
    $new = array_slice($under, 0, 1);
    $string = implode($new);
    $new1 = array_slice($under, 1, 1);
    $string1 = implode($new1);
    $new2 = array_slice($under, 2, 1);
    $string2 = implode($new2);
    $new3 = array_slice($under, 3, 1);
    $string3 = implode($new3);
    $new4 = array_slice($under, 4, 1);
    $string4 = implode($new4);
    $new5 = array_slice($under, 5, 1);
    $string5 = implode($new5);
    $new6 = array_slice($under, 6, 1);
    $string6 = implode($new6);
    $new7 = array_slice($under, 7, 1);
    $string7 = implode($new7);
    $new8 = array_slice($under, 8, 1);
    $string8 = implode($new8);
    $new9 = array_slice($under, 9, 1);
    $string9 = implode($new9);
    $new10 = array_slice($under, 10, 1);
    $string10 = implode($new10);
    $new11 = array_slice($under, 11, 1);
    $string11 = implode($new11);
    $new12 = array_slice($under, 12, 1);
    $string12 = implode($new12);
    $new13 = array_slice($under, 13, 1);
    if (!empty($new13)){
      $string13 = implode($new13);
    }else{
      $string13 = '';
    }
    $row['id'] = $entity->id();
    $row['phone'] = $entity->phone -> value;
    $row['user'] = $entity-> user ->value;
    $row['cmd'] = $entity-> cmd ->value;
    $row['crm_token'] = $entity->crm_token ->value;
    $row['callid'] = $entity->callid  ->value;
    $row['type'] = $entity->type  ->value;
    $row['status'] = $entity->status ->value;
    $row['diversion'] = $entity->diversion  ->value;
    $row['start'] = $entity->start  ->value;
    $row['duration'] = $entity->duration  ->value;
    $row['link'] = $entity->link  ->value;
    $row['ext'] = $entity->ext  ->value;
    $row['telnum'] = $entity->telnum ->value;
    $row['groupRealName'] = $entity->groupRealName  ->value;
    $config2 = \Drupal::config('unserialize.settings');
    $Id = $config2->get('Unserialize.Id');

    $query = \Drupal::database()->update('calls');
    $query->fields([
      'phone' => $string,
      'user' => $string1,
      'cmd' => $string2,
      'crm_token' => $string3,
      'callid' => $string4,
      'type' => $string5,
      'status' => $string6,
      'diversion' => $string7,
      'start' => $string8,
      'duration' => $string9,
      'link' => $string10,
      'ext' => $string11,
      'telnum' => $string12,
      'groupRealName' => $string13,
    ]);
    $max_Id = (int) $Id + 1;
    //$count = $result123+1;
    $query->condition('id', $max_Id, '=');
    $query->execute();
    return $row + parent::buildRow($entity);
  }

}
