<?php
namespace SR\OrderRefundReason\Controller\Adminhtml\Manage;

use \SR\OrderRefundReason\Model\RefundReasonFactory;
use \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use SR\OrderRefundReason\Api\Data\RefundReasonInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

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
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param RefundReasonFactory $refundReasonFactory
     * @param RefundReasonRepositoryInterface $refundReasonRepository
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        RefundReasonFactory $refundReasonFactory,
        RefundReasonRepositoryInterface $refundReasonRepository,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        DataPersistorInterface $dataPersistor
    ) {
        $this->refundReasonRepository = $refundReasonRepository;
        $this->refundReasonFactory = $refundReasonFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPersistor = $dataPersistor;

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

        $id = !empty($data['order_refund_reason_id']) ? $data['order_refund_reason_id'] : null;

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $model = $this->refundReasonRepository->getById((int)$id);
            } else {
                unset($data['order_refund_reason_id']);
                $model = $this->refundReasonFactory->create();
            }

            $model->setData($data);
            $model = $this->refundReasonRepository->save($model);
            $this->dataPersistor->clear('refund_reason_data');
            $this->messageManager->addSuccessMessage(__('You saved the refund reason'));
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }
            return $resultRedirect->setPath('*/*');
        } catch (\Magento\Framework\Validator\Exception $exception) {
            $messages = $exception->getMessages();
            if (empty($messages)) {
                $messages = [$exception->getMessage()];
            }
            foreach ($messages as $message) {
                if (!$message instanceof Error) {
                    $message = new Error($message);
                }
                $this->messageManager->addMessage($message);
            }
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage(
                $exception,
                __('Something went wrong while saving the refund reason.')
            );
        }
        $this->dataPersistor->set('refund_reason_data', $data);

        if ($id) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/new', ['_current' => true]);

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
