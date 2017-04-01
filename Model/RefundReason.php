<?php
namespace SR\OrderRefundReason\Model;

use SR\OrderRefundReason\Api\Data\RefundReasonInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class RefundReason extends AbstractModel implements RefundReasonInterface, IdentityInterface
{
    /**
     * Refund Reason cache tag
     */
    const CACHE_TAG = 'refund_reason';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('SR\OrderRefundReason\Model\ResourceModel\RefundReason');
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
        return parent::getData(self::REASON_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getOrderRefundReasonTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
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
     * Set ID
     *
     * @param int $id
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setId($id)
    {
        return $this->setData(self::REASON_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setOrderRefundReasonTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set created At
     *
     * @param string $createdAt
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set update at
     *
     * @param string $updatedAt
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}