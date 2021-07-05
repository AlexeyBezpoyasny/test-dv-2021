<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\TestTask\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class AddCustomAttrToOrder
{
    public const FIELD_NAME = 'test1';

    public const FIELD_NAME2 = 'test2';

    protected OrderExtensionFactory $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory
    ) {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order): OrderInterface
    {
        $test1 = $order->getData(self::FIELD_NAME);
        $test2 = $order->getData(self::FIELD_NAME2);
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();
        $extensionAttributes->setTest1($test1);
        $extensionAttributes->setTest2($test2);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult): OrderSearchResultInterface
    {
        $orders = $searchResult->getItems();

        foreach ($orders as $order) {
            $test1 = $order->getData(self::FIELD_NAME);
            $test2 = $order->getData(self::FIELD_NAME2);
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();
            $extensionAttributes->setTest1($test1);
            $extensionAttributes->setTest2($test2);
            $order->setExtensionAttributes($extensionAttributes);
        }
        return $searchResult;
    }
}
