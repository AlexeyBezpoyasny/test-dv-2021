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
}
