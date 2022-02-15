<?php
namespace Dotsquares\ProductSlider\Block\Adminhtml\Slider\Edit\Tab;

use Dotsquares\ProductSlider\Model\Slider\Type as SliderType;
use Dotsquares\ProductSlider\Model\Slider\Status as SliderStatus;
use Magento\Store\Model\ScopeInterface as Scope;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Form\Element\Dependence;
use Magento\Framework\Data\FormFactory;
use Magento\Config\Model\Config\Source\Yesno as SourceYesno;
use Magento\Store\Model\System\Store as SystemStore;
use Dotsquares\ProductSlider\Block\Adminhtml\Slider\Edit\Tab\Renderer\Category;
     
class General extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Config path to default slider settings
     */
    const XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES = 'productslider/slider_settings/' ;

    /**
     * @var SourceYesno
     */
    protected $yesNo;

    /**
     * @var SystemStore
     */
    protected $systemStore;

    /**
     * @var SliderType
     */
    protected $sliderType;
    
    


    /**
     * @var SliderStatus
     */
    protected $sliderStatus;


    
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param SourceYesno $yesNo
     * @param SliderType $sliderType
     
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        SourceYesno $yesNo,
        SystemStore $systemStore,
        SliderType $sliderType,
      
        SliderStatus $sliderStatus,
        array $data = []
    ) {
        $this->yesNo = $yesNo;
        $this->systemStore = $systemStore;
        $this->sliderType = $sliderType;
       
        $this->sliderStatus = $sliderStatus;
       
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $data
        );
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $productSlider = $this->_coreRegistry
            ->registry('product_slider');
        $yesno = $this->yesNo->toOptionArray();

        $fieldset = $form->addFieldset(
            'slider_fieldset_general',
            ['legend' => __('General')]
        );
        
        $prodSliderId = $productSlider->getId();
        if ($prodSliderId) {
            $fieldset->addField(
                'slider_id',
                'hidden',
                [
                    'name' => 'slider_id'
                ]
            );
        }

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'options' => $this->sliderStatus->toOptionArray(),
                'disabled' => false,
            ]
        );
        
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'title' => __('Title'),
                'label' => __('Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'display_title',
            'select',
            [
                'label' => __('Show title'),
                'title' => __('Show title'),
                'name' => 'display_title',
                'note' => __('If Yes, the title block will appear in the frontend.'),
                'values' => $yesno
            ]
        );
        
        
        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'note' => __('Define the slider description to appear under the title block. 
                Leave empty to hide the description block'),
            ]
        );

        /**
         * Check if single store mode
         */
        $singleStore = $this->_storeManager->isSingleStoreMode();
        if (!$singleStore) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store view'),
                    'title' => __('Store view'),
                    'values' => $this->systemStore
                        ->getStoreValuesForForm(false, true),
                    'required' => true,
                ]
            );

            /** @var \Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element $renderer */
            $renderer = $this->getLayout()->createBlock(
                \Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element::class
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                [
                    'name' => 'stores[]',
                    'value' => $this->_storeManager->getStore(true)
                        ->getId()
                ]
            );
        }
        
        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::SHORT
        );
        $timeFormat = $this->_localeDate->getTimeFormat(
            \IntlDateFormatter::SHORT
        );
        $fieldset->addField(
            'start_time',
            'date',
            [
                'name' => 'start_time',
                'label' => __('Start time'),
                'title' => __('Start time'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => $this->_localeDate->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );
        $fieldset->addField(
            'end_time',
            'date',
            [
                'name' => 'end_time',
                'label' => __('End time'),
                'title' => __('End time'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => $this->_localeDate
                    ->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );
        
        $fieldset = $form->addFieldset(
            'slider_fieldset_appearance',
            ['legend' => __('Display')]
        );
        
       $sliderType = $fieldset->addField(
            'type',
            'select',
            [
                'label' => __('Slider type'),
                'title' => __('Slider type'),
                'name' => 'type',
                'required' => true,
                'values' => $this->sliderType->toOptionArray(),
                'note' => __('Auto related products available only on product page location.'),
            ]
        );
         $categoryIds = $fieldset->addField('categories_ids', Category::class, [
            'name' => 'categories_ids',
            'label' => __('Categories'),
            'title' => __('Categories')
        ]);
       
        $fieldset->addField(
            'products_number',
            'text',
            [
                'name' => 'products_number',
                'label' => __('Max products number'),
                'title' => __('Max products number'),
                'note' => __('Max Number of products displayed in slider. Default is 30 products.'),
            ]
        );

        
      
   
       // set default values
        $defaultData = [
            'status' => 1,
            'products_number' => 8,
            'display_price' => 1,
            'display_cart' => 1,
            'display_compare' => 1,
            'display_wishlist' => 1,
        ];
              
        $this->setChild(
            'form_after',
            $this->getLayout()->createBlock(Dependence::class)
                ->addFieldMap($sliderType->getHtmlId(), $sliderType->getName())
                ->addFieldMap($categoryIds->getHtmlId(), $categoryIds->getName())
                ->addFieldDependence($categoryIds->getName(), $sliderType->getName(), SliderType::CATEGORY)
        );


        if (!$productSlider->getId()) {
            $productSlider->addData($defaultData);
        }
        if ($productSlider->getData()) {
            $form->setValues($productSlider->getData());
        }
        
        $this->setForm($form);
       

        return parent::_prepareForm();
    }
}
