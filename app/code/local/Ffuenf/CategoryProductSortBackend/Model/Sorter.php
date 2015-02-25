<?php
/**
* @category   Ffuenf
* @package    Ffuenf_CategoryProductSortBackend
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
*/
class Ffuenf_CategoryProductSortBackend_Model_Sorter extends Mage_Core_Model_Abstract
{
  public function changeProductPosition($categoryId, $productId, $neighborId) {
    $modified = 0;
    $category = Mage::getModel('catalog/category')->load($categoryId);
    /* @var $category Mage_Catalog_Model_Category */
    $oldPositions = $category->getProductsPosition();
    $positions = array_keys($oldPositions);
    if (!in_array($productId, $positions) || !in_array($neighborId, $positions)) {
      return array(
        'categoryId' => $categoryId,
        'productId' => $productId,
        'neighborId' => $neighborId,
        'error' => Mage::helper('ffuenf_categoryproductsortbackend')->__('Product not found')
      );
    }
    array_multisort($oldPositions, $positions);
    $posProductId = array_search($productId, $positions);
    $posNeighborId = array_search($neighborId, $positions);
    unset($positions[$posProductId]);
    $firstPart = array_slice($positions, 0, $posNeighborId);
    array_push($firstPart, $productId);
    $positions = array_flip(array_merge($firstPart, array_slice($positions, $posNeighborId)));
    if ($oldPositions != $positions) {
      $category->setPostedProducts($positions);
      $category->save();
    }
    return $positions;
  }
}
