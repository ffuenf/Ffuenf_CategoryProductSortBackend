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
class Ffuenf_CategoryProductSortBackend_Adminhtml_CategoryProductSortBackendController extends Mage_Adminhtml_Controller_Action
{
    public function ajaxBlockAction()
    {
        $categoryId = (int) $this->getRequest()->getParam('categoryId');
        $neighborId = (int) $this->getRequest()->getParam('neighbourId');
        $productId = (int) $this->getRequest()->getParam('productId');
        $sortModel = Mage::getModel('ffuenf_categoryproductsortbackend/sorter');
        $_response = $sortModel->changeProductPosition($categoryId, $productId, $neighborId);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($_response));
    }
}
