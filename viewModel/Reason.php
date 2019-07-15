<?php

namespace Space48\OrderReason\viewModel;

use Space48\OrderReason\Model\ResourceModel\Attribute\Source\Reason as ReasonResource;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Reason
 * @package Space48\OrderReason\viewModel
 */
class Reason implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $reason;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var ReasonResource
     */
    private $reasonResource;

    /**
     * @var array
     */
    private $reasons;

    /**
     * Role constructor.
     * @param RequestInterface $request
     * @param UrlInterface     $urlBuilder
     * @param ReasonResource  $reasonResource
     */
    public function __construct(
        RequestInterface $request,
        UrlInterface $urlBuilder,
        ReasonResource $reasonResource
    ) {
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->reasonResource = $reasonResource;
    }

    /**
     * Init Reason
     */
    private function initReason()
    {
        $this->reason = ['id' => '', 'reason' => ''];

        $id = $this->request->getParam('id') ?: '';
        if ($id) {
            foreach ($this->getReasons() as $item) {
                if ($id === $item['value']) {
                    $this->reason['id'] = $item['value'];
                    $this->reason['reason'] = $item['label'];
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getReason()
    {
        if ($this->reason === null) {
            $this->initReason();
        }
        return $this->reason['reason'];
    }

    /**
     * @return string
     */
    public function getId()
    {
        if ($this->reason === null) {
            $this->initReason();
        }
        return $this->reason['id'];
    }

    /**
     * @return array
     */
    public function getReasons()
    {
        if (!$this->reasons) {
            $this->reasons = $this->reasonResource->getAllOptions();
        }
        return $this->reasons;
    }
}
