<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Block\Adminhtml\DiscountRequest\Button;

class Save implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage_init' => [
                    'button' => [
                        'event' => 'save'
                    ],
                ],
                'form-role' => 'save'
            ],
            'sort_order' => 10,
        ];
    }
}
