<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\Adminhtml\Discount;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DB\Transaction;
use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class MassChangeStatus extends AbstractMassAction
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    /**
     * Dispatch request
     *
     * @return ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function execute(): ResultInterface
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $collection = $this->filter->getCollection($this->discountRequestCollectionFactory->create());
        $status = (int)$this->getRequest()->getParam('status');
        $collection->addFieldToFilter('status', ['neq' => $status]);
        $collectionSize = $collection->count();
        $adminId = $this->authSession->getUser()->getId();

        /** @var DiscountRequest $item */
        foreach ($collection as $item) {
            $item->setStatus($status);
            $item->setStatusChangedAt(time());
            $item->setAdminUserId($adminId);
            $item->setEmailSent(0);
            $transaction->addObject($item);
        }

        $transaction->save();
        $this->messageManager->addSuccessMessage(__('%1 requests(s) have been updated.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
