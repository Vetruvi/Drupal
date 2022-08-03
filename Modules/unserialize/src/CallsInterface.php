<?php

namespace Drupal\unserialize;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * @ingroup unserialize
 */
  interface CallsInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
