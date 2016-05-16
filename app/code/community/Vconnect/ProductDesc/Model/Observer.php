<?php 

class Vconnect_ProductDesc_Model_Observer {

    public function cmsWysiwygConfigPrepare(Varien_Event_Observer $observer){
        $observer->getEvent()->getConfig()->setAddWidgets('true');
    }

}