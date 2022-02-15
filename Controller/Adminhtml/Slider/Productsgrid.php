<?php

namespace Dotsquares\ProductSlider\Controller\Adminhtml\Slider;

class Productsgrid extends \Dotsquares\ProductSlider\Controller\Adminhtml\Slider
{
    /**
     * Display list of additional products to current slider type
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $sliderId = (int)$this->getRequest()->getParam('id', false);

        $slider = $this->_initSlider($sliderId);
        $this->coreRegistry->register('product_slider', $slider);

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                \Dotsquares\ProductSlider\Block\Adminhtml\Slider\Edit\Tab\Products::class,
                'admin.block.slider.tab.products'
            )->toHtml()
        );
    }
}
