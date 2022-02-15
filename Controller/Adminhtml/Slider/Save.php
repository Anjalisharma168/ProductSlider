<?php
namespace Dotsquares\ProductSlider\Controller\Adminhtml\Slider;

class Save extends \Dotsquares\ProductSlider\Controller\Adminhtml\Slider
{
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        
        $sliderFormData = $this->getRequest()->getPostValue();
         
        if ($sliderFormData) {
            try {
                $productSlider = $this->sliderFactory->create();
                $sliderId = $this->getRequest()->getParam('slider_id');
                if ($sliderId !== null) {
                    $productSlider->load($sliderId);
                }

              

                $productSlider->setData($sliderFormData);
                if($sliderFormData['type']== 'category'){
                $cat_ids = $sliderFormData['slider']['categories_ids'];
  
                $productSlider->setCategoriesIds($cat_ids);
            }
                $productSlider->save();

                if (!$sliderId) {
                    $sliderId = $productSlider->getSliderId();
                }

                $this->messageManager->addSuccess(
                    __('Product slider has been successfully saved.')
                );
                
                $this->_getSession()->setFormData(false);
                
                $backParam = $this->getRequest()->getParam('back');
                if ($backParam == 'edit') {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $sliderId]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    $e->getMessage()
                );
                $this->messageManager->addException(
                    $e,
                    __('Error occurred during slider saving.')
                );
            }
            
            $this->_getSession()->setFormData($sliderFormData);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $sliderId]
            );
        }
    }
}
