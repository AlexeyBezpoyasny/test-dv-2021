<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Api\Data;

/**
 * Interface DiscountRequestSearchResultInterface
 * A list of Discount Requests and their associated data filtered by SearchCriteria
 *
 * @api
 */
interface DiscountRequestSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface[]
     */
    public function getItems();

    /**
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
