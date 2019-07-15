<?php

namespace Space48\OrderReason\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Company install schema.
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * Company table name.
     */
    const COMPANY_TABLE_NAME = 'company';

    /**
     * User roles table name.
     */
    const ORDER_REASONS = 'company_order_reasons';


    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'company_order_reasons'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::ORDER_REASONS)
        )->addColumn(
            'reason_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Primary ID'
        )->addColumn(
            'company_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Company ID'
        )->addColumn(
            'reason',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Reason'
        )->addForeignKey(
            $installer->getFkName(
                self::ORDER_REASONS,
                'company_id',
                self::COMPANY_TABLE_NAME,
                'entity_id'
            ),
            'company_id',
            $installer->getTable(self::COMPANY_TABLE_NAME),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addIndex(
            $installer->getIdxName(
                $installer->getTable(self::ORDER_REASONS),
                ['company_id']
            ),
            ['company_id']
        )->setComment(
            'Reasons Table'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
