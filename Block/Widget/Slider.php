<?php

namespace Dotsquares\ProductSlider\Block\Widget;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface; 


class Slider extends Template implements BlockInterface 
{
    /**
     * Default template to use for slider widget
     */
    const DEFAULT_SLIDER_TEMPLATE = 'widget/slider.phtml';

    /**
     * set slider widget template
     */
    public function _construct()
    {
        if (!$this->hasData('template')) {
            $this->setData('template', self::DEFAULT_SLIDER_TEMPLATE);
        }
        return parent::_construct();
    }
}
