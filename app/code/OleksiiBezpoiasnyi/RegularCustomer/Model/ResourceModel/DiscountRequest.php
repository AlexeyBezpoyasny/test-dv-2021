<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel;

class DiscountRequest extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('oleksiib_regular_customer', 'request_id');
    }
}
