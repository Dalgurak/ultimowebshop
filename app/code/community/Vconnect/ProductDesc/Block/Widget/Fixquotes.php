<?php

class Vconnect_ProductDesc_Block_Widget_Fixquotes extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {

		$html = <<<EOF
<td class="label">
<script type="text/javascript">

typeIn = function(event) {
	var element = Event.element(event);
    var str = element.value;
	console.log('typing');
	if(str.indexOf('"') > -1){
		str = str.replace('"','&quot;');
		str = str.replace('"','&quot;');
		str = str.replace('"','&quot;');
		str = str.replace('"','&quot;');
	}
    element.value = str;
};

$$('#widget_options textarea').each(function(s){ s.observe('keyup', typeIn); });

</script>
fq
</td>
<td class="value">
&nbsp;
</td>
EOF;

    	return $html;
    }

}