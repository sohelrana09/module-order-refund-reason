<?php
namespace SR\OrderRefundReason\Controller\Adminhtml\Manage;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('SR_Reason::refundreason');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Order Refund Reason'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Order Refund Reason'), __('Order Refund Reason'));
        $resultPage->addBreadcrumb(__('Manage Order Refund Reason'), __('Manage Order Refund Reason'));

        return $resultPage;
    }
}
