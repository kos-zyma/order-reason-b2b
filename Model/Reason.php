<?php

namespace Space48\OrderReason\Model;

class Reason extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'reason';

    protected $_cacheTag = 'reason';

    protected $_eventPrefix = 'reason';

    protected function _construct()
    {
        $this->_init('Space48\OrderReason\Model\ResourceModel\Reason');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}