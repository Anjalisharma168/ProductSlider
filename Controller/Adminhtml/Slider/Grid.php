<?php


namespace Dotsquares\ProductSlider\Controller\Adminhtml\Slider;

class Grid extends \Dotsquares\ProductSlider\Controller\Adminhtml\Slider
{
    /**
     * Prevent entire page loading
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
