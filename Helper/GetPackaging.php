<?php

namespace Esaticsas\Interservice\Helper;

class GetPackaging
{

    /**
     * @var Data
     */
    private $data;
    /**
     * @var \Esaticsas\Interservice\Model\PackagingFactory
     */
    private $packagingFactory;
    /**
     * @var \Esaticsas\Interservice\Model\ResourceModel\PackagingFactory
     */
    private $resourceModelFactory;

    /**
     * GetPackaging constructor.
     * @param Data $data
     * @param \Esaticsas\Interservice\Model\PackagingFactory $packagingFactory
     * @param \Esaticsas\Interservice\Model\ResourceModel\PackagingFactory $resourceModelFactory
     */
    public function __construct(
        Data $data,
        \Esaticsas\Interservice\Model\PackagingFactory $packagingFactory,
        \Esaticsas\Interservice\Model\ResourceModel\PackagingFactory $resourceModelFactory
    ) {
        $this->data = $data;
        $this->packagingFactory = $packagingFactory;
        $this->resourceModelFactory = $resourceModelFactory;
    }

    public function execute($storeId = null)
    {
        $packaging = $this->packagingFactory->create();
        $resourceModel = $this->resourceModelFactory->create();
        $resourceModel->load($packaging, $this->data->packaging($storeId));
        return $packaging->getName();
    }
}
