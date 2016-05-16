<?php

class Vconnect_ProductDesc_Block_Widget_Desc5
    extends Vconnect_ProductDesc_Block_Desc
    implements Mage_Widget_Block_Interface
{

    public function getProductId() {
        return str_replace('product/','',$this->getData('id_path'));
    }
    public function getProduct() {
        $id = $this->getProductId();

        $product = Mage::getModel('catalog/product')->load($id);

        return $product;
    }

	public function getStartingFrom() {
		$product = $this->getProduct();

		$finalPrice = $product->getFinalPrice();

		return Mage::helper('core')->currency($finalPrice, true, false);
	}

	public function displayMenu() {

		$menu = $this->getAnchors();

		$_proId  = Mage::registry('current_product')->getId();;
		$_product= Mage::getModel('catalog/product')->load($_proId);
		$isConfigurable = $_product->getData('is_configurable');

		$items = explode(",", $menu);

		$html = '';

		foreach($items as $item) {
			$itemData = explode("#",$item);

			if ($itemData[1] == "konfig") {
				if ($isConfigurable) {
					$html .= '<li class="kfgt"><a onclick="Effect.ScrollTo(\''.$itemData[1].'\'); return false;" href="#'.$itemData[1].'">'.$itemData[0].'</a></li>';
				} else {
					$html .= '<li class="kfgt"><a href="/checkout/cart/add?product='.$_product->getId().'&qty=1&form_key='.Mage::getSingleton('core/session')->getFormKey().'">Køb</a></li>';
				}
			}
			else {
				$html .= '<li><a onclick="Effect.ScrollTo(\''.$itemData[1].'\'); return false;" href="#'.$itemData[1].'">'.$itemData[0].'</a></li>';
			}
		}

		return $html;
	}
    
}