<?php

class Vconnect_ProductDesc_Model_Catalog_Template_Filter extends Mage_Catalog_Model_Template_Filter
{
	public function blockDirective($construction)
	{
		$model = Mage::getModel('core/email_template_filter');
		return $model->blockDirective($construction);
	}

	public function widgetDirective($construction)
	{
		$construction[2] .= sprintf(' store_id ="%s"', Mage::app()->getStore()->getStoreId());
		$model = Mage::getModel('widget/template_filter');
		return $model->widgetDirective($construction);
	}
}