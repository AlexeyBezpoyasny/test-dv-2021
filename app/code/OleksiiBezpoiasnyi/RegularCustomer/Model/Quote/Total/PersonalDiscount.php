<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

class PersonalDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    public const DISCOUNT_PERCENT = 0.05;

    public const TOTAL_CODE = 'personal_discount';

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return AbstractTotal
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ): AbstractTotal {
        parent::collect($quote, $shippingAssignment, $total);

        $personalDiscount = -($total->getSubtotal() * self::DISCOUNT_PERCENT);
        $basePersonalDiscount = -($total->getBaseSubtotal() * self::DISCOUNT_PERCENT);

        $total->addTotalAmount(self::TOTAL_CODE, $personalDiscount);
        $total->addBaseTotalAmount(self::TOTAL_CODE, $basePersonalDiscount);
        $quote->setData(self::TOTAL_CODE, $personalDiscount);
        $quote->setData('base_' . self::TOTAL_CODE, $basePersonalDiscount);

        return $this;
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code'  => self::TOTAL_CODE,
            'title' => $this->getLabel(),
            'value' => $quote->getData(self::TOTAL_CODE)
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Personal Discount');
    }
}
