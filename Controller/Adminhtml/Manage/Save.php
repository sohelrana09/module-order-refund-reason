<?php
namespace SR\OrderRefundReason\Controller\Adminhtml\Manage;

use \SR\OrderRefundReason\Model\RefundReasonFactory;
use \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use SR\OrderRefundReason\Api\Data\RefundReasonInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var RefundReasonFactory
     */
    protected $refundReasonFactory;

    /**
     * @var RefundReasonRepositoryInterface
     */
    protected $refundReasonRepository;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param RefundReasonFactory $refundReasonFactory
     * @param RefundReasonRepositoryInterface $refundReasonRepository
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        RefundReasonFactory $refundReasonFactory,
        RefundReasonRepositoryInterface $refundReasonRepository,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->refundReasonRepository = $refundReasonRepository;
        $this->refundReasonFactory = $refundReasonFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if(isset($data['general'])) {
            $data = $data['general'];
            $id = !empty($data['order_refund_reason_id']) ? $data['order_refund_reason_id'] : null;

            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            if (isset($data)) {
                try {
                    if ($id) {
                        $model = $this->refundReasonRepository->getById((int)$id);
                    } else {
                        unset($data['id']);
                        $model = $this->refundReasonFactory->create();
                    }

                    $this->dataObjectHelper->populateWithArray($model, $data, RefundReasonInterface::class);
                    $this->refundReasonRepository->save($model);
                    $this->messageManager->addSuccessMessage(__('You saved the refund reason'));
                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                    } else {
                        $resultRedirect->setPath('*/*');
                    }
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    if ($model != null) {
                        $this->storeReasonDataToSession(
                            $this->dataObjectProcessor->buildOutputDataArray(
                                $model,
                                RefundReasonInterface::class
                            )
                        );
                    }
                    $resultRedirect->setPath('*/*/edit', ['id' => $id]);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('There was a problem saving the refund reason'));
                    if ($model != null) {
                        $this->storeReasonDataToSession(
                            $this->dataObjectProcessor->buildOutputDataArray(
                                $model,
                                RefundReasonInterface::class
                            )
                        );
                    }
                    $resultRedirect->setPath('*/*/edit', ['id' => $id]);
                }

            }
        }

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $reasonData
     */
    protected function storeReasonDataToSession($reasonData)
    {
        $this->_getSession()->setReasonData($reasonData);
    }
}
