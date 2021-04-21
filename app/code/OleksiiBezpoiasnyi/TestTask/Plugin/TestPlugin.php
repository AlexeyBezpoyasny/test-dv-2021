<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\TestTask\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class TestPlugin
{
    protected OrderExtensionFactory $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $test1 = $order->getData('customer_id');
        $test2 = $order->getData('customer_email');
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();
        $extensionAttributes->setTest1($test1);
        $extensionAttributes->setTest2($test2);
        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }

    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();
        foreach ($orders as &$order) {
            $test1 = $order->getData('customer_id');
            $test2 = $order->getData('customer_email');
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();
            $extensionAttributes->setTest1($test1);
            $extensionAttributes->setTest2($test2);
            $order->setExtensionAttributes($extensionAttributes);
        }
        return $searchResult;
    }
}
