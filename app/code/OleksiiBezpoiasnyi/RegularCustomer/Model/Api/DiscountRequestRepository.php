<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface;
use OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestSearchResultInterface;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

/**
 * Class DiscountRequestRepository
 * @api
 */
class DiscountRequestRepository implements \OleksiiBezpoiasnyi\RegularCustomer\Api\DiscountRequestRepositoryInterface
{
    private \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Api\Data\DiscountRequestSearchResultFactory $discountRequestSearchResultFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResourceModel;

    private \Psr\Log\LoggerInterface $logger;

    /**
     * DiscountRequestRepository constructor.
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Api\Data\DiscountRequestSearchResultFactory $discountRequestSearchResultFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResourceModel
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Api\Data\DiscountRequestSearchResultFactory $discountRequestSearchResultFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResourceModel,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->discountRequestSearchResultFactory = $discountRequestSearchResultFactory;
        $this->discountRequestResourceModel = $discountRequestResourceModel;
        $this->logger = $logger;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return DiscountRequestSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): DiscountRequestSearchResultInterface
    {
        $discountRequestCollection = $this->discountRequestCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $discountRequestCollection);

        $foo = $this->discountRequestSearchResultFactory->create()
            ->setItems($discountRequestCollection->getItems())
            ->setSearchCriteria($searchCriteria)
            ->setTotalCount($discountRequestCollection->getSize());

        return $foo;
    }

    /**
     * @param DiscountRequestInterface $discountRequest
     * @return DiscountRequestInterface
     * @throws CouldNotSaveException
     */
    public function save(DiscountRequestInterface $discountRequest): DiscountRequestInterface
    {
        try {
            /** @var DiscountRequest $discountRequest */
            $this->discountRequestResourceModel->save($discountRequest);
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
            throw new CouldNotSaveException(__('Unable to save request #%1', $discountRequest->getRequestId()));
        }

        return $discountRequest;
    }

    /**
     * @param int $requestId
     * @return DiscountRequestInterface
     * @throws NoSuchEntityException
     */
    public function get(int $requestId): DiscountRequestInterface
    {
        /** @var DiscountRequest $discountRequest */
        $discountRequest = $this->discountRequestFactory->create();
        $this->discountRequestResourceModel->load($discountRequest, $requestId);
        if (!$discountRequest->getId()) {
            throw new NoSuchEntityException(__("The discount request that was requested doesn't exist. Verify the request and try again."));
        }

        return $discountRequest;
    }

    /**
     * @param DiscountRequestInterface $discountRequest
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(DiscountRequestInterface $discountRequest): bool
    {
        try {
            $this->discountRequestResourceModel->delete($discountRequest);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotDeleteException(__('Unable to remove request #%1', $discountRequest->getRequestId()));
        }

        return true;
    }

    /**
     * @param int $requestId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $requestId): bool
    {
        return $this->delete($this->get($requestId));
    }
}
