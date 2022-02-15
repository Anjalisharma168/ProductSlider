<?php
namespace Dotsquares\ProductSlider\Model\Slider;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    /**
     * Slider statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    
    /**
     * To option slider statuses array
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::STATUS_ENABLED => 'Enabled',
            self::STATUS_DISABLED => 'Disabled',
        ];
    }
}
