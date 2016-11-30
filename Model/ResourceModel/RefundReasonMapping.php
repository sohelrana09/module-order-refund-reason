<?php
namespace SR\OrderRefundReason\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Model\AbstractModel;

class RefundReasonMapping extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @param Context $context
     * @param DateTime $date
     */
    public function __construct(
        Context $context,
        DateTime $date
    ) {
        $this->date = $date;

        parent::__construct($context);
    }

    /**
     * Resource Model
     */
    protected function _construct()
    {
        $this->_init('sr_order_refund_reason_mapping', 'order_refund_reason_mapping_id');
    }

    /**
     * before save callback
     *
     * @param AbstractModel|\SR\OrderRefundReason\Model\RefundReasonMapping $object
     * @return $this
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->date->gmtDate());
        }
        return parent::_beforeSave($object);
    }
}