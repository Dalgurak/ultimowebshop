<?php

class Vconnect_ProductDesc_Block_Widget_Desc7
    extends Vconnect_ProductDesc_Block_Desc
    implements Mage_Widget_Block_Interface
{
    
    public $benchmarkWidths = array();

    public function getProductId() {
        return str_replace('product/','',$this->getData('id_path'));
    }
    public function getProduct() {
        $id = $this->getProductId();

        $product = Mage::getModel('catalog/product')->load($id);

        return $product;
    }

    public function getRate($value) {
    	$options = Mage::getModel('vconnect_benchmarks/bitem_attribute_source_ratetype')->getAllOptions(false);

    	foreach($options as $opt) {
    		if ($opt['value'] == $value) return $opt['label'];
    	}

    	return;
    }

    public function calcMaxWidth($benchmark) {
    	$bitems = $this->getBitems($benchmark);

    	$maxWidth = 0;

    	foreach($bitems as $bitem) {
    		$rate = $bitem->getRate();
    		if ($maxWidth < $rate) $maxWidth = $rate;
    	}

    	if ($maxWidth < 100) $maxWidth = 100;

    	$this->benchmarkWidths[$benchmark->getId()] = $maxWidth;
    }

    public function _loadBenchmark($benchmarkId) {
        $benchmark     = Mage::getModel('vconnect_benchmarks/benchmark')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($benchmarkId);
        if (!$benchmark->getId()) {
            return false;
        } elseif (!$benchmark->getStatus()) {
            return false;
        }
        return $benchmark;
    }

    public function loadBenchmarks() {

		$product = $this->getProduct();
	
    	$benchmarks = Mage::getModel('vconnect_benchmarks/benchmark')->getCollection()->addProductFilter($product);
						
		foreach($benchmarks as $benchmark) $this->calcMaxWidth($benchmark);

		return $benchmarks;
						
    }

	public function getBitems($benchmark) {
		
		$bitems = Mage::getModel('vconnect_benchmarks/bitem')->getCollection()->addFilter('benchmark_id',$benchmark->getId());
		
		return $bitems;
		
	}

	public function getRateFiller($bi,$benchmark) {
		$maxWidth = $this->benchmarkWidths[$benchmark->getId()];
		$maxWidth = $maxWidth + ($maxWidth/10);
		$rate = $bi->getRate();

		$perc = (($rate/$maxWidth)*100);

		return $perc;
	}

}