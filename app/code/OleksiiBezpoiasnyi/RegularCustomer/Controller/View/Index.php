<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\View;

use Magento\Framework\View\Result\Page as PageResponse;

class Index implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
    }

    /**
     * @return PageResponse
     */
    public function execute(): PageResponse
    {
        return $this->pageResponseFactory->create();
    }
}
