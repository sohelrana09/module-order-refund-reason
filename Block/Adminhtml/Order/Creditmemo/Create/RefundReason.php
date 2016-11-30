<?php
namespace SR\OrderRefundReason\Block\Adminhtml\Order\Creditmemo\Create;

use SR\OrderRefundReason\Model\ResourceModel\RefundReason\CollectionFactory;

class RefundReason extends \Magento\Backend\Block\Template
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /*
     * Return all active refund reason
     *
     * @return \SR\OrderRefundReason\Model\ResourceModel\RefundReason\Collection
     */
    public function getAllRefundReason()
    {
        $collection = $this->collectionFactory->create()->addFieldToFilter('is_active', 1);
        return $collection;
    }
}