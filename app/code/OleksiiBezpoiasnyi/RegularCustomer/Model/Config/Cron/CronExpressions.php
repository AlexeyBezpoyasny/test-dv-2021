<?php

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\Config\Cron;

class CronExpressions implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Get options.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => '*/1 * * * *', 'label' => 'Every 1 Minutes'],
            ['value' => '*/5 * * * *', 'label' => 'Every 5 Minutes'],
            ['value' => '*/15 * * * *', 'label' => 'Every 15 Minutes'],
            ['value' => '*/30 * * * *', 'label' => 'Every 30 Minutes'],
            ['value' => '0 * * * *', 'label' => 'Every 1 Hours'],
            ['value' => '0 0 1 1 *', 'label' => 'Every New Year'],
        ];
    }
}
