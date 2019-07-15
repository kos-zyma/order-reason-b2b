<?php

namespace Space48\OrderReason\Model\ResourceModel\Reason;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    const COMPANY_ID = 'company_id';

    protected $_idFieldName = 'reason_id';
    protected $_eventPrefix = 'reason_collection';
    protected $_eventObject = 'reason_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Space48\OrderReason\Model\Reason', 'Space48\OrderReason\Model\ResourceModel\Reason');
    }

    public function addCompanyFilter($companyId)
    {
        return $this->addFieldToFilter(
            self::COMPANY_ID,
            [
                'eq' => $companyId
            ]
        );
    }
}
