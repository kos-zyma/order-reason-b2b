<?php

namespace Space48\OrderReason\Controller\Reason;

use Space48\OrderReason\Controller\AbstractAction;
use Space48\OrderReason\Model\ReasonFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class EditPost
 * @package Space48\OrderReason\Controller\Reason
 */
class EditPost extends AbstractAction
{
    /**
     * @return ResultInterface|ResponseInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();
        $resultRedirect = $this->resultRedirectFactory->create()->setPath('reasons');
        $companyId = $this->companyUser->getCurrentCompanyId();

        if ($request->isPost() && !$this->getFormValidator()->validate($request)) {
            return $resultRedirect;
        }
        /** @var \Space48\OrderReason\Model\Reason $reasonModel */
        $reasonModel = $this->reasonFactory->create();

        try {
            $postData = $request->getParams();
            if (!$postData['reason_id']) {
                $reasonModel->setCompanyId($companyId);
                $reasonModel->setReason($postData['reason']);
                $reasonModel->save();

                $this->messageManager->addSuccessMessage(
                    __('The order reason has been successfully saved.')
                );
            } else {
                $reasonModel->load($postData['reason_id']);
                $reasonModel->setReason($postData['reason']);
                $reasonModel->save();

                $this->messageManager->addSuccessMessage(
                    __('The changes you made on the order reason have been successfully saved.')
                );
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred when trying to save the order reason.'));
            $this->logger->critical($e);
        }
        return $resultRedirect;
    }
}
