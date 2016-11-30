<?php
namespace SR\OrderRefundReason\Block\Adminhtml\RefundReason\Edit;

use Magento\Backend\Block\Widget\Context;
use SR\OrderRefundReason\Api\RefundReasonRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var RefundReasonRepositoryInterface
     */
    protected $refundReasonRepository;

    /**
     * @param Context $context
     * @param RefundReasonRepositoryInterface $refundReasonRepository
     */
    public function __construct(
        Context $context,
        RefundReasonRepositoryInterface $refundReasonRepository
    ) {
        $this->context = $context;
        $this->refundReasonRepository = $refundReasonRepository;
    }

    /**
     * Return ID
     *
     * @return int|null
     */
    public function getId()
    {
        try {
            return $this->refundReasonRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
