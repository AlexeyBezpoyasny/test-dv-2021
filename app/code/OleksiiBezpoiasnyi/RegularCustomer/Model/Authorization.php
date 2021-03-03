<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model;

class Authorization
{
    public const ACTION_DISCOUNT_REQUEST_EDIT = 'OleksiiBezpoiasnyi_RegularCustomer::edit';

    public const ACTION_DISCOUNT_REQUEST_DELETE = 'OleksiiBezpoiasnyi_RegularCustomer::delete';

    private \Magento\Framework\AuthorizationInterface $authorization;

    /**
     * Authorization constructor.
     * @param \Magento\Framework\AuthorizationInterface $authorization
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization
    ) {
        $this->authorization = $authorization;
    }

    /**
     * @param string $alcResource
     * @return bool
     */
    public function isActionAllowed(string $alcResource): bool
    {
        return $this->authorization->isAllowed($alcResource);
    }
}
