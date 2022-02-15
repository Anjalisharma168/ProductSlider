<?php

namespace Dotsquares\ProductSlider\Controller\Adminhtml\Slider;

class NewAction extends \Dotsquares\ProductSlider\Controller\Adminhtml\Slider
{
    /**
     * Create new slider action
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        //Forward to the edit action
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->forward('edit');
        return $resultForward;
    }
}
