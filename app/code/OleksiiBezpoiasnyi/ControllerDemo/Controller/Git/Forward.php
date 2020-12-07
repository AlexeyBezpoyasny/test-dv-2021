<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\ControllerDemo\Controller\Git;

use Magento\Framework\Controller\Result\Forward as ForwardResponse;

class Forward implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    private $forwardResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
    ) {
        $this->forwardResponseFactory = $forwardResponseFactory;
    }
    /**
     * @return ForwardResponse
     */
    public function execute(): ForwardResponse
    {
        $result = $this->forwardResponseFactory->create();
        return $result->setParams(
            [
                'first_name' => 'Oleksii',
                'last_name' => 'Bezpoiasnyi',
                'repository_url' => 'https://github.com/AlexeyBezpoyasny'
            ]
        )->forward('data');
    }
}
