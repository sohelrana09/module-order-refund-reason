<?php
namespace SR\OrderRefundReason\Controller\Adminhtml\Manage;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface
     */
    protected $refundReasonRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface $refundReasonRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface $refundReasonRepository
    ){

        $this->refundReasonRepository = $refundReasonRepository;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->refundReasonRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The refund reason has been deleted.'));
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The refund reason no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/manage/edit', ['id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the refund reason'));
                return $resultRedirect->setPath('*/manage/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a refund reason to delete.'));
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}
