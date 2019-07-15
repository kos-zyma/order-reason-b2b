<?php

namespace Space48\OrderReason\Controller;

use Magento\Company\Api\CompanyRepositoryInterface;
use Magento\Company\Model\CompanyContext;
use Magento\Company\Model\CompanyUser;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Psr\Log\LoggerInterface;
use Space48\OrderReason\Model\ReasonFactory;

/**
 * Class AbstractAction
 * @package Space48\OrderReason\Controller
 */
abstract class AbstractAction extends \Magento\Framework\App\Action\Action
{


    /**
     * Authorization level of a company session.
     */
    public const COMPANY_RESOURCE = 'Space48_OrderReason::index';

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @var CompanyContext
     */
    public $companyContext;

    /**
     * @var CompanyUser
     */
    public $companyUser;
    /**
     * @var ForwardFactory
     */
    private $forwardFactory;
    /**
     * @var Validator
     */
    private $formValidator;
    /**
     * @var CompanyRepositoryInterface
     */
    public $companyRepository;

    /**
     * @var ReasonFactory
     */
    public $reasonFactory;

    /**
     * AbstractAction constructor.
     *
     * @param Context                    $context
     * @param CompanyContext             $companyContext
     * @param CompanyUser                $companyUser
     * @param ForwardFactory             $forwardFactory
     * @param LoggerInterface            $logger
     * @param CompanyRepositoryInterface $companyRepository
     * @param Validator                  $formValidator
     */
    public function __construct(
        Context $context,
        CompanyContext $companyContext,
        CompanyUser $companyUser,
        ForwardFactory $forwardFactory,
        LoggerInterface $logger,
        Validator $formValidator,
        CompanyRepositoryInterface $companyRepository,
        ReasonFactory $reasonFactory
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->companyContext = $companyContext;
        $this->companyUser = $companyUser;
        $this->forwardFactory = $forwardFactory;
        $this->formValidator = $formValidator;
        $this->companyRepository = $companyRepository;
        $this->reasonFactory = $reasonFactory;
    }

    /**
     * Authenticate customer.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws NotFoundException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->companyContext->isModuleActive()) {
            throw new NotFoundException(__('Page not found.'));
        }

        if (!$this->companyContext->isCustomerLoggedIn()) {
            $this->_actionFlag->set('', 'no-dispatch', true);
            return $this->_redirect('customer/account/login');
        }

        if (!$this->isAllowed()) {
            $this->_actionFlag->set('', 'no-dispatch', true);

            if ($this->companyContext->isCurrentUserCompanyUser()) {
                return $this->_redirect('company/accessdenied');
            }

            return $this->_redirect('noroute');
        }

        return parent::dispatch($request);
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return $this->companyContext->isResourceAllowed(static::COMPANY_RESOURCE);
    }

    /**
     * @return Forward
     */
    public function getForwardResult()
    {
        return $this->forwardFactory->create();
    }

    /**
     * @return Validator
     */
    public function getFormValidator()
    {
        return $this->formValidator;
    }
}
