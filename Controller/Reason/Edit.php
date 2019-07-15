<?php

namespace Space48\OrderReason\Controller\Reason;

use Space48\OrderReason\Controller\AbstractAction;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Edit
 * @package Space48\OrderReason\Controller\Reason
 */
class Edit extends AbstractAction
{
    /**
     * @return ResponseInterface|ResultInterface|void
     * @throws \RuntimeException
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->loadLayoutUpdates();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Add Order Reason'));
        if ($this->getRequest()->getParam('id')) {
            $this->_view->getPage()->getConfig()->getTitle()->set(__('Edit Order Reason'));
        }
        $this->_view->renderLayout();
    }
}
