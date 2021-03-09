<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Ui\Component\DiscountRequest\Source;

use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
        [
            'value' => DiscountRequest::STATUS_PENDING,
            'label' => __('Pending')
        ], [
            'value' => DiscountRequest::STATUS_APPROVED,
            'label' => __('Approved')
        ], [
            'value' => DiscountRequest::STATUS_DECLINED,
            'label' => __('Declined')
        ]
    ];
    }
}
