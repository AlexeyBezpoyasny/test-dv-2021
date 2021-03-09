<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Ui\Component\DiscountRequest\Listing\Column;

use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;

class BlockActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    private const URL_PATH_EDIT = 'oleksiib_regular_customers/discount/edit';

    private const URL_PATH_DELETE = 'oleksiib_regular_customers/discount/delete';

    private \Magento\Framework\UrlInterface $urlBuilder;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization $authorization;

    /**
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization $authorization
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization $authorization,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheridoc
     */
    public function prepare(): void
    {
        parent::prepare();

        $editAllowed = $this->authorization->isActionAllowed(Authorization::ACTION_DISCOUNT_REQUEST_EDIT);
        $deleteAllowed = $this->authorization->isActionAllowed(Authorization::ACTION_DISCOUNT_REQUEST_DELETE);

        if (!$editAllowed && !$deleteAllowed) {
            $config = $this->getConfiguration();
            $config['componentDisabled'] = true;
            $this->setData('config', $config);
        }
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        $editAllowed = $this->authorization->isActionAllowed(Authorization::ACTION_DISCOUNT_REQUEST_EDIT);
        $deleteAllowed = $this->authorization->isActionAllowed(Authorization::ACTION_DISCOUNT_REQUEST_DELETE);

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['request_id'])) {
                    if ($editAllowed) {
                        $item[$this->getData('name')]['edit'] = [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'request_id' => $item['request_id'],
                                ]
                            ),
                            'label' => __('Edit')
                        ];
                    }

                    if ($deleteAllowed) {
                        $item[$this->getData('name')]['delete'] = [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'request_id' => $item['request_id'],
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete'),
                                'message' => __('Are you sure you want to delete this request?'),
                            ],
                            'post' => true
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}
