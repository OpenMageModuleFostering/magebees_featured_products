<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Model_Mysql4_Featured extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('featured/featured', 'featured_id');
    }
	
	/* protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{
		parent::_beforeSave($object);
		echo "<pre>";
		print_r(get_class_methods($object));
		print_r($object->getData());
		exit;
		
		
		return $this;
	} */
}