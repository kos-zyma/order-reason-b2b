<?php

namespace Space48\OrderReason\Controller\Reason;

use Space48\OrderReason\Controller\AbstractAction;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Delete
 * @package Space48\OrderReason\Controller\Reason
 */
class Delete extends AbstractAction
{
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create()->setPath('reasons');

        try {
            /** @var \Space48\OrderReason\Model\Reason $reason */
            $reason= $this->reasonFactory->create()->load($this->getRequest()->getParam('id'));
            if ($reason) {
                $reason->delete();
            }

            $this->messageManager->addSuccessMessage(__('Order reason has been deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred when trying to delete the order reason.'));
            $this->logger->critical($e);
        }

        return $resultRedirect;
    }
}
