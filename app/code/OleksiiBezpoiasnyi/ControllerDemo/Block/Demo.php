<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\ControllerDemo\Block;

class Demo extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return (string) $this->getRequest()->getParam('first_name');
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return (string) $this->getRequest()->getParam('last_name');
    }

    /**
     * @return string
     */
    public function getRepositoryUrl(): string
    {
        return (string) $this->getRequest()->getParam('repository_url');
    }
}
