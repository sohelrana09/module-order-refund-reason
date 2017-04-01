<?php
namespace SR\OrderRefundReason\Model;

use SR\OrderRefundReason\Api\RefundReasonMappingRepositoryInterface;
use Magento\Framework\EntityManager\EntityManager;
use \SR\OrderRefundReason\Model\RefundReasonMappingFactory;
use Magento\Framework\Reflection\DataObjectProcessor;

class RefundReasonMappingRepository implements RefundReasonMappingRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;


    /**
     * @var RefundReasonMappingFactory
     */
    protected $refundReasonMappingFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @param EntityManager $entityManager
     * @param RefundReasonMappingFactory $refundReasonMappingFactory
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        EntityManager $entityManager,
        RefundReasonMappingFactory $refundReasonMappingFactory,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->entityManager = $entityManager;
        $this->refundReasonMappingFactory = $refundReasonMappingFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface $refundReasonMapping)
    {
        /** @var \SR\OrderRefundReason\Model\RefundReason $bannerModel */
        $refundReasonMappingModel = $this->refundReasonMappingFactory->create();
        if ($id = $refundReasonMapping->getId()) {
            $this->entityManager->load($refundReasonMappingModel, $id);
        }

        $refundReasonMappingModel->addData(
            $this->dataObjectProcessor->buildOutputDataArray($refundReasonMapping, \SR\OrderRefundReason\Api\Data\RefundReasonMappingInterface::class)
        );

        $this->entityManager->save($refundReasonMappingModel);
        return $refundReasonMappingModel;
    }
}