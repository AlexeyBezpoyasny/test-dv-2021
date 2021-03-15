<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model;

/**
 * @method int|string|null getRequestId()
 * @method int|string|null getCustomerId()
 * @method $this setCustomerId(int $customerId)
 * @method int|string|null getProductId()
 * @method $this setProductId(int $productId)
 * @method string|null getName()
 * @method $this setName(string $name)
 * @method string|null getEmail()
 * @method $this setEmail(string $email)
 * @method int|string|null getEmailSent()
 * @method $this setEmailSent(int $emailSent)
 * @method int|string|null getWebsiteId()
 * @method $this setWebsiteId(int $websiteId)
 * @method int|string|null getStatus()
 * @method $this setStatus(int $status)
 * @method int|string|null getDiscountSize()
 * @method $this setDiscountSize(int $status)
 * @method int|string|null getAdminUserId()
 * @method $this setAdminUserId(int $adminId)
 * @method int|string|null getCreatedAt()
 * @method int|string|null getUpdatedAt()
 */
class DiscountRequest extends \Magento\Framework\Model\AbstractModel
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
}
