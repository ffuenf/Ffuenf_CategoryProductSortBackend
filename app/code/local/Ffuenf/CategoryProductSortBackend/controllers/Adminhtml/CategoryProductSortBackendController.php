<?php
/**
* @category   Ffuenf
* @package    Ffuenf_CategoryProductSortBackend
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
*/
class Ffuenf_CategoryProductSortBackend_Adminhtml_CategoryProductSortBackendController extends Mage_Adminhtml_Controller_Action
{
  public function ajaxBlockAction(){
    $categoryId = (int) $this->getRequest()->getParam('categoryId');
    $neighborId = (int) $this->getRequest()->getParam('neighbourId');
    $productId = (int) $this->getRequest()->getParam('productId');
    $sortModel = Mage::getModel('ffuenf_categoryproductsortbackend/sorter');
    $_response = $sortModel->changeProductPosition($categoryId, $productId, $neighborId);
    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($_response));
  }
}