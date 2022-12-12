<?php


namespace Esaticsas\Interservice\Model\ResourceModel\Collection;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Esaticsas\Interservice\Model\Packaging::class, \Esaticsas\Interservice\Model\ResourceModel\Packaging::class);
    }
}
