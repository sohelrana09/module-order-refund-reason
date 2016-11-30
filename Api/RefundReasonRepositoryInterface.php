<?php
namespace SR\OrderRefundReason\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Refund Reason CRUD interface.
 * @api
 */
interface RefundReasonRepositoryInterface
{
    /**
     * Save refund reason.
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason);

    /**
     * Retrieve refund reason.
     *
     * @param int $refundReasonId
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($refundReasonId);

    /**
     * Retrieve refund reason matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete refund reason.
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason);

    /**
     * Delete refund reason by ID.
     *
     * @param int $refundReasonId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($refundReasonId);
}
