<?php
namespace SR\OrderRefundReason\Helper;

use \SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping\CollectionFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }

    /*
     * Return all refund reason by order id
     *
     * @return \SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping\Collection
     */
    public function getOrderRefundReason($orderId)
    {
        return $this->collectionFactory->create()->addFieldToFilter('order_id', $orderId);
    }
}
