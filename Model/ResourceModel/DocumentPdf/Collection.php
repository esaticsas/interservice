<?php


namespace Esaticsas\Interservice\Model\ResourceModel\DocumentPdf;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init(\Esaticsas\Interservice\Model\DocumentPdf::class, \Esaticsas\Interservice\Model\ResourceModel\DocumentPdf::class);
    }

}
