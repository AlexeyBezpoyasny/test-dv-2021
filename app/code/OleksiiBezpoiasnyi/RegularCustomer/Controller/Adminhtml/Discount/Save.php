<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\Adminhtml\Discount;

use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Magento\Backend\Model\Auth\Session $authSession;

    private \Magento\Catalog\Model\ProductRepository $productRepository;

    private \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email;

    private \Magento\Store\Model\StoreManager $storeManager;

    /**
     * Save constructor.
     *
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Backend\Model\Auth\Session $authSession,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Backend\App\Action\Context $context
    )
    {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->authSession = $authSession;
        $this->email = $email;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $request = $this->getRequest();
            $this->discountRequestResource->load($discountRequest, $request->getParam('request_id'));

            $adminId = $this->authSession->getUser()->getId();
            $customerId = $this->getRequest()->getParam('customer_id') ?: null;

            $discountRequest->setProductId($this->getRequest()->getParam('product_id'))
                ->setCustomerId($customerId)
                ->setName($this->getRequest()->getParam('name'))
                ->setEmail($this->getRequest()->getParam('email'))
                ->setWebsiteId($this->getRequest()->getParam('website_id'))
                ->setAdminUserId($adminId)
                ->setDiscountPercent($this->getRequest()->getParam('discount_percent'));
            if ($discountRequest->getStatus() !== $this->getRequest()->getParam('status')) {
                $discountRequest->setEmailSent(0)
                    ->setStatus($this->getRequest()->getParam('status'))
                    ->setStatusChangedAt(time());
            }

            $storeId = (int)$this->storeManager->getWebsite($discountRequest->getWebsiteId())->getDefaultStore()->getId();
            $productName = $this->productRepository->getById($discountRequest->getProductId(), false, $storeId)->getName();

            $customerEmail = $discountRequest->getCustomerId()
                ? $this->customerRepository->getById($discountRequest->getCustomerId())->getEmail()
                : $discountRequest->getEmail();

            if ($this->getRequest()->getParam('notify')) {
                switch ($discountRequest->getStatus()) {
                    case DiscountRequest::STATUS_APPROVED:
                        $this->email->sendRequestApprovedEmail($customerEmail, $productName, $storeId);
                        $discountRequest->setEmailSent(1);
                        break;
                    case DiscountRequest::STATUS_DECLINED:
                        $this->email->sendRequestDeclinedEmail($customerEmail, $productName, $storeId);
                        $discountRequest->setEmailSent(1);
                        break;
                    default:
                        break;
                }
            }

            $this->messageManager->addSuccessMessage(__('Request saved!'));

            $this->discountRequestResource->save($discountRequest);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath(
            '*/*/'
        );
    }
}
