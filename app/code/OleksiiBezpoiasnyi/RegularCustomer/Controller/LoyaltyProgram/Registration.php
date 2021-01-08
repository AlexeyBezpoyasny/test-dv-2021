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
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

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
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\App\RequestInterface $request,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->discountRequestResource = $discountRequestResource;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
    }

    /**
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonFactory->create();

        try {
            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();

            if ($this->customerSession->isLoggedIn()) {
                $discountRequest->setName($this->customerSession->getCustomer()->getName())
                    ->setEmail($this->customerSession->getCustomerData()->getEmail())
                    ->setCustomerId($this->customerSession->getCustomerId())
                    ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                    ->setStatus(DiscountRequest::STATUS_PENDING);
                $this->discountRequestResource->save($discountRequest);
                $message = __('You request for registration in loyalty program was accepted! Your discount will be available after admin verification');
            } else {
                $message = __('Please, sign in or sign up');
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
