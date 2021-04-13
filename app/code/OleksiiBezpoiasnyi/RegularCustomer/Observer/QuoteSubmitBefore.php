<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Observer;

use Magento\Framework\Event\Observer;
use OleksiiBezpoiasnyi\RegularCustomer\Model\Quote\Total\PersonalDiscount;

class QuoteSubmitBefore implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        try {
            $quote = $observer->getQuote();
            $order = $observer->getOrder();
            $order->setData(PersonalDiscount::TOTAL_CODE, $quote->getData(PersonalDiscount::TOTAL_CODE));
            $order->setData('base_' . PersonalDiscount::TOTAL_CODE, $quote->getData('base_' . PersonalDiscount::TOTAL_CODE));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}
