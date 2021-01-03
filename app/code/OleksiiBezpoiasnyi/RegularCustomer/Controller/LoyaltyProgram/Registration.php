<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\LoyaltyProgram;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class Registration implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    private $jsonFactory;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;
    /**
     * @var \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory
     */
    private $discountRequestFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest
     */
    private $discountRequestResource;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\App\RequestInterface $request,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->storeManager = $storeManager;
        $this->discountRequestResource = $discountRequestResource;
        $this->logger = $logger;
    }

    /**
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonFactory->create();

        try {
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $discountRequest->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);
            $message = __('You request for registration in loyalty program was accepted! Your discount will be available after admin verification');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
