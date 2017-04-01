<?php
namespace SR\OrderRefundReason\Observer;

use Magento\Framework\Event\ObserverInterface;
use \SR\OrderRefundReason\Model\RefundReasonMappingFactory;
use \SR\OrderRefundReason\Api\RefundReasonMappingRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface;
use SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface;

class ControllerActionPostdispatchRefundReasonSave implements ObserverInterface
{
    /**
     * @var RefundReasonMappingFactory
     */
    protected $refundReasonMappingFactory;

    /**
     * @var RefundReasonMappingRepositoryInterface
     */
    protected $refundReasonMappingRepository;

    /**
     * @var RefundReasonRepositoryInterface
     */
    protected $refundReasonRepository;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @param RefundReasonMappingFactory $refundReasonFactory
     * @param RefundReasonMappingRepositoryInterface $refundReasonRepository
     * @param RefundReasonRepositoryInterface $refundReasonRepository
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        RefundReasonMappingFactory $refundReasonMappingFactory,
        RefundReasonMappingRepositoryInterface $refundReasonMappingRepository,
        RefundReasonRepositoryInterface $refundReasonRepository,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->refundReasonMappingRepository = $refundReasonMappingRepository;
        $this->refundReasonMappingFactory = $refundReasonMappingFactory;
        $this->refundReasonRepository = $refundReasonRepository;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($observer->getRequest()->getFullActionName() == 'sales_order_creditmemo_save') {
            $request = $observer->getRequest();
            $creditmemoData = $request->getParam('creditmemo');
            if(isset($creditmemoData['refund_reason']) && ($creditmemoData['refund_reason'] != '')) {
                $refundReason = $this->refundReasonRepository->getById($creditmemoData['refund_reason']);
                $order_id = $observer->getRequest()->getParam('order_id');
                $saveData = [
                    'order_id' => $order_id,
                    'order_refund_reason_id' => $creditmemoData['refund_reason'],
                    'order_refund_reason_title' => $refundReason->getOrderRefundReasonTitle()
                ];

                $model = $this->refundReasonMappingFactory->create();
                $this->dataObjectHelper->populateWithArray($model, $saveData, RefundReasonMappingInterface::class);
                $this->refundReasonMappingRepository->save($model);
            }
        }
    }
}