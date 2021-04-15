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

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    /**
     * PersonalDiscount constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory ,
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
    )
    {
        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
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
    ): AbstractTotal
    {
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
        $personalDiscount = 0.0;
        $basePersonalDiscount = 0.0;

        /** @var \Magento\Quote\Model\Quote\Item $quoteItem */
        foreach ($quoteItems as $quoteItem) {
            $quoteProductId = $quoteItem->getProduct()->getId();
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId)
                ->addFieldToFilter('status', DiscountRequest::STATUS_APPROVED)
                ->addFieldToFilter('product_id', $quoteProductId);
            $requestId = $collection->getColumnValues('request_id');
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $this->discountRequestResource->load($discountRequest, $requestId);

            if (in_array($quoteProductId, $approvedProductIds, false)) {
                if ($discountRequest->getDiscountPercent()) {
                    $personalDiscount += -($quoteItem->getRowTotal() * $discountRequest->getDiscountPercent());
                    $basePersonalDiscount += -($quoteItem->getBaseRowTotal() * $discountRequest->getDiscountPercent());
                } else {
                    $personalDiscount += -($quoteItem->getRowTotal() * self::DISCOUNT_PERCENT);
                    $basePersonalDiscount += -($quoteItem->getBaseRowTotal() * self::DISCOUNT_PERCENT);
                }
            }
        }

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
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total): array
    {
        return [
            'code' => self::TOTAL_CODE,
            'title' => $this->getLabel(),
            'value' => $quote->getData(self::TOTAL_CODE)
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel(): \Magento\Framework\Phrase
    {
        return __('Personal Discount');
    }
}
