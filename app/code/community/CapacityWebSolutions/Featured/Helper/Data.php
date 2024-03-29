<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getStoreViewIds(){
		$allStores = Mage::app()->getStores();
		foreach ($allStores as $_eachStoreId => $val){
			$store_ids[] = Mage::app()->getStore($_eachStoreId)->getId();
		}
		return $store_ids;
	}	
}