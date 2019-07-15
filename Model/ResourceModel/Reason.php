<?php

namespace Space48\OrderReason\Model\ResourceModel;

class Reason extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const MAIN_TABLE = 'company_order_reasons';
    const MAIN_TABLE_ID = 'reason_id';

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::MAIN_TABLE_ID);
    }
}
