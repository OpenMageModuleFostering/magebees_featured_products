<?php
/***************************************************************************
 Extension Name	: Featured Products
 Extension URL	: http://www.magebees.com/magento-featured-products-extension.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_Featured_Block_Adminhtml_Featured_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(
				array(
					'id'=>'edit_form',
					'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
					'method'=>'post',
					'enctype' => 'multipart/form-data'
					)
				);
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}
