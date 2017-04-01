<?php
namespace SR\OrderRefundReason\Model\RefundReason;

use SR\OrderRefundReason\Model\ResourceModel\RefundReason\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $refundReason \SR\OrderRefundReason\Model\RefundReason */
        foreach ($items as $refundReason) {
            $this->loadedData[$refundReason->getId()] = $refundReason->getData();
        }

        $data = $this->dataPersistor->get('refund_reason_data');
        if (!empty($data)) {
            $refundReason = $this->collection->getNewEmptyItem();
            $refundReason->setData($data);
            $this->loadedData[$refundReason->getId()] = $refundReason->getData();
            $this->dataPersistor->clear('refund_reason_data');
        }

        return $this->loadedData;
    }
}