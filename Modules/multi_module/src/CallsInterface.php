<?php

namespace Drupal\multi_module;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * @ingroup multi_module
 */
  interface CallsInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
