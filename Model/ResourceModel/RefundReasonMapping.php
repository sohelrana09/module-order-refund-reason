<?php
namespace SR\OrderRefundReason\Model\ResourceModel;

class RefundReasonMapping extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Resource Model
     */
    protected function _construct()
    {
        $this->_init('sr_order_refund_reason_mapping', 'order_refund_reason_mapping_id');
    }
}