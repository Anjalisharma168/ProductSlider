<?php

namespace Dotsquares\ProductSlider\Model\Slider;

use Magento\Framework\Data\OptionSourceInterface;
use Dotsquares\ProductSlider\Model\ProductSlider;

class TemplateType implements OptionSourceInterface
{
    /**
     *  Template types constants
     */
    const TEMPLATE_TYPE_SLICK = 'slick';
    const TEMPLATE_TYPE_OWL = 'owl';
    const TEMPLATE_TYPE_GRID = 'grid';
    
    /**
     * Return template type options
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::TEMPLATE_TYPE_SLICK,
                'label' => __('Slick (Items in Slick Carousel Slider)')
            ],
            [
                'value' => self::TEMPLATE_TYPE_OWL,
                'label' => __('Owl (Items in OWL Carousel Slider)')
            ],
            [
                'value' => self::TEMPLATE_TYPE_GRID,
                'label' => __('Grid (Items in Grid, without Sider)')
            ],
        ];
    }
}
