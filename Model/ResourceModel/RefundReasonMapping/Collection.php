<?php
namespace SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'order_refund_reason_mapping_id';

    /**
     * Collection Model
     */
    protected function _construct()
    {
        $this->_init('SR\OrderRefundReason\Model\RefundReasonMapping', 'SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping');
    }
}