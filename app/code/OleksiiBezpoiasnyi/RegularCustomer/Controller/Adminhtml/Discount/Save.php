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

    /**
     * Save constructor.
     *
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->authSession = $authSession;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $adminId = $this->authSession->getUser()->getId();
            $customerId = $this->getRequest()->getParam('customer_id') ?: null;

            $discountRequest->setProductId($this->getRequest()->getParam('product_id'))
                ->setCustomerId($customerId)
                ->setName($this->getRequest()->getParam('name'))
                ->setEmail($this->getRequest()->getParam('email'))
                ->setWebsiteId($this->getRequest()->getParam('website_id'))
                ->setStatus($this->getRequest()->getParam('status'))
                ->setAdminUserId($adminId);

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
