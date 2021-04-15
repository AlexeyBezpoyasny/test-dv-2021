<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Api\Data;

/**
 * Interface DiscountRequestInterface
 * @api
 */
interface DiscountRequestInterface
{
    public const REQUEST_ID = 'request_id';
    public const CUSTOMER_ID = 'customer_id';
    public const PRODUCT_ID = 'product_id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const EMAIL_SENT = 'email_sent';
    public const WEBSITE_ID = 'website_id';
    public const STATUS = 'status';
    public const DISCOUNT_SIZE = 'discount_size';
    public const ADMIN_USER_ID = 'admin_user_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const STATUS_CHANGED_AT = 'status_changed_at';

    /**
     * @return int
     */
    public function getRequestId(): int;

    /**
     * @param int $requestId
     * @return DiscountRequestInterface
     */
    public function setRequestId(int $requestId): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * @param int|null $customerId
     * @return DiscountRequestInterface
     */
    public function setCustomerId(int $customerId = null): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * @param int|null $productId
     * @return DiscountRequestInterface
     */
    public function setProductId(int $productId = null): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return DiscountRequestInterface
     */
    public function setName(string $name): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return DiscountRequestInterface
     */
    public function setEmail(string $email): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getEmailSent(): ?int;

    /**
     * @param int $emailSent
     * @return DiscountRequestInterface
     */
    public function setEmailSent(int $emailSent): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getWebsiteId(): ?int;

    /**
     * @param int $websiteId
     * @return DiscountRequestInterface
     */
    public function setWebsiteId(int $websiteId): DiscountRequestInterface;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return DiscountRequestInterface
     */
    public function setStatus(int $status): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getDiscountSize(): ?int;

    /**
     * @param int $discountSize
     * @return DiscountRequestInterface
     */
    public function setDiscountSize(int $discountSize): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getAdminUserId(): ?int;

    /**
     * @param int $adminUserId
     * @return DiscountRequestInterface
     */
    public function setAdminUserId(int $adminUserId): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return DiscountRequestInterface
     */
    public function setCreatedAt(string $createdAt): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return DiscountRequestInterface
     */
    public function setUpdatedAt(string $updatedAt): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getStatusChangedAt(): string;

    /**
     * @param string $statusChangedAt
     * @return DiscountRequestInterface
     */
    public function setStatusChangedAt(string $statusChangedAt): DiscountRequestInterface;
}
