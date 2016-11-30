<?php
namespace SR\OrderRefundReason\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface as RefundReasonRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use SR\OrderRefundReason\Api\Data\RefundReasonInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var RefundReasonRepository  */
    protected $refundReasonRepository;

    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param RefundReasonRepository $refundReasonRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        RefundReasonRepository $refundReasonRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->refundReasonRepository = $refundReasonRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $refundReasonId) {
                    /** @var \SR\OrderRefundReason\Model\RefundReason $refundReason */
                    $refundReason = $this->refundReasonRepository->getById($refundReasonId);
                    try {
                        $refundReason->setData(array_merge($refundReason->getData(), $postItems[$refundReasonId]));
                        $this->refundReasonRepository->save($refundReason);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithRefundReasonId(
                            $refundReason,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add refund reason title to error message
     *
     * @param RefundReasonInterface $refundReason
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithRefundReasonId(RefundReasonInterface $refundReason, $errorText)
    {
        return '[Refund Reason ID: ' . $refundReason->getId() . '] ' . $errorText;
    }
}
