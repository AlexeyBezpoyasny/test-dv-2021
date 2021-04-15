<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model;

use OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface;

/**
 * Class DiscountRequest
 * @api
 */
class DiscountRequest extends \Magento\Framework\Model\AbstractModel implements
    \OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface
{
    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_DECLINED = 3;

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest::class);
    }

    /**
     * @return int
     */
    public function getRequestId(): int
    {
        return $this->getData(DiscountRequestInterface::REQUEST_ID);
    }

    /**
     * @param int $requestId
     * @return DiscountRequestInterface
     */
    public function setRequestId(int $requestId): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::REQUEST_ID, $requestId);
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::CUSTOMER_ID)) ?: null;
    }

    /**
     * @param int|null $customerId
     * @return DiscountRequestInterface
     */
    public function setCustomerId(int $customerId = null): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::CUSTOMER_ID);
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::PRODUCT_ID)) ?: null;
    }

    /**
     * @param int|null $productId
     * @return DiscountRequestInterface
     */
    public function setProductId(int $productId = null): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::PRODUCT_ID);
    }

    public function getName(): string
    {
        return (string) $this->getData(DiscountRequestInterface::NAME);
    }

    public function setName(string $name): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::NAME, $name);
    }

    public function getEmail(): string
    {
        return (string) $this->getData(DiscountRequestInterface::EMAIL);
    }

    public function setEmail(string $email): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::EMAIL, $email);
    }

    public function getEmailSent(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::EMAIL_SENT)) ?: null;
    }

    public function setEmailSent(int $emailSent): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::EMAIL_SENT, $emailSent);
    }

    public function getWebsiteId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::WEBSITE_ID)) ?: null;
    }

    public function setWebsiteId(int $websiteId): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::WEBSITE_ID, $websiteId);
    }

    public function getStatus(): int
    {
        return (int) $this->getData(DiscountRequestInterface::STATUS);
    }

    public function setStatus(int $status): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::STATUS, $status);
    }

    public function getDiscountSize(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::DISCOUNT_SIZE)) ?: null;
    }

    public function setDiscountSize(int $discountSize): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::DISCOUNT_SIZE, $discountSize);
    }

    public function getAdminUserId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::ADMIN_USER_ID)) ?: null;
    }

    public function setAdminUserId(int $adminUserId): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::ADMIN_USER_ID, $adminUserId);
    }

    public function getCreatedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::UPDATED_AT, $updatedAt);
    }

    public function getStatusChangedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::STATUS_CHANGED_AT);
    }

    public function setStatusChangedAt(string $statusChangedAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::STATUS_CHANGED_AT, $statusChangedAt);
    }
}
