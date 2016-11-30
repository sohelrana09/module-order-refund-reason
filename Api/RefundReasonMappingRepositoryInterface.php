<?php
namespace SR\OrderRefundReason\Api;

/**
 * Refund Reason Mapping CRUD interface.
 * @api
 */
interface RefundReasonMappingRepositoryInterface
{
    /**
     * Save refund reason mapping.
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface $refundReasonMapping
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface $refundReasonMapping);
}
