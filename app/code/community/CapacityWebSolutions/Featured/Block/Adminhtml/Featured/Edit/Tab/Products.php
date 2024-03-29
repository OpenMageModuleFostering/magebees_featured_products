<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Block_Adminhtml_Featured_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Form
{
	public function __construct() {
		parent::__construct();
		$this->setTemplate('featured/product.phtml');
	}
	
	public function getSkusArr($element){
		return $element['sku'];
	}

	public function getSkusString() {
		$store_id =  Mage::app()->getRequest()->getParam('store',0);
		$featuredCollection = Mage::getModel('featured/featured')->getCollection()->addFieldToFilter('store_id', array(array('finset' => $store_id)));
		$product_skus_arr = array_map(array($this,"getSkusArr"), $featuredCollection->getData());
		$product_skus = implode(", ",$product_skus_arr);
		return $product_skus;
	}

}