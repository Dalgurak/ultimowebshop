<?php

class Vconnect_ProductDesc_Block_Widget_Desc8
    extends Vconnect_ProductDesc_Block_Desc
    implements Mage_Widget_Block_Interface
{
    
	public $product = null;
	
    public $benchmarkWidths = array();

    public function getProductId() {
        return str_replace('product/','',$this->getData('id_path'));
    }
    public function getProduct() {
        $id = intval($this->getProductId());
        $this->product = Mage::getModel('catalog/product')->load($id);
		
        return $this->product;
    }
	
	public function getAttributes() {
		return $this->product->getAttributes();
	}
    

}