<?php


namespace Esaticsas\Interservice\Test\Unit\Observer;


class Pay extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \Esaticsas\Interservice\Observer\Sales\Pay
     */
    private $pay;

    public function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->pay = $objectManager->getObject(\Esaticsas\Interservice\Observer\Sales\Pay::class);

    }

    public function testExecute()
    {
    }

}
