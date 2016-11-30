<?php
namespace SR\OrderRefundReason\Api\Data;

/**
 * Refund Reason Mapping interface.
 * @api
 */
interface RefundReasonMappingInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const REASON_MAPPING_ID        = 'order_refund_reason_mapping_id';
    const ORDER_ID                 = 'order_id';
    const REASON_ID                = 'order_refund_reason_id';
    const REASON_TITLE             = 'order_refund_reason_title';
    const CREATED_AT               = 'created_at';
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
     * Get Created time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get Order Id
     *
     * @return int|null
     */
    public function getOrderId();

    /**
     * Get Reason Id
     *
     * @return int
     */
    public function getOrderRefundReasonId();

    /**
     * Set ID
     *
     * @param int $id
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setOrderRefundReasonTitle($title);

    /**
     * Set created At
     *
     * @param string $createdAt
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set Order Id
     *
     * @param int $orderId
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setOrderId($orderId);

    /**
     * Set Reason Id
     *
     * @param int $refundReasonId
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     */
    public function setOrderRefundReasonId($refundReasonId);
}
