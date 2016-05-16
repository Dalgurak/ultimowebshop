<?php

class Vconnect_ProductDesc_Block_Widget_Attributes extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
		$html = '<tr>';
			$html .= '<td class="label">Available Attributes</label></td>';
			$html .= '<td class="value">';
	
		$attributes = Mage::getResourceModel('catalog/product_attribute_collection')->getItems();

		$selectedOptionsArray = explode(",",$this->getData('attributes'));
		if (!$selectedOptionsArray) $selectedOptionsJson = '[]';
		else $selectedOptionsJson = json_encode($selectedOptionsArray);
		
		foreach ($attributes as $attribute){
			$html .= $attribute->getAttributecode().' ('.$attribute->getFrontendLabel().'), ';
		}
			$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
			$html .= '<td class="label">Used Attributes</label></td>';
			$html .= '<td class="value">';
					$html .= '<textarea name="parameters[attributes]" style="width: 100%; min-height: 50px;">'.$element->getValue().'</textarea>';
			$html .= '</td>';
		$html .= '</tr>';

    	return $html;
    }

}