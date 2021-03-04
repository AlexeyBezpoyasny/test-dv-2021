<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Ui\Component;

use Magento\Catalog\Model\Product;

class RegularCustomersListingProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    private \Magento\Backend\Model\UrlInterface $urlBuilder;

    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    /**
     * @param \Magento\Backend\Model\UrlInterface $urlBuilder
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Magento\Framework\Api\Search\ReportingInterface $reporting
     * @param \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Api\Search\ReportingInterface $reporting,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->urlBuilder = $urlBuilder;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = parent::getData();
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('name')
            ->addIdFilter(array_column($data['items'], 'product_id'));

        foreach ($data['items'] as &$item) {
            $item['product_link'] = $this->urlBuilder->getUrl('catalog/product/edit', ['id' => $item['product_id']]);
            /** @var Product $product */
            $product = $productCollection->getItemById($item['product_id']);
            $item['product_name'] = $product->getName();
        }

        return $data;
    }
}
