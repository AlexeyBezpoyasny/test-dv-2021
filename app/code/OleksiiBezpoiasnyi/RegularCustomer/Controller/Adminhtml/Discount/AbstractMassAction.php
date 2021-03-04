<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\Adminhtml\Discount;

abstract class AbstractMassAction extends \Magento\Backend\App\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    protected \Magento\Ui\Component\MassAction\Filter $filter;

    protected \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory;

    protected \Magento\Framework\DB\TransactionFactory $transactionFactory;

    protected \Magento\Backend\Model\Auth\Session $authSession;

    /**
     * Delete constructor.
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transaction
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory,
        \Magento\Framework\DB\TransactionFactory $transaction,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->filter = $filter;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->transactionFactory = $transaction;
        $this->authSession = $authSession;
        parent::__construct($context);

    }
}
