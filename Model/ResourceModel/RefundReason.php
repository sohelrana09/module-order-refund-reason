<?php
namespace SR\OrderRefundReason\Model\ResourceModel;

class RefundReason extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Resource Model
     */
    protected function _construct()
    {
        $this->_init('sr_order_refund_reason', 'order_refund_reason_id');
    }
}