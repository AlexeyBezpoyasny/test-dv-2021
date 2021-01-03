<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest::class,
            \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest::class
        );
    }
}
