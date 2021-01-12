<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\LoyaltyProgram;

use Magento\Framework\Controller\Result\Json as JsonResponse;

class ProductList implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    private $jsonResponseFactory;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Catalog\Model\Session
     */
    private $catalogSession;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Model\Session $catalogSession
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\Session $catalogSession
    ) {
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->customerSession = $customerSession;
        $this->catalogSession = $catalogSession;
    }

    /***
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonResponseFactory->create();
        $productList = $this->customerSession->getData('product_list');
        $currentProductId = $this->catalogSession->getData('last_viewed_product_id');

        if ($productList && in_array($currentProductId, $productList, true)) {
            $result = true;
        } else {
            $result = false;
        }

        return $response->setData([
            'result' => $result
        ]);
    }
}
