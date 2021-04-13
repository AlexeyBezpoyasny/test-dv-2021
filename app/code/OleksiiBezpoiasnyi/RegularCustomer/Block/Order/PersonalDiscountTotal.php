<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Block\Order;

use OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total\PersonalDiscount;

class PersonalDiscountTotal extends \Magento\Framework\View\Element\AbstractBlock
{
    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total\PersonalDiscount $personalDiscount;

    /**
     * CustomTotal constructor.
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total\PersonalDiscount $personalDiscount
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total\PersonalDiscount $personalDiscount,
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        parent::__construct($context);
        $this->personalDiscount = $personalDiscount;
    }

    public function initTotals(): void
    {
        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
            'code' => PersonalDiscount::TOTAL_CODE,
            'label' => $this->personalDiscount->getLabel(),
            'value' => $order->getData(PersonalDiscount::TOTAL_CODE),
            'base_value' => $order->getData('base_' . PersonalDiscount::TOTAL_CODE),
        ]), 'subtotal');
    }
}
