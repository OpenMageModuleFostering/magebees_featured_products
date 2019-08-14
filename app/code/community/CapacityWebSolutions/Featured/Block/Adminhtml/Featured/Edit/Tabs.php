<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Block_Adminhtml_Featured_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('featured_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Featured Information');
    }
    
	protected function _beforeToHtml()
    {
	  	$this->addTab('product_section', array(
            'label'     => Mage::helper('featured')->__('Products'),
            'title'     => Mage::helper('featured')->__('Products'),
            'content'   => $this->getLayout()->createBlock('featured/adminhtml_featured_edit_tab_products')->toHtml(),
        ));
			
		return parent::_beforeToHtml();
    }
}