<?php
namespace Orangecat\Sizeguide\Block;
use Magento\Framework\View\Element\Template;

class Sizeguide extends \Magento\Framework\View\Element\Template
{
    protected $helperData;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Orangecat\Sizeguide\Helper\Data $helperData,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function isEnabled()
    {
        return $this->helperData->getGeneralConfig('enable');
    }

    public function getLinkTxt()
    {
        return $this->helperData->getGeneralConfig('display_text');
    }

    public function getPopupTitle()
    {
        return $this->helperData->getGeneralConfig('popup_title');
    }
}