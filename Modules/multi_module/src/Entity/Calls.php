<?php

namespace Drupal\multi_module\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\content_entity_example\ContactInterface;
use Drupal\unserialize\CallsInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * @ingroup multi_module
 *
 * @ContentEntityType(
 *   id = "multi_module_calls",
 *   label = @Translation("Calls entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\multi_module\Controller\CallsListBuilder",
 *     "form" = {
 *       "default" = "Drupal\multi_module\Form\CallsForm",
 *       "delete" = "Drupal\multi_module\Form\CallsDeleteForm",
 *     },
 *     "access" = "Drupal\multi_module\CallsAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "calls",
 *   admin_permission = "administer calls entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "phone" = "phone",
 *     "user" = "user",
 *     "cmd" = "cmd",
 *     "crm_token" = "crm_token",
 *     "callid" = "callid",
 *     "type" = "type",
 *     "status" = "status",
 *     "diversion" = "diversion",
 *     "start" = "start",
 *     "duration" = "duration",
 *     "link" = "link",
 *     "ext" = "ext",
 *     "telnum" = "telnum",
 *     "groupRealName" = "groupRealName",
 *   },
 *   links = {
 *     "canonical" = "/multi_module_calls/{multi_module_calls}",
 *     "edit-form" = "/multi_module_calls/{multi_module_calls}/edit",
 *     "delete-form" = "/calls/{multi_module_calls}/delete",
 *     "collection" = "/multi_module_calls/list"
 *   },
 *   field_ui_base_route = "multi_module.calls_settings",
 * )
 *
 */
class Calls extends ContentEntityBase implements \Drupal\multi_module\CallsInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Contact entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Contact entity.'))
      ->setReadOnly(TRUE);

    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('phone'))
      ->setDescription(t('The phone of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('user'))
      ->setDescription(t('The user of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['cmd'] = BaseFieldDefinition::create('string')
      ->setLabel(t('cmd'))
      ->setDescription(t('The cmd of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['crm_token'] = BaseFieldDefinition::create('string')
      ->setLabel(t('crm_token'))
      ->setDescription(t('The crm_token of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['callid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('callid'))
      ->setDescription(t('The callid of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('type'))
      ->setDescription(t('The type of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('string')
      ->setLabel(t('status'))
      ->setDescription(t('The status of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['diversion'] = BaseFieldDefinition::create('string')
      ->setLabel(t('diversion'))
      ->setDescription(t('The diversion of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['start'] = BaseFieldDefinition::create('string')
      ->setLabel(t('start'))
      ->setDescription(t('The start of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['duration'] = BaseFieldDefinition::create('string')
      ->setLabel(t('duration'))
      ->setDescription(t('The duration of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['link'] = BaseFieldDefinition::create('string')
      ->setLabel(t('link'))
      ->setDescription(t('The link of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['ext'] = BaseFieldDefinition::create('string')
      ->setLabel(t('ext'))
      ->setDescription(t('The ext of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['telnum'] = BaseFieldDefinition::create('string')
      ->setLabel(t('telnum'))
      ->setDescription(t('The telnum of the calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['groupRealName'] = BaseFieldDefinition::create('string')
      ->setLabel(t('groupRealName'))
      ->setDescription(t('The groupRealName of the Calls entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])

      ->setDefaultValue('NULL')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of call entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
