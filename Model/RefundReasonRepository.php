<?php
namespace SR\OrderRefundReason\Model;

use SR\OrderRefundReason\Api\Data;
use SR\OrderRefundReason\Api\RefundReasonRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use SR\OrderRefundReason\Model\ResourceModel\RefundReason as ResourceRefundReason;
use SR\OrderRefundReason\Model\ResourceModel\RefundReason\CollectionFactory as RefundReasonCollectionFactory;
use Magento\Framework\EntityManager\EntityManager;

class RefundReasonRepository implements RefundReasonRepositoryInterface
{
    /**
     * @var ResourceRefundReason
     */
    protected $resource;

    /**
     * @var RefundReasonFactory
     */
    protected $refundReasonFactory;

    /**
     * @var RefundReasonCollectionFactory
     */
    protected $refundReasonCollectionFactory;

    /**
     * @var Data\RefundReasonSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \SR\OrderRefundReason\Api\Data\RefundReasonInterfaceFactory
     */
    protected $dataRefundReasonFactory;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param ResourceRefundReason $resource
     * @param RefundReasonFactory $refundReasonFactory
     * @param Data\RefundReasonInterfaceFactory $dataRefundReasonFactory
     * @param RefundReasonCollectionFactory $refundReasonCollectionFactory
     * @param Data\RefundReasonSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param EntityManager $entityManager
     */
    public function __construct(
        ResourceRefundReason $resource,
        RefundReasonFactory $refundReasonFactory,
        Data\RefundReasonInterfaceFactory $dataRefundReasonFactory,
        RefundReasonCollectionFactory $refundReasonCollectionFactory,
        Data\RefundReasonSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        EntityManager $entityManager
    ) {
        $this->resource = $resource;
        $this->refundReasonFactory = $refundReasonFactory;
        $this->refundReasonCollectionFactory = $refundReasonCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRefundReasonFactory = $dataRefundReasonFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason)
    {
        /** @var \SR\OrderRefundReason\Model\RefundReason $bannerModel */
        $refundReasonModel = $this->refundReasonFactory->create();
        if ($refundReasonId = $refundReason->getId()) {
            $this->entityManager->load($refundReasonModel, $refundReasonId);
        }

        $refundReasonModel->addData(
            $this->dataObjectProcessor->buildOutputDataArray($refundReason, Data\RefundReasonInterface::class)
        );

        $this->entityManager->save($refundReasonModel);
        return $refundReasonModel;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($refundReasonId)
    {
        /** @var \SR\OrderRefundReason\Model\RefundReason $bannerModel */
        $refundReasonModel = $this->refundReasonFactory->create();
        $this->entityManager->load($refundReasonModel, $refundReasonId);
        if (!$refundReasonModel->getId()) {
            throw NoSuchEntityException::singleField('refundReasonId', $refundReasonId);
        }
        return $refundReasonModel;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->refundReasonCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $values = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $conditionType = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = [$filter->getField()];
                $values[] = [ $conditionType => $filter->getValue()];
            }

            if ($fields) {
                $collection->addFieldToFilter($fields, $values);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason)
    {
        return $this->deleteById($refundReason->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($refundReasonId)
    {
        /** @var \SR\OrderRefundReason\Model\RefundReason $bannerModel */
        $refundReasonModel = $this->refundReasonFactory->create();
        $this->entityManager->load($refundReasonModel, $refundReasonId);
        if (!$refundReasonModel->getId()) {
            throw NoSuchEntityException::singleField('refundReasonId', $refundReasonId);
        }
        $this->entityManager->delete($refundReasonModel);
        return true;
    }
}