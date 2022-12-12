# Interservice/ Interservicios

- Shipping method for Interservice / Interservicios

# Requirements:

- Magento 2.x
- php 7.3, 7.4
- Composer

# Instalation

```shell
composer require esaticsas/interservice
``` 

# Enable Module

```shell
bin/magento module:enable Eadesigndev_Eacore
bin/magento module:enable Eadesigndev_RomCity
bin/magento module:enable Esaticsas_DropdownCity
bin/magento module:enable Esaticsas_Interservice
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:clean
bin/magento cache:flush
```

# Configuration:

- To install the extension, use the composer, then go to Admin → Store → Configuration → Sales → Shipping Methods →
  Interservice / Interservicios

# For use your Custom module dropdown cities

- Override GetCityCodes

```php
<?php

namespace YourVendor\YourModule\Model;


class GetCityCode implements \Esaticsas\Interservice\Model\GetCityCodeInterface{


    /**
     * Get city code for use in shipping method
     * @param string $regionId
     * @param string $city the city name for search
     * @return string|null
     * @throws \Exception if the city has not been found
     */
    public function execute(string $regionId, string $city): ?string{
        //Here return your city code
        return '1234567';
    }
    

}
```

- Add implementation in etc/di.xml

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <preference for="Esaticsas\Interservice\Model\GetCityCodeInterface"
                type="YourVendor\YourModule\Model\GetCityCode"/>
</config>
```

- Finally

```shell
bin/magento setup:di:compile
```
