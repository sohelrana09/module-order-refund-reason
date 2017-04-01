<?php
namespace SR\OrderRefundReason\Model;

use SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface;
use SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping as ResourceRefundReasonMapping;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class RefundReasonMapping extends AbstractModel implements RefundReasonMappingInterface, IdentityInterface
{
    /**
     * Refund Reason cache tag
     */
    const CACHE_TAG = 'refund_reason_mapping';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return parent::getData(self::REASON_MAPPING_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getOrderRefundReasonTitle()
    {
        return $this->getData(self::REASON_TITLE);
    }

    /**
     * Get Created time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get Order Id
     *
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Get Reason Id
     *
     * @return int|null
     */
    public function getOrderRefundReasonId()
    {
        return $this->getData(self::REASON_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setId($id)
    {
        return $this->setData(self::REASON_MAPPING_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setOrderRefundReasonTitle($title)
    {
        return $this->setData(self::REASON_TITLE, $title);
    }

    /**
     * Set created At
     *
     * @param string $createdAt
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set Order Id
     *
     * @param int $orderId
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Set Reason Id
     *
     * @param int $refundReasonId
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setOrderRefundReasonId($refundReasonId)
    {
        return $this->setData(self::REASON_ID, $refundReasonId);
    }
}