<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\CustomerData;

use OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    private \Magento\Customer\Model\Session $customerSession;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Config $config;

    /**
     * DiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Config $config
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Config $config
    ) {

        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        $customerName = $this->customerSession->getGuestName();
        $customerEmail = $this->customerSession->getGuestEmail();

        if ($this->customerSession->isLoggedIn()) {
            if (!$customerName) {
                $customerName = $this->customerSession->getCustomer()->getName();
            }

            if (!$customerEmail) {
                $customerEmail = $this->customerSession->getCustomer()->getEmail();
            }
            $customerId = $this->customerSession->getCustomerId();

            /** @var DiscountRequestCollection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId);
            $productList = $collection->getColumnValues('product_id');
            $productList = array_unique($productList);
            $productList = array_values(array_map('intval', $productList));
        } else {
            $productList = (array)$this->customerSession->getProductList();
        }

        return [
            'name' => $customerName,
            'email' => $customerEmail,
            'productList' => $productList,
            'isLoggedIn' => $this->customerSession->isLoggedIn(),
            'allowForGuests' => $this->config->allowForGuests()
        ];
    }
}
