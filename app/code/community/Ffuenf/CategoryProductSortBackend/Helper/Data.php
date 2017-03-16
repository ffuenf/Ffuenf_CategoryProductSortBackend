<?php
/**
 * Ffuenf_CategoryProductSortBackend extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 *
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2017 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
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
