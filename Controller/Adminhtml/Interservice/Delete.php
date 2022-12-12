<?php

namespace Esaticsas\Interservice\Controller\Adminhtml\Interservice;

use Magento\Framework\App\ResponseInterface;

class Delete extends \Magento\Backend\App\Action
{

    /**
     * @var \Esaticsas\Interservice\Model\ResourceModel\PackagingFactory
     */
    private $resourceModelFactory;
    /**
     * @var \Esaticsas\Interservice\Model\PackagingFactory
     */
    private $packagingFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Esaticsas\Interservice\Model\ResourceModel\PackagingFactory $resourceModelFactory,
        \Esaticsas\Interservice\Model\PackagingFactory $packagingFactory
    )
    {
        parent::__construct($context);
        $this->resourceModelFactory = $resourceModelFactory;
        $this->packagingFactory = $packagingFactory;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Exception
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        try {
            $resourceModel = $this->resourceModelFactory->create();
            $packaging = $this->packagingFactory->create();
            $resourceModel->load($packaging, $id);
            $resourceModel->delete($packaging);
            $this->messageManager->addSuccessMessage(__('Registro eliminado correctamente'));
        } catch (\Exception $ex) {
            $this->messageManager->addErrorMessage(__('Ha ocurrido un error eliminando el registro'));
        }
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/index', ['back' => null, '_current' => true]);
        return $resultRedirect;
    }
}
