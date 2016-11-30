<?php
namespace SR\OrderRefundReason\Setup;

use SR\OrderRefundReason\Model\RefundReason;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface
{
    protected $reason;

    public function __construct(RefundReason $reason){
        $this->reason = $reason;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $all_reason = [
            [
                'order_refund_reason_title' => 'I didn’t authorize this purchase',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ],
            [
                'order_refund_reason_title' => 'Didn’t mean to purchase this item',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ],
            [
                'order_refund_reason_title' => 'Meant to purchase different item',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ],
            [
                'order_refund_reason_title' => 'Item didn’t download or can’t be found',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ],
            [
                'order_refund_reason_title' => 'Item won’t install or downloads too slowly',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ],
            [
                'order_refund_reason_title' => 'Item opens but doesn’t function as expected',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ]
        ];

        /**
         * Insert reason
         */
        $allReasonIds = array();
        foreach ($all_reason as $data) {
            $reason = $this->reason->setData($data)->save();
            $allReasonIds[] = $reason->getOrderRefundReasonId();
        }

        $installer->endSetup();
    }
}
