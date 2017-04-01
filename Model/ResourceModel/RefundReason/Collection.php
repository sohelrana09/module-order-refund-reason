<?php
namespace SR\OrderRefundReason\Model\ResourceModel\RefundReason;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'order_refund_reason_id';

    /**
     * Collection Model
     */
    protected function _construct()
    {
        $this->_init('SR\OrderRefundReason\Model\RefundReason', 'SR\OrderRefundReason\Model\ResourceModel\RefundReason');
    }
}