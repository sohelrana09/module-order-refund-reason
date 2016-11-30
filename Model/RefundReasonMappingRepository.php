<?php
namespace SR\OrderRefundReason\Model;

use SR\OrderRefundReason\Api\RefundReasonMappingRepositoryInterface;
use SR\OrderRefundReason\Api\Data;
use Magento\Framework\Exception\CouldNotSaveException;
use SR\OrderRefundReason\Model\ResourceModel\RefundReasonMapping as ResourceRefundReasonMapping;

class RefundReasonMappingRepository implements RefundReasonMappingRepositoryInterface
{
    /**
     * @var ResourceRefundReasonMapping
     */
    protected $resource;

    /**
     * @param ResourceRefundReasonMapping $resource
     */
    public function __construct(
        ResourceRefundReasonMapping $resource
    ) {
        $this->resource = $resource;
    }

    /**
     * Save Refund Reason Mapping data
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface $refundReasonMapping
     * @return $refundReasonMapping
     * @throws CouldNotSaveException
     */
    public function save(\SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface $refundReasonMapping)
    {
        try {
            $this->resource->save($refundReasonMapping);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Refund Reason: %1',
                $exception->getMessage()
            ));
        }

        return $refundReasonMapping;
    }
}