<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Block_Widget extends CapacityWebSolutions_Featured_Block_Featured // Mage_Core_Block_Template
 implements Mage_Widget_Block_Interface
{
    public function addData(array $arr){
        $this->_data = array_merge($this->_data, $arr);
    }

    public function setData($key, $value = null){
        $this->_data[$key] = $value;
    }
 
    public function _toHtml(){
		if($this->getData('template')){
			$this->setTemplate($this->getData('template'));
		}
		return parent::_toHtml();
	}
}
