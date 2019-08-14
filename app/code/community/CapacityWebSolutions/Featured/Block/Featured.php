<?php
/***************************************************************************
	@extension	: Featured Products.
	@copyright	: Copyright (c) 2015 Capacity Web Solutions.
	( http://www.capacitywebsolutions.com )
	@author		: Capacity Web Solutions Pvt. Ltd.
	@support	: magento@capacitywebsolutions.com	
***************************************************************************/

class CapacityWebSolutions_Featured_Block_Featured extends Mage_Catalog_Block_Product_Abstract 
{
	/**
     * Name of request parameter for page number value
     */
    const PAGE_VAR_NAME                     = 'np';
	
	public function __construct() {
		parent::_construct();
		$this->addColumnCountLayoutDepend('empty', 6)
            ->addColumnCountLayoutDepend('one_column', 5)
            ->addColumnCountLayoutDepend('two_columns_left', 4)
            ->addColumnCountLayoutDepend('two_columns_right', 4)
            ->addColumnCountLayoutDepend('three_columns', 3);
		
		$this->setStoreId(Mage::app()->getStore()->getId());
		
		//General Settings
		$this->setEnabled((bool)Mage::getStoreConfig("featured/general/enabled"));
		$this->setDisplayHeading((bool)Mage::getStoreConfig("featured/general/display_heading"));
		$this->setHeading(Mage::getStoreConfig("featured/general/heading"));
		$this->setChooseProducts(Mage::getStoreConfig("featured/general/choose_products"));
		$this->setDisplayBy(Mage::getStoreConfig("featured/general/display_by"));
		$this->setCategories(Mage::getStoreConfig("featured/general/categories"));
		$this->setSortBy(Mage::getStoreConfig("featured/general/sort_by"));
		$this->setSortOrder(Mage::getStoreConfig("featured/general/sort_order"));
		$this->setProductsPrice((bool)Mage::getStoreConfig("featured/general/products_price"));
		$this->setReview((bool)Mage::getStoreConfig("featured/general/review"));
		$this->setShortDesc((bool)Mage::getStoreConfig("featured/general/short_desc"));
		$this->setDescLimit((int)Mage::getStoreConfig("featured/general/desc_limit"));
		$this->setAddToCart((bool)Mage::getStoreConfig("featured/general/add_to_cart"));
		$this->setAddToWishlist((bool)Mage::getStoreConfig("featured/general/add_to_wishlist"));
		$this->setAddToCompare((bool)Mage::getStoreConfig("featured/general/add_to_compare"));
		$this->setOutOfStock((bool)Mage::getStoreConfig("featured/general/out_of_stock"));
		$this->setIsResponsive((bool)Mage::getStoreConfig('featured/general/isresponsive'));
		
		//Template Settings
		$this->setCustomTemplate(Mage::getStoreConfig("featured/template/select_template"));
		$this->setProductsCount((int)Mage::getStoreConfig("featured/template/number_of_items"));
		$this->setShowPager((bool)Mage::getStoreConfig("featured/template/show_pager"));
		$this->setProductsPerPage((int)Mage::getStoreConfig("featured/template/products_per_page"));
		$this->setHeight((int)Mage::getStoreConfig("featured/template/thumbnail_height"));
		$this->setWidth((int)Mage::getStoreConfig("featured/template/thumbnail_width"));
	}

	public function setWidgetOptions(){
		//General Settings
		$this->setDisplayHeading((bool)$this->getWdDisplayHeading());
		$this->setHeading($this->getWdHeading());
		$this->setChooseProducts($this->getWdChooseProducts());
		$this->setDisplayBy((int)$this->getWdDisplayBy());
		$this->setCategories($this->getWdCategories());
		$this->setSortBy($this->getWdSortBy());
		$this->setSortOrder($this->getWdSortOrder());
		$this->setProductsPrice((bool)$this->getWdProductsPrice());
		$this->setReview((bool)$this->getWdReview());
		$this->setShortDesc((bool)$this->getWdShortDesc());
		$this->setDescLimit((int)$this->getWdDescLimit());
		$this->setAddToCart((bool)$this->getWdAddToCart());
		$this->setAddToWishlist((bool)$this->getWdAddToWishlist());
		$this->setAddToCompare((bool)$this->getWdAddToCompare());
		$this->setOutOfStock((bool)$this->getWdOutOfStock());
		
		//Template Settings
		$this->setProductsCount((int)$this->getWdNumberOfItems());
		$this->setShowPager((bool)$this->getWdShowPager());
		$this->setProductsPerPage((int)$this->getWdProductsPerPage());
		$this->setHeight((int)$this->getWdThumbnailHeight());
		$this->setWidth((int)$this->getWdThumbnailWidth());
	}
	
