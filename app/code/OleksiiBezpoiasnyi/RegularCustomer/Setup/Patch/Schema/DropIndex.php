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
     * @param \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
     */
    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * @inheritDoc
     */
    public function apply(): void
    {
        $indexList = $this->schemaSetup->getConnection()->getIndexList(
            $this->schemaSetup->getTable('oleksiib_regular_customer'),
            'oleksii_bezpoiasnyi_dev_local'
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
                'oleksii_bezpoiasnyi_dev_local'
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
