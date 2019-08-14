<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Block_Adminhtml_Featured_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		$this->_blockGroup = 'featured';
		$this->_controller = 'adminhtml_featured';
		$this->_updateButton('save', 'label','Save');
		$this->_updateButton('delete','label','Delete');
		$this->_addButton('save_and_continue', array(
             'label' => Mage::helper('featured')->__('Save And Continue Edit'),
             'onclick' => 'saveAndContinueEdit()',
             'class' => 'save' 
         ), -100);
		
         $this->_formScripts[] = "
            function saveAndContinueEdit(){
				editForm.submit($('edit_form').action + 'back/edit/');
            }
			 
			 ";
		$this->setId('featured_edit');
	}
	
	public function getHeaderText()
    {
        if( Mage::registry('featured_data') && Mage::registry('featured_data')->getFeaturedId() ) {
            return Mage::helper('featured')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('featured_data')->getSku()));
        } else {
            return Mage::helper('featured')->__('Select Products');
        }
    }	
}