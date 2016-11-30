<?php
namespace SR\OrderRefundReason\Api\Data;

/**
 * Refund Reason interface.
 * @api
 */
interface RefundReasonInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const REASON_ID                = 'order_refund_reason_id';
    const TITLE                    = 'order_refund_reason_title';
    const IS_ACTIVE                = 'is_active';
    const CREATED_AT               = 'created_at';
    const UPDATED_AT               = 'updated_at';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Get Created time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setOrderRefundReasonTitle($title);

    /**
     * Set created At
     *
     * @param string $createdAt
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set update at
     *
     * @param string $updatedAt
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     */
    public function setIsActive($isActive);
}
