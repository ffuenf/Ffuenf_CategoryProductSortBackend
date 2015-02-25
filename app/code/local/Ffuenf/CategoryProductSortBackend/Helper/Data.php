<?php
/**
* @category   Ffuenf
* @package    Ffuenf_CategoryProductSortBackend
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
*/
class Ffuenf_CategoryProductSortBackend_Helper_Data extends Mage_Core_Helper_Abstract
{
  const XML_PATH_CATEGORYPRODUCTSORTBACKEND_ACTIVE_BACKEND = 'catalog/categoryproductsortbackend/active_backend';
  /**
  * @param Mage_Core_Model_Store $store
  * @return bool
  */
  public function isActivated($store = null)
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
