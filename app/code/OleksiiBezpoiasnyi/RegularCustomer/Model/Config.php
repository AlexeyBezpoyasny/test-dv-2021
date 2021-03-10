<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model;

use Magento\Store\Model\ScopeInterface;

class Config
{
    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    /**
     * Config constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public const XML_PATH_OLEKSII_B_PERSONAL_DISCOUNT_GENERAL_ENABLED
        = 'oleksii_b_personal_discount/general/enabled';

    public const XML_PATH_OLEKSII_B_PERSONAL_DISCOUNT_GENERAL_ALLOW_FOR_GUESTS
        = 'oleksii_b_personal_discount/general/allow_for_guests';

    public const XML_PATH_OLEKSII_B_PERSONAL_DISCOUNT_GENERAL_SALES_EMAIL_IDENTITY
        = 'oleksii_b_personal_discount/general/sender_email_identity';


    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_OLEKSII_B_PERSONAL_DISCOUNT_GENERAL_ENABLED,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function allowForGuests(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_OLEKSII_B_PERSONAL_DISCOUNT_GENERAL_ALLOW_FOR_GUESTS,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return string
     */
    public function getSenderEmailIdentity(): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_OLEKSII_B_PERSONAL_DISCOUNT_GENERAL_SALES_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
}
