<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Observer;

use \OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total\PersonalDiscount;

class QuoteSubmitBefore implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        try {
            $quote = $observer->getQuote();
            $order = $observer->getOrder();
            $order->setData(PersonalDiscount::TOTAL_CODE, $quote->getData(PersonalDiscount::TOTAL_CODE));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}
