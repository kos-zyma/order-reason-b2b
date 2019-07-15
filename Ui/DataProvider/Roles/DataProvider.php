<?php

namespace Space48\OrderReason\Ui\DataProvider\Roles;

use Magento\Company\Model\CompanyUser;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as UiComponentDataProvider;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use Psr\Log\LoggerInterface;
use Space48\OrderReason\Model\ResourceModel\Reason\CollectionFactory as ReasonFactory;

/**
 * Class DataProvider
 */
class DataProvider extends UiComponentDataProvider
{
    /**
     * @var CompanyUser
     */
    private $companyUser;

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ReasonFactory
     */
    private $reasonFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Reporting $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param CompanyUser $companyUser
     * @param LoggerInterface $logger
     * @param ReasonFactory $reasonFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Reporting $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        CompanyUser $companyUser,
        LoggerInterface $logger,
        ReasonFactory $reasonFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->companyUser = $companyUser;
        $this->logger = $logger;
        $this->reasonFactory = $reasonFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->formatOutput($this->getSearchResult());
    }

    /**
     * Returns Search Result
     *
     * @return array
     */
    public function getSearchResult()
    {
        $data = [];
        try {
            $companyId = $this->companyUser->getCurrentCompanyId();
            $data['items'] = $this->reasonFactory->create()->addCompanyFilter($companyId)->getItems();
        } catch (NoSuchEntityException $e) {
            $this->logger->error($e);
        } catch (LocalizedException $e) {
            $this->logger->error($e);
        }
        return $data;
    }

    /**
     * @param array $searchResult
     * @return array
     */
    private function formatOutput($searchResult)
    {
        $arrItems = [];
        $arrItems['totalRecords'] = count($searchResult['items']);
        $arrItems['items'] = [];

        /** @var $item Reason */
        foreach ($searchResult['items'] as $item) {
            $itemData = $item->toArray();
            $itemData['id_field_name'] = 'id';
            $itemData['sort_order'] = 0;
            $arrItems['items'][] = $itemData;
        }
        return $arrItems;
    }
}
