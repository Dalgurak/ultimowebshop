<?php

class Vconnect_ProductDesc_Block_Widget_Desc4
    extends Vconnect_ProductDesc_Block_Desc
    implements Mage_Widget_Block_Interface
{

    public function getText()
    {
        return nl2br(parent::getText());
    }

    public function getProductId() {
        return str_replace('product/','',$this->getData('id_path'));
    }
    public function getProduct() {
        $id = $this->getProductId();

        $product = Mage::getModel('catalog/product')->load($id);

        return $product;
    }


/**
     * Retrieve gallery url
     *
     * @param null|Varien_Object $image
     * @return string
     */
    public function getGalleryUrl($image = null)
    {
        $params = $this->getProductId();
        if ($image) {
            $params['image'] = $image->getValueId();
        }
        return $this->getUrl('catalog/product/gallery', $params);
    }

    /**
     * Retrieve gallery image url
     *
     * @param null|Varien_Object $image
     * @return string
     */
    public function getGalleryImageUrl($image)
    {
        if ($image) {
            $helper = $this->helper('catalog/image')
                ->init($this->getProduct(), 'image', $image->getFile())
                ->keepFrame(false);

            $size = Mage::getStoreConfig(Mage_Catalog_Helper_Image::XML_NODE_PRODUCT_BASE_IMAGE_WIDTH);
            if (is_numeric($size)) {
                $helper->constrainOnly(true)->resize($size);
            }
            return (string)$helper;
        }
        return null;
    }

    /**
     * Retrieve visibility of gallery image based on gallery filter where present
     *
     * @param null|Varien_Object $image
     * @return bool
     */
    public function isGalleryImageVisible($image)
    {
        if (($filterClass = $this->getGalleryFilterHelper()) && ($filterMethod = $this->getGalleryFilterMethod())) {
            return Mage::helper($filterClass)->$filterMethod($this->getProduct(), $image);
        }
        return true;
    }


	public function getMediaGalleryImages() {

        $product = $this->getProduct();

        $collection = $product->getMediaGalleryImages();
		
        return $collection;
	}

}