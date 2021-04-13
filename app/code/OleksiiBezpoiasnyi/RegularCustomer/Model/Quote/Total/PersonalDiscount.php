<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;
use OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class PersonalDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    public const DISCOUNT_PERCENT = 0.05;

    public const TOTAL_CODE = 'personal_discount';

    private \Magento\Customer\Model\Session $customerSession;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory;

    /**
     * PersonalDiscount constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
    }

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

        if (!$shippingAssignment->getItems()) {
            return $this;
        }
        $customerId = $this->customerSession->getCustomerId();

        /** @var DiscountRequestCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('status', DiscountRequest::STATUS_APPROVED);

        $approvedProductIds = $collection->getColumnValues('product_id');
        $quoteItems = $quote->getAllVisibleItems();
        $personalDiscountAmount = 0.0;
        $personalDiscountBaseAmount = 0.0;

        /** @var \Magento\Quote\Model\Quote\Item $quoteItem */
        foreach ($quoteItems as $quoteItem) {
            $quoteProductId = $quoteItem->getProduct()->getId();
            if (in_array($quoteProductId, $approvedProductIds, false)) {
                $personalDiscountAmount += $quoteItem->getRowTotal();
                $personalDiscountBaseAmount += $quoteItem->getBaseRowTotal();
            }
        }

        $personalDiscount = -(self::DISCOUNT_PERCENT * $personalDiscountAmount);
        $basePersonalDiscount = -(self::DISCOUNT_PERCENT * $personalDiscountBaseAmount);

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
