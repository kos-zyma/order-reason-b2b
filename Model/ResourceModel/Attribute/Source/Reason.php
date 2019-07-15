<?php

namespace Space48\OrderReason\Model\ResourceModel\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Space48\OrderReason\Model\ResourceModel\Reason\CollectionFactory as ReasonFactory;

/**
 * Class Reason
 * @package Space48\OrderReason\Model\ResourceModel\Attribute\Source
 */
class Reason extends AbstractSource
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;
    /**
     * @var ReasonFactory
     */
    private $reasonFactory;

    /**
     * @param ReasonFactory $reasonFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        ReasonFactory $reasonFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->registry = $registry;
        $this->reasonFactory = $reasonFactory;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = [];
        $reasons = [];

        $companyId = $this->getCompanyId();

        if ($companyId) {
            $reasons = $this->reasonFactory->create()->addCompanyFilter($companyId)->getItems();
        }
        foreach ($reasons as $reason) {
            $options[] = [
                'value' => $reason->getReasonId(),
                'label' => $reason->getReason(),
            ];
        }
        return $options;
    }

    /**
     * @return bool|mixed
     */
    private function getCompanyId()
    {
        if ($companyId = $this->registry->registry('cooneen_company_id')) {
            if ($companyId !== 0) {
                return $companyId;
            }
        }
        return false;
    }
}
