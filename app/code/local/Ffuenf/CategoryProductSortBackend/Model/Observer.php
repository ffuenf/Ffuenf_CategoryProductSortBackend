<?php
/**
* @category   Ffuenf
* @package    Ffuenf_CategoryProductSortBackend
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
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
    if (Mage::getStoreConfig('categoryproductsortbackend/general/enabled') && $observer->getBlock()->getType() == 'adminhtml/catalog_category_tab_product')
    {
      $content = $observer->getTransport()->getHtml();
      $dom = new DOMDocument('1.0','utf-8');
      $doc = new DOMDocument('1.0','utf-8');
      $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
      foreach ($dom->getElementsByTagName('select') as $element)
      {
        if ($element->getAttribute('name') == 'limit')
        {
          $option = $dom->createElement('option');
          $option->appendChild($dom->createTextNode('All'));
          $option->setAttribute('value', 0);
          $option = $element->appendChild($option);
        }
      }
      $additionalHtml = $this->appendScript($content);
      $additionalDoc = new DOMDocument();
      $additionalDoc->loadHTML($additionalHtml);
      $additionalDocScript = $additionalDoc->getElementsByTagName('script')->item(0);
      $body = $dom->getElementsByTagName('body')->item(0);
      foreach ($body->childNodes as $child)
      {
        $doc->appendChild($doc->importNode($child, true));
      }
      $doc->appendChild($doc->importNode($additionalDocScript, true));
      $content = $doc->saveHTML();
      $observer->getTransport()->setHtml($content);
    }
  }

  public function appendScript($content)
  {
    $this->setTemplate('ffuenf/categoryproductsortbackend/sortable.phtml');
    $additional = $this->toHtml();
    return $additional;
  }
}