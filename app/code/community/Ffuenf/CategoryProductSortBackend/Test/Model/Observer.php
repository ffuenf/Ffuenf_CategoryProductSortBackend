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

class Ffuenf_CategoryProductSortBackend_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * Tests whether extension model aliases are returning the correct class names
     *
     * @test
     */
    public function testModelAlias()
    {
        $this->assertModelAlias(
            'ffuenf_categoryproductsortbackend/observer',
            'Ffuenf_CategoryProductSortBackend_Model_Observer'
        );
    }

    /**
     * Tests whether extension adminhtml observers are defined
     *
     * @test
     */
    public function testAdminHtmlEventObservers()
    {
        $this->assertEventObserverDefined(
            'adminhtml',
            'core_block_abstract_to_html_after',
            'ffuenf_categoryproductsortbackend/observer',
            'addSortableScriptOnGrid'
        );
        $this->assertEventObserverDefined(
            'adminhtml',
            'core_block_abstract_prepare_layout_after',
            'ffuenf_categoryproductsortbackend/observer',
            'addBatchSortOnGrid'
        );
    }
}
