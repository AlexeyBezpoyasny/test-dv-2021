<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\Adminhtml\Discount;

use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class NewRequest extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    /**
     * @inheridoc
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);

        return $resultForward->forward('edit');
    }
}
