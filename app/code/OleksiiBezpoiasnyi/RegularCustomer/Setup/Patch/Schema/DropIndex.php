<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Setup\Patch\Schema;

class DropIndex implements \Magento\Framework\Setup\Patch\SchemaPatchInterface
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
     * @inheritDoc
     */
    public function apply(): void
    {
        $configData = $this->deploymentConfig->getConfigData('db');
        $dbName = $configData['connection']['default']['dbname'];

        $indexList = $this->schemaSetup->getConnection()->getIndexList(
            $this->schemaSetup->getTable('oleksiib_regular_customer'),
            $dbName
        );

        $keyword = 'EMAIL_WEBSITE_ID';

        foreach ($indexList as $index => $name) {
            if (stripos($index, $keyword)) {
                $indexName = $index;
            }
        }

        $this->schemaSetup->getConnection()
            ->dropIndex(
                $this->schemaSetup->getTable('oleksiib_regular_customer'),
                $indexName,
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
