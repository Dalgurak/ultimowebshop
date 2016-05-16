<?php

class Vconnect_ProductDesc_Block_Widget_Wysiwyg extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $editor = new Varien_Data_Form_Element_Editor($element->getData());

        // Prevent foreach error
        $editor->getConfig()->setPlugins(array());

        $editor->setId($element->getId());
        $editor->setForm($element->getForm());
        
        $value = $editor->getValue();
        $value = str_replace('"', "'",$value);
        
        $editor->setValue($value);
        
        $editor->setForceLoad(true);

        return parent::render($editor);
    }

}