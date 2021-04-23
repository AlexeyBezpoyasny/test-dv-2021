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

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->getData(DiscountRequestInterface::NAME);
    }

    /**
     * @param string $name
     * @return DiscountRequestInterface
     */
    public function setName(string $name): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::NAME, $name);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return (string) $this->getData(DiscountRequestInterface::EMAIL);
    }

    /**
     * @param string $email
     * @return DiscountRequestInterface
     */
    public function setEmail(string $email): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::EMAIL, $email);
    }

    /**
     * @return int|null
     */
    public function getEmailSent(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::EMAIL_SENT)) ?: null;
    }

    /**
     * @param int $emailSent
     * @return DiscountRequestInterface
     */
    public function setEmailSent(int $emailSent): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::EMAIL_SENT, $emailSent);
    }

    /**
     * @return int|null
     */
    public function getWebsiteId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::WEBSITE_ID)) ?: null;
    }

    /**
     * @param int $websiteId
     * @return DiscountRequestInterface
     */
    public function setWebsiteId(int $websiteId): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::WEBSITE_ID, $websiteId);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->getData(DiscountRequestInterface::STATUS);
    }

    /**
     * @param int $status
     * @return DiscountRequestInterface
     */
    public function setStatus(int $status): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::STATUS, $status);
    }

    /**
     * @return int|null
     */
    public function getDiscountSize(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::DISCOUNT_SIZE)) ?: null;
    }

    /**
     * @param int $discountSize
     * @return DiscountRequestInterface
     */
    public function setDiscountSize(int $discountSize): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::DISCOUNT_SIZE, $discountSize);
    }

    /**
     * @return int|null
     */
    public function getAdminUserId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::ADMIN_USER_ID)) ?: null;
    }

    /**
     * @param int $adminUserId
     * @return DiscountRequestInterface
     */
    public function setAdminUserId(int $adminUserId): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::ADMIN_USER_ID, $adminUserId);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return DiscountRequestInterface
     */
    public function setCreatedAt(string $createdAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::CREATED_AT, $createdAt);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return DiscountRequestInterface
     */
    public function setUpdatedAt(string $updatedAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::UPDATED_AT, $updatedAt);
    }

    /**
     * @return string
     */
    public function getStatusChangedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::STATUS_CHANGED_AT);
    }

    /**
     * @param string $statusChangedAt
     * @return DiscountRequestInterface
     */
    public function setStatusChangedAt(string $statusChangedAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::STATUS_CHANGED_AT, $statusChangedAt);
    }
}
