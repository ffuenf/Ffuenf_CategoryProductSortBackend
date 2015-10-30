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
 * @copyright  Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */
class Ffuenf_CategoryProductSortBackend_Helper_Data extends Ffuenf_CategoryProductSortBackend_Helper_Core
{
    /**
     * Path for the config for extension active status.
     */
    const CONFIG_EXTENSION_ACTIVE = 'categoryproductsortbackend/general/enabled';

    /**
     * Variable for if the extension is active.
     *
     * @var bool
     */
    protected $bExtensionActive;

    /**
     * Check to see if the extension is active.
     *
     * @return bool
     */
    public function isExtensionActive()
    {
        if ($this->bExtensionActive === null) {
            $this->bExtensionActive = $this->getStoreFlag(self::CONFIG_EXTENSION_ACTIVE, 'bExtensionActive');
        }

        return $this->bExtensionActive;
    }

    /**
    * Check to see if all products are dsiplayed on the category products grid
    *
    * @return bool
    */
    public function isLimitApplied()
    {
        $params = Mage::app()->getRequest()->getParams();
        return (isset($params['limit']) && 0 === (int) $params['limit']) ? false : true;
    }
}
