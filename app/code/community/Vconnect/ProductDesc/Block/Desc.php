<?php

class Vconnect_ProductDesc_Block_Desc extends Mage_Core_Block_Template
{
    
    private $_href;
    
    /**
     * Get Href
     * 
     * @return string
     */
    public function getHref()
    {
        if (!$this->_href) {
            
            if($this->hasStoreId()) {
                $store = Mage::app()->getStore($this->getStoreId());
            } else {
                $store = Mage::app()->getStore();
            }

            /* @var $store Mage_Core_Model_Store */
            $href = "";
            if ($this->getData('id_path')) {
                /* @var $urlRewriteResource Mage_Core_Model_Mysql4_Url_Rewrite */
                $urlRewriteResource = Mage::getResourceSingleton('core/url_rewrite');
                $href = $urlRewriteResource->getRequestPathByIdPath($this->getData('id_path'), $store);
                if (!$href) {
                    return false;
                }
            }

            $this->_href = $store->getUrl('', array('_direct' => $href));
        }

        if(strpos($this->_href, "___store") === false){
            $symbol = (strpos($this->_href, "?") === false) ? "?" : "&";
            $this->_href = $this->_href . $symbol . "___store=" . $store->getCode();
        }

        return $this->_href;
    } 
    
    /**
     * Return absolute url to the image file.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return Mage::getBaseUrl('media') . $this->getImage();
    }
 
}