<?php

class Vconnect_ProductDesc_Block_Widget_Desc2 
    extends Vconnect_ProductDesc_Block_Desc
    implements Mage_Widget_Block_Interface
{
    public function getText()
    {
        return nl2br(parent::getText());
    }
}