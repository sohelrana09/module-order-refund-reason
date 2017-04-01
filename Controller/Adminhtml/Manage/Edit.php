<?php
namespace SR\OrderRefundReason\Controller\Adminhtml\Manage;

use SR\OrderRefundReason\Controller\RegistryConstants;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface
     */
    protected $refundReasonRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface $refundReasonRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \SR\OrderRefundReason\Api\RefundReasonRepositoryInterface $refundReasonRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->refundReasonRepository = $refundReasonRepository;
        parent::__construct($context);
    }

    /**
     * Initialize current refund reason and set it in the registry.
     *
     * @return int
     */
    protected function _initRefundReason()
    {
        $refundReasonId = $this->getRequest()->getParam('id');
        return $refundReasonId;
    }

    /**
     * Edit Order Refund Reason
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $refundReasonId = $this->_initRefundReason();

        // 2. Initial checking
        if ($refundReasonId) {
            $model = $this->refundReasonRepository->getById($refundReasonId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Order Refund Reason no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(
            $refundReasonId ? __('Edit Refund Reason') : __('New Refund Reason'),
            $refundReasonId ? __('Edit Refund Reason') : __('New Refund Reason')
        );

        if ($refundReasonId) {
            $title =  __("Edit Refund Reason '%1'", $model->getOrderRefundReasonTitle());
            $resultPage->getConfig()->getTitle()->prepend($title);
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Refund Reason'));
        }

        return $resultPage;
    }
}
