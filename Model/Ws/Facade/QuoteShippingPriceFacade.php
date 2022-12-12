<?php

namespace Esaticsas\Interservice\Model\Ws\Facade;

use Esaticsas\Interservice\Model\Ws\CotizarServicio;
use Esaticsas\Interservice\Model\Ws\Entities\QuoteResponse;
use Esaticsas\Interservice\Model\Ws\SrvClientes;
use Magento\Quote\Model\Quote\Address\RateRequest;

class QuoteShippingPriceFacade
{

    /**
     * @var \Esaticsas\Interservice\Model\Ws\Dto\QuoteShippingPriceDto
     */
    private $quoteShippingPriceDto;
    /**
     * @var \Esaticsas\Interservice\Helper\Data
     */
    private $data;

    /**
     * QuoteShippingPriceFacade constructor.
     * @param \Esaticsas\Interservice\Model\Ws\Dto\QuoteShippingPriceDto $quoteShippingPriceDto
     * @param \Esaticsas\Interservice\Helper\Data $data
     */
    public function __construct(
        \Esaticsas\Interservice\Model\Ws\Dto\QuoteShippingPriceDto $quoteShippingPriceDto,
        \Esaticsas\Interservice\Helper\Data $data
    )
    {
        $this->quoteShippingPriceDto = $quoteShippingPriceDto;
        $this->data = $data;
    }

    /**
     * @param RateRequest $request
     * @return QuoteResponse|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function query(RateRequest $request): ?QuoteResponse
    {
        $quote = json_encode($this->quoteShippingPriceDto->execute($request));
        if (is_null($quote)) {
            return null;
        }
        $url = $this->data->getUrl($request->getStoreId());
        $srvClient = new SrvClientes(array(), $url);
        $quoteService = new CotizarServicio(
            $this->data->process($request->getStoreId()),
            $quote,
            $this->data->username($request->getStoreId()),
            $this->data->password($request->getStoreId())
        );
        $stringResult = $srvClient->CotizarServicio($quoteService)->getCotizarServicioResult();
        return QuoteResponse::createFromJsonResponse(json_decode($stringResult));
    }
}
