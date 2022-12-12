<?php

namespace Esaticsas\Interservice\Observer\Sales;

use Esaticsas\Interservice\Logger\Logger;
use Esaticsas\Interservice\Model\Carrier\Interservice;
use Esaticsas\Interservice\Model\Ws\Entities\TrackingInformationResponse;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Pay implements ObserverInterface
{

    /**
     * @var \Esaticsas\Interservice\Helper\Data
     */
    private $data;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var \Esaticsas\Interservice\Model\Ws\Facade\CreateTrackingInformationFacade
     */
    private $createTrackingInformationFacade;

    /**
     * Pay constructor.
     * @param \Esaticsas\Interservice\Helper\Data $data
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Logger $logger
     * @param \Esaticsas\Interservice\Model\Ws\Facade\CreateTrackingInformationFacade $createTrackingInformationFacade
     */
    public function __construct(
        \Esaticsas\Interservice\Helper\Data $data,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Esaticsas\Interservice\Logger\Logger $logger,
        \Esaticsas\Interservice\Model\Ws\Facade\CreateTrackingInformationFacade $createTrackingInformationFacade
    )
    {
        $this->data = $data;
        $this->_storeManager = $storeManager;
        $this->logger = $logger;
        $this->createTrackingInformationFacade = $createTrackingInformationFacade;
    }

    /**
     * @param Observer $observer
     * @return TrackingInformationResponse|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer): ?TrackingInformationResponse
    {
        if (!$this->data->autoCreation($this->_storeManager->getStore()->getId())) {
            return null;
        }
        /** @var \Magento\Sales\Model\Order\Invoice $invoice */
        $invoice = $observer->getData('invoice');
        $shippingMethod = $invoice->getOrder()->getShippingMethod(true);
        $carrierCode = $shippingMethod->getCarrierCode();
        $method = $shippingMethod->getMethod();
        if ($carrierCode != Interservice::CODE) {
            return null;
        }
        $this->logger->info('Creating guide ' . $invoice->getOrder()->getIncrementId());
        $response = $this->createTrackingInformationFacade->execute($invoice->getOrder(), $method);
        $this->logger->info('Guide created' . $invoice->getOrder()->getIncrementId());
        return $response;
    }
}
