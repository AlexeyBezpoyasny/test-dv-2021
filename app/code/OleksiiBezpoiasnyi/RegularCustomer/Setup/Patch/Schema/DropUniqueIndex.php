<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Setup\Patch\Schema;

class DropUniqueIndex implements \Magento\Framework\Setup\Patch\SchemaPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface $schemaSetup
     */
    private $schemaSetup;
    /**
     * @var \Magento\Framework\App\DeploymentConfig
     */
    private $deploymentConfig;

    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     */
    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ) {
        $this->schemaSetup = $schemaSetup;
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * @return string
     */
    public function getIndexName(): string
    {
        $configData = $this->deploymentConfig->getConfigData('db');
        $dbName = $configData['connection']['default']['dbname'];

        $indexList = $this->schemaSetup->getConnection()->getIndexList(
            $this->schemaSetup->getTable('oleksiib_regular_customer'),
            $dbName
        );

        $columnItem = 'email';
        $columnItemTwo = 'website_id';

        foreach ($indexList as $indexItem) {
            if (in_array($columnItem, $indexItem['COLUMNS_LIST'], true)
                && in_array($columnItemTwo, $indexItem['COLUMNS_LIST'], true)) {
                $name = $indexItem['KEY_NAME'];
            }
        }
        /** @var string $name */
        return $name;
    }

    /**
     * @inheritDoc
     */
    public function apply(): void
    {
        $configData = $this->deploymentConfig->getConfigData('db');
        $dbName = $configData['connection']['default']['dbname'];

        $this->schemaSetup->getConnection()
                    ->dropIndex(
                        $this->schemaSetup->getTable('oleksiib_regular_customer'),
                        $this->getIndexName(),
                        $dbName
                    );
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
