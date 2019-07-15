<?php

namespace Space48\OrderReason\Controller\Reason;

use Space48\OrderReason\Controller\AbstractAction;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Add
 * @package Space48\OrderReason\Controller\Reason
 */
class Add extends AbstractAction
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        return $this->getForwardResult()->forward('edit');
    }
}