	protected function _getProductCollection()  {
		$collection = $this->_getFeaturedProductsCollection();
		$storeId    = Mage::app()->getStore()->getId();
		$collection ->addMinimalPrice()
					->addFinalPrice()
					->setStore($storeId)
					->addStoreFilter($storeId)
					->setPageSize($this->getProductsCount())
					->setCurPage(1)
				;
					
		//Display out of stock products
		if(!$this->getOutOfStock()){
			Mage::getSingleton('cataloginventory/stock')
				->addInStockFilterToCollection($collection);
		}
			
		//Display By Category
		if($this->getDisplayBy()==2){
			$categorytable = Mage::getSingleton('core/resource')->getTableName('catalog_category_product');
			$collection->getSelect()
						->joinLeft(array('at_category_id' => $categorytable),'e.entity_id = at_category_id.product_id','at_category_id.category_id')
						->group('e.entity_id')
						->where("at_category_id.category_id IN (".$this->getCategories().")")
					;
		}
						
		//Set Sort Order
		if($this->getSortOrder()=='rand'){
			$collection->getSelect()->order('rand()');
		}else{
			$collection->addAttributeToSort($this->getSortBy(), $this->getSortOrder());
		}
	
		return $collection;
    }

	/**
     * Prepare collection with featured products
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml(){
		if($this->getType()=="featured/widget")
		{
			$this->setWidgetOptions();
		}
        $this->setProductCollection($this->_getProductCollection());
	}
	
	protected function _getFeaturedProductsCollection(){
		/** @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());

        $collection = $this->_addProductAttributesAndPrices($collection)
			->addAttributeToFilter('sku', array('in' => $this->getSkus()));
		return $collection;
    }
	
	public function getSkusArr($element){
		return $element['sku'];
	}
	
	public function getSkus(){
		//$store_id =  Mage::app()->getRequest()->getParam('store',0);
		$store_id =  $this->getStoreId();
		$featuredCollection = Mage::getModel('featured/featured')->getCollection()->addFieldToFilter('store_id', array(array('finset' => $store_id)));
		$product_skus=array_map(array($this,"getSkusArr"), $featuredCollection->getData());
		return $product_skus;
	}
	
	public function limit_word($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
		  $words = str_word_count($text, 2);
		  $pos = array_keys($words);
		  $text = substr($text, 0, $pos[$limit]) . '...';
		}
		return $text;
    }
	
	public function _toHtml(){	
		if (!$this->getEnabled()) {
            return '';
        }
		if(!$this->getTemplate()){
			if($this->getCustomTemplate()==2){
				$this->setTemplate('featured/featured-list.phtml');
			}else{
				$this->setTemplate('featured/featured-grid.phtml');
			}
		}
        return parent::_toHtml();
    }
	
	/**
     * Render pagination HTML
     *
     * @return string
     */
    public function getPagerHtml()
    {
        if ($this->getShowPager()) {
            if (!$this->_pager) {
                $this->_pager = $this->getLayout()
                    ->createBlock('featured/widget_html_pager', 'widget.featured.product.list.pager');
				
                $this->_pager->setUseContainer(true)
                    ->setShowAmounts(true)
                    ->setShowPerPage(false)
                    ->setPageVarName(self::PAGE_VAR_NAME)
                    ->setLimit($this->getProductsPerPage())
                    ->setTotalLimit($this->getProductsCount())
                    ->setCollection($this->getProductCollection());
            }
            if ($this->_pager instanceof Mage_Core_Block_Abstract) {
                return $this->_pager->toHtml();
            }
        }
        return '';
    }

}
