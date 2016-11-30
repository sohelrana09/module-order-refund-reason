<?php
namespace SR\OrderRefundReason\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Refund Reason search results.
 * @api
 */
interface RefundReasonSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get refund reason list.
     *
     * @return \SR\OrderRefundReason\Api\Data\RefundReasonInterface[]
     */
    public function getItems();

    /**
     * Set refund reason list.
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}