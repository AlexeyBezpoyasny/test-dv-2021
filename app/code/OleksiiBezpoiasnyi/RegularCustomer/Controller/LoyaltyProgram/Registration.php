<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\LoyaltyProgram;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class Registration implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    private \Magento\Framework\App\RequestInterface $request;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \Magento\Customer\Model\Session $customerSession;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Magento\Catalog\Model\ProductRepository $productRepository;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email;

    private \Psr\Log\LoggerInterface $logger;

    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Config $config;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\App\RequestInterface $request,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Config $config
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->discountRequestResource = $discountRequestResource;
        $this->productRepository = $productRepository;
        $this->email = $email;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
        $this->config = $config;

    }

    /**
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonFactory->create();

        try {
            if (!$this->config->enabled()) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->customerSession->isLoggedIn()
                && !$this->config->allowForGuests()
            ) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();

            $productId = (int) $this->request->getParam('productId');
            $product = $this->productRepository->getById($productId);

            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setGuestName($this->request->getParam('name'));
                $this->customerSession->setGuestEmail($this->request->getParam('email'));

                $sessionProductList = (array)$this->customerSession->getData('product_list');
                $sessionProductList[] = $productId;
                $this->customerSession->setProductList($sessionProductList);
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int)$this->customerSession->getCustomerId()
                : null;

            if ($this->customerSession->isLoggedIn()) {
                $name = $this->customerSession->getCustomer()->getName();
                $email = $this->customerSession->getCustomer()->getEmail();
            } else {
                $name = $this->request->getParam('name');
                $email = $this->request->getParam('email');
            }

            $discountRequest->setProductId($productId)
                ->setName($name)
                ->setEmail($email)
                ->setCustomerId($customerId)
                ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);
            $message = __('You request for registration in loyalty program was accepted! Your discount will be available after admin verification');

            $this->email->sendNewDiscountRequestEmail($name, $email, $product->getName());
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
