<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Block\Product\View;

class PersonalDiscount extends \Magento\Catalog\Block\Product\View
{
    /**
     * @return array
     */
    public function getCacheKeyInfo(): array
    {
        return array_merge(parent::getCacheKeyInfo(), ['productId' => $this->getProduct()->getId()]);
    }
}
