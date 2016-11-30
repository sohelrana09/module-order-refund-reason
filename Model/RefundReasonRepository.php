<?php
namespace SR\OrderRefundReason\Model;

use SR\OrderRefundReason\Api\Data;
use SR\OrderRefundReason\Api\RefundReasonRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use SR\OrderRefundReason\Model\ResourceModel\RefundReason as ResourceRefundReason;
use SR\OrderRefundReason\Model\ResourceModel\RefundReason\CollectionFactory as RefundReasonCollectionFactory;

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
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceRefundReason $resource
     * @param RefundReasonFactory $refundReasonFactory
     * @param Data\RefundReasonInterfaceFactory $dataRefundReasonFactory
     * @param RefundReasonCollectionFactory $refundReasonCollectionFactory
     * @param Data\RefundReasonSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ResourceRefundReason $resource,
        RefundReasonFactory $refundReasonFactory,
        Data\RefundReasonInterfaceFactory $dataRefundReasonFactory,
        RefundReasonCollectionFactory $refundReasonCollectionFactory,
        Data\RefundReasonSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->refundReasonFactory = $refundReasonFactory;
        $this->refundReasonCollectionFactory = $refundReasonCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRefundReasonFactory = $dataRefundReasonFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save Refund Reason data
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason
     * @return $refundReason
     * @throws CouldNotSaveException
     */
    public function save(\SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason)
    {
        try {
            $this->resource->save($refundReason);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Refund Reason: %1',
                $exception->getMessage()
            ));
        }
        return $refundReason;
    }

    /**
     * Retrieve refund reason.
     *
     * @param string $refundReasonId
     * @return $refundReason
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($refundReasonId)
    {
        $refundReason = $this->refundReasonFactory->create();
        $refundReason->load($refundReasonId);
        if (!$refundReason->getId()) {
            throw new NoSuchEntityException(__('Refund Reason with id "%1" does not exist.', $refundReasonId));
        }
        return $refundReason;
    }

    /**
     * Retrieve refund reason matching the specified criteria.
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \SR\OrderRefundReason\Model\ResourceModel\RefundReason\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->refundReasonCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
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
        $refundReasonss = [];
        /** @var RefundReason $refundReasonModel */
        foreach ($collection as $refundReasonModel) {
            $refundReasonData = $this->dataRefundReasonFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $refundReasonData,
                $refundReasonModel->getData(),
                'SR\OrderRefundReason\Api\Data\RefundReasonInterface'
            );
            $refundReasonss[] = $this->dataObjectProcessor->buildOutputDataArray(
                $refundReasonData,
                'SR\OrderRefundReason\Api\Data\RefundReasonInterface'
            );
        }
        $searchResults->setItems($refundReasonss);
        return $searchResults;
    }

    /**
     * Delete refund reason.
     *
     * @param \SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\SR\OrderRefundReason\Api\Data\RefundReasonInterface $refundReason)
    {
        try {
            $this->resource->delete($refundReason);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Refund Reason: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete refund reason by ID.
     *
     * @param string $refundReasonId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($refundReasonId)
    {
        return $this->delete($this->getById($refundReasonId));
    }
}