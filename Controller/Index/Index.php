<?php

namespace Space48\OrderReason\Controller\Index;

use Space48\OrderReason\Controller\AbstractAction;

/**
 * Class Index
 * @package Space48\OrderReason\Controller\Index
 */
class Index extends AbstractAction
{
    /**
     * Execute action based on request and return result
     *
     * @return void
     * @throws \RuntimeException
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->loadLayoutUpdates();
        $this->_view->getPage()->getConfig()->getTitle()->set('Order Reasons');
        $this->_view->renderLayout();
    }
}
