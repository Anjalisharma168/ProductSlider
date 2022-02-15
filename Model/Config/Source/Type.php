<?php

namespace Dotsquares\ProductSlider\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Type implements OptionSourceInterface
{
    /**
     * Slider types constants
     */
    const SLIDER_TYPE_DEFAULT = "";
    const SLIDER_TYPE_NEW = 'new';
    const SLIDER_TYPE_BESTSELLERS = 'bestsellers';
    const SLIDER_TYPE_FEATURED = 'featured';
    const SLIDER_TYPE_ONSALE = 'onsale';
    const CATEGORY = 'category';
    /**
     * To option slider types array
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::SLIDER_TYPE_DEFAULT, 'label' => __('--- Select Slider Type --')],
            ['value' => self::SLIDER_TYPE_NEW,  'label' => __('New Products')],
            ['value' => self::SLIDER_TYPE_BESTSELLERS, 'label' => __('Bestsellers Products')],
            ['value' => self::SLIDER_TYPE_FEATURED,  'label' => __('Featured Products')],
            ['value' => self::SLIDER_TYPE_ONSALE, 'label' => __('On Sale Products')],
            ['value' => self::CATEGORY, 'label' => __('Select By Category')],
            
            
        ];
    }
}
