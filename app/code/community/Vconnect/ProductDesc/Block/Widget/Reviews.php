<?php

class Vconnect_ProductDesc_Block_Widget_Reviews extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {

    	$products = Mage::getModel('catalog/product')->getCollection();

		$_reviews = Mage::getModel('review/review')
		->getResourceCollection()
		->addStoreFilter(Mage::app()->getStore()->getId())
		->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
		->setDateOrder()
		->addRateVotes();

		$selectedOptionsArray = explode(",",$this->getData('reviews'));
		if (!$selectedOptionsArray) $selectedOptionsJson = '[]';
		else $selectedOptionsJson = json_encode($selectedOptionsArray);

    	$optionsReviews = '';
    	$reviews = array();

    	$productsHavingReviews = array();

		foreach($_reviews as $review){
			$reviews[] = array('value'=>$review->getId(),'label'=>$review->getTitle(),'by'=>$review->getNickname(),'rel'=>$review->getData('entity_pk_value'));
			$reviewId = $review->getId();
			$productsHavingReviews[] = $review->getData('entity_pk_value');
			$isSelected = (in_array($reviewId,$selectedOptionsArray) ? ' selected' : '');
			$selectedOptionsHtml .= '<option ' . $isSelected . ' value="'.$review->getId().'" rel="'.$review->getData('entity_pk_value').'">' . $review->getTitle() . ' by ' . $review->getNickname() . ' (#'.$review->getId().')</option>';
			$optionsReviews .= '<option value="'.$review->getId().'" rel="'.$review->getData('entity_pk_value').'">' . $review->getTitle() . ' by ' . $review->getNickname() . ' (#'.$review->getId().')</option>';
		}
		$reviewsJson = json_encode($reviews);

    	$optionsProducts = '';
    	foreach($products as $product) {
    		$_product = Mage::getModel('catalog/product')->load($product->getId());
    		if (in_array($product->getId(),$productsHavingReviews))
    			$optionsProducts .= '<option value="'.$product->getId().'">'.$_product->getName().' (sku: '.$product->getSku().')</option>';
    	}

		$html = <<<EOF
<td class="label">
<script type="text/javascript">
    Event.observe($('productReviews'), 'change', function() {
    	var productSelected = $('productReviews').getValue();
		var options = {$reviewsJson};
		var selectedOptions = {$selectedOptionsJson};
		var len = options.length;
		//clean the multiselect
		$('productReviewsSelected').innerHTML = '';
		for (var i = 0; i < len; i++) {
			var productRel = options[i].rel;
			if (productRel == productSelected) {
				var option = document.createElement('option');
				option.value = options[i].value;
				option.innerHTML = options[i].label + ' by ' + options[i].by + ' (#' +options[i].value+ ')';
				option.rel = options[i].rel;
		    	$('productReviewsSelected').appendChild(option);
			}
		}
		i=0;
    });

	// Update the input field..
	Event.observe($('productReviewsSelected'), 'change', function() {
		var selected = [];
		$$('#productReviewsSelected option').each(function(elem) {
			if (elem.selected) selected.push(elem.value);
		});
		$('{$element->getHtmlId()}').value = selected.join();//JSON.stringify(selected);
	});
</script>
<label for="">Reviews <span class="required">*</span></label></td>
<td class="value"><select id="productReviews"><option>- product -</option>{$optionsProducts}</select> (filter by product)
<br /><br />
<select id="productReviewsSelect" style="display: none;">
{$optionsReviews}
</select>
<select id="productReviewsSelected" multiple style="width: 300px; height: 100px;">
{$selectedOptionsHtml}
</select>
<br /><em>reviews order:</em> <input id="{$element->getHtmlId()}" name="parameters[reviews]" value="{$element->getValue()}" class="widget-option input-text" type="text">
	</td>
EOF;

    	return $html;
    }

}