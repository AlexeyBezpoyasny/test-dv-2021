<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Ui\Component\DiscountRequest\Listing;

use Magento\Framework\View\Element\UiComponentInterface;
use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;

class MassAction extends \Magento\Ui\Component\MassAction
{
    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization $authorization;

    /**
     * Constructor
     *
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization $authorization
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param UiComponentInterface[] $components
     * @param array $data
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization $authorization,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        $this->authorization = $authorization;
        parent::__construct($context, $components, $data);
    }

    /**
     * @inheritdoc
     */
    public function prepare(): void
    {
        $config = $this->getConfiguration();

        foreach ($this->getChildComponents() as $actionComponent) {
            $actionType = $actionComponent->getConfiguration()['type'];

            switch ($actionType) {
                case 'edit':
                    $alcResource = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;
                    break;
                case 'delete':
                    $alcResource = Authorization::ACTION_DISCOUNT_REQUEST_DELETE;
                    break;
                case 'sendEmail':
                    $alcResource = Authorization::ACTION_DISCOUNT_REQUEST;
                    break;
                default:
                    throw new \InvalidArgumentException("Unknown action type: $actionType");
            }

            if ($this->authorization->isActionAllowed($alcResource)) {
                $config['actions'][] = array_merge($actionComponent->getConfiguration());
            }
        }

        $origConfig = $this->getConfiguration();

        if ($origConfig === $config) {
            $config['componentDisabled'] = true;
        } else {
            $config = array_replace_recursive($config, $origConfig);
        }

        $this->setData('config', $config);
        $this->components = [];

        parent::prepare();
    }
}
