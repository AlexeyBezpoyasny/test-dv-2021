<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\ControllerDemo\Controller\Git;

use Magento\Framework\View\Result\Page as PageResponse;

class Data implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private $pageResponseFactory;

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
        return $page = $this->pageResponseFactory->create();
    }
}
