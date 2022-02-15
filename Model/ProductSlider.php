<?php

namespace Dotsquares\ProductSlider\Model;

class ProductSlider extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Set resource class
     */
    protected function _construct()
    {
        $this->_init(\Dotsquares\ProductSlider\Model\ResourceModel\ProductSlider::class);
    }

    /**
     * Get additional products for current slider
     * @return array
     */
    public function getSelectedSliderProducts()
    {
        if (!$this->getSliderId()) {
            return [];
        }

        $array = $this->getData('slider_products');
        if ($array === null) {
            $array = $this->getResource()->getSliderProducts($this);
            $this->setData('slider_products', $array);
        }
        
        return $array;
    }
    
}
