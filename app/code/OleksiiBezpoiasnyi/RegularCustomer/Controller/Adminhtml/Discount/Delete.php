<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\Adminhtml\Discount;

use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;
use Magento\Framework\Controller\ResultInterface;

class Delete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_DELETE;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    /**
     * Delete constructor.
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        // Check if we know what should be deleted
        if ($discountRequestId = (int) $this->getRequest()->getParam('request_id')) {
            try {
                // Init model and delete
                /** @var DiscountRequest $discountRequest */
                $discountRequest = $this->discountRequestFactory->create();
                $discountRequest->setId($discountRequestId);
                $this->discountRequestResource->delete($discountRequest);
                // Display success message
                $this->messageManager->addSuccessMessage(__('Request deleted!'));
            } catch (\Exception $e) {
                // Display error message
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            // Display error message
            $this->messageManager->addErrorMessage(__('We can\'t find a request to delete.'));
        }


        // Go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
