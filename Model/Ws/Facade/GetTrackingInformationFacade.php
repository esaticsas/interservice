<?php


namespace Esaticsas\Interservice\Model\Ws\Facade;


use Esaticsas\Interservice\Helper\Data;
use Esaticsas\Interservice\Model\Ws\Entities\GetTrackingInformationResponse;
use Esaticsas\Interservice\Model\Ws\RastreoEnvios2;
use Esaticsas\Interservice\Model\Ws\SrvClientes;
use Magento\Sales\Model\Order;

class GetTrackingInformationFacade
{

    /**
     * @var Data
     */
    private $data;

    /**
     * GetTrackingInformationFacade constructor.
     * @param Data $data
     */
    public function __construct(Data $data)
    {
        $this->data = $data;
    }


    public function execute($shippingId, Order $order)
    {
        $url = $this->data->getUrl($order->getStoreId());
        $srvClient = new SrvClientes(array(), $url);
        $trackingShipping2 = new RastreoEnvios2(
            $shippingId,
            $this->data->username($order->getStoreId()),
            $this->data->password($order->getStoreId())
        );
        $response = $srvClient->RastreoEnvios2($trackingShipping2)->getRastreoEnvios2Result();
        return GetTrackingInformationResponse::createFromJsonResponse(json_decode($response));
    }

}
