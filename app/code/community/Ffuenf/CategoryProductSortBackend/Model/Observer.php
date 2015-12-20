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
 *
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */
class Ffuenf_CategoryProductSortBackend_Model_Observer extends Mage_Core_Block_Template
{
    /**
     * Appends the "sortable" js code to the bottom of ajax-Request for the category-products loaded after
     * changing sort order.
     *
     * @param Varien_Event_Observer $observer
     */
    public function addSortableScriptOnGrid(Varien_Event_Observer $observer)
    {
        $_block = $observer->getBlock();
        $_type = $_block->getType();
        if (Mage::helper('ffuenf_categoryproductsortbackend')->isExtensionActive() && $_type == 'adminhtml/catalog_category_tab_product') {
            $content = $observer->getTransport()->getHtml();
            $dom = new DOMDocument('1.0', 'utf-8');
            $doc = new DOMDocument('1.0', 'utf-8');
            $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
            foreach ($dom->getElementsByTagName('select') as $element) {
                if ($element->getAttribute('name') == 'limit') {
                    $option = $dom->createElement('option');
                    $option->appendChild($dom->createTextNode('All'));
                    $option->setAttribute('value', 0);
                    $option = $element->appendChild($option);
                }
            }
            $body = $dom->getElementsByTagName('body')->item(0);
            foreach ($body->childNodes as $child) {
                $doc->appendChild($doc->importNode($child, true));
            }
          if (!Mage::helper('ffuenf_categoryproductsortbackend')->isLimitApplied()) {
              $additionalHtml = $this->appendScript($content);
              $additionalDoc = new DOMDocument();
              $additionalDoc->loadHTML($additionalHtml);
              $additionalDocScript = $additionalDoc->getElementsByTagName('script')->item(0);
            $doc->appendChild($doc->importNode($additionalDocScript, true));
          }
            $content = $doc->saveHTML();
            $observer->getTransport()->setHtml($content);
        }
    }

    /**
     * Appends the "sortable" js code to the bottom of ajax-Request for the category-products loaded after
     * changing sort order.
     *
     * @param Varien_Event_Observer $observer
     */
  public function appendScript()
    {
        $this->setTemplate('ffuenf/categoryproductsortbackend/sortable.phtml');
        $additional = $this->toHtml();
        return $additional;
    }

    /**
    * Adds the "Batch-Reset Positions" Button to the category products grid if all products are displayed
    *
    * @param Varien_Event_Observer $observer
    */
    public function addBatchSortOnGrid(Varien_Event_Observer $observer)
    {
        $_block = $observer->getBlock();
        $_type = $_block->getType();
        if (Mage::getStoreConfig('categoryproductsortbackend/general/enabled') && $_type == 'adminhtml/catalog_category_tab_product' && !Mage::helper('ffuenf_categoryproductsortbackend')->isLimitApplied()) {
            $_manualSortButton = $_block->getChild('reset_filter_button');
            $_block->setChild('batch_sort_button',
                $_block->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
                        'label' => Mage::helper('ffuenf_categoryproductsortbackend')->__('Batch-Reset Positions'),
                        'onclick' => 'batchSort();',
                        'class' => 'task batch_sort'
                    )
                )
            );
            $_manualSortButton->setBeforeHtml($_block->getChild('batch_sort_button')->toHtml());
        }
    }
}
