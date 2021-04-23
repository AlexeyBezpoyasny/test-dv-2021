<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Personal Discount Repository repository to get requests data
 *
 * @api
 */
interface DiscountRequestRepositoryInterface
{
    /**
     * Create discount request
     * If discount request ID is not specified, creates a record. If discount request ID is specified, updates the record for the specified ID.
     *
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface $discountRequest
     * @return \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface $discountRequest);

    /**
     * Get info about discount request by request id
     *
     * @param int $requestId
     * @return \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $requestId);

    /**
     * Delete discount request
     *
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface $discountRequest discount request which will deleted
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface $discountRequest);

    /**
     * Delete discount request by ID
     *
     * @param int $requestId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $requestId);

    /**
     * Get full vehicle information by search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestSearchResultInterface;
}
