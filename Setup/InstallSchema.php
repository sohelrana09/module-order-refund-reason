<?php
namespace SR\OrderRefundReason\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'sr_order_refund_reason'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('sr_order_refund_reason')
        )->addColumn(
            'order_refund_reason_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Order Refund Reason ID'
        )->addColumn(
            'order_refund_reason_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => false],
            'Order Refund Reason Title'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Refund Reason Active'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Order Refund Reason Creation Time'
        )->addColumn(
            'updated_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Order Refund Reason Modification Time'
        )->setComment(
            'Order Refund Reason Main Table'
        );

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'sr_order_refund_reason_mapping'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('sr_order_refund_reason_mapping')
        )->addColumn(
            'order_refund_reason_mapping_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'unsigned'  => true, 'primary' => true],
            'Order Refund Reason Mapping ID'
        )->addColumn(
            'order_refund_reason_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Order Refund Reason ID'
        )->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true, 'primary' => true],
            'Order ID'
        )->addColumn(
            'order_refund_reason_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => false],
            'Order Refund Reason Title'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Order Refund Reason Mapping Creation Time'
        )->addIndex(
            'IDX_CREATED_AT',
            ['created_at']
        )->addIndex(
            'IDX_ORDER_ID',
            ['order_id']
        )->addForeignKey(
            'FK_ORDER_REFUND_REASON_ID',
            'order_refund_reason_id',
            $installer->getTable('sr_order_refund_reason'),
            'order_refund_reason_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Order Refund Reason Mapping Table'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
