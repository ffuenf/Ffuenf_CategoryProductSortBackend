<?php
/**
 * Ffuenf_CategoryProductSortBackend extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 * @package    Ffuenf_CategoryProductSortBackend
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
*/

class Ffuenf_CategoryProductSortBackend_Helper_Data extends Mage_Core_Helper_Abstract
{
  /**
   * Path for the config for extension active status
   */
  const CONFIG_EXTENSION_ACTIVE = 'categoryproductsortbackend/general/enabled';

  /**
   * Variable for if the extension is active
   *
   * @var bool
   */
  protected $bExtensionActive;

  /**
   * Check to see if the extension is active
   *
   * @return bool
   */
  public function isExtensionActive()
  {
  if ($this->bExtensionActive === null) {
      $this->bExtensionActive = Mage::getStoreConfig(self::CONFIG_EXTENSION_ACTIVE);
  }
  return $this->bExtensionActive;
  }

  {
    if (Mage::getDesign()->getArea() == 'adminhtml') {
      return Mage::getStoreConfig(self::XML_PATH_CATEGORYPRODUCTSORTBACKEND_ACTIVE_BACKEND);
    }
    if (is_null($store)) {
      $store = Mage::app()->getStore();
    }
    if (!$store instanceof Mage_Core_Model_Store) {
      $store = Mage::app()->getStore($store);
    }
    return true;
  }
}
