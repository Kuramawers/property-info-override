![Packagist Version](https://img.shields.io/packagist/v/amacode/property-info-override)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/Kuramawers/property-info-override/ci.yml)
![Codecov](https://img.shields.io/codecov/c/github/Kuramawers/property-info-override)
![GitHub](https://img.shields.io/github/license/Kuramawers/property-info-override)
### Overview
This package is an extension for [PropertyInfo](https://github.com/symfony/property-info) component.  
Sometimes the default `PropertyInfoExtractor` defines the property meta info not the way you want. It may break you API schema generation or requests validations (is actual for [ApiPlatform](https://api-platform.com/)).  
This package allows you to override a property type meta info which can be used by 3rd party libraries if it had been defined incorrectly (see usage example below).

### Installation
```bash
composer require amacode/property-info-override
```

### Usage
##### Add `PropertyType` annotation/attribute to property where type is defined incorrectly by PropertyInfoExtractor
```php
<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Amacode\PropertyInfoOverride\Annotation\PropertyType;

/**
 * @ORM\Entity()
 */
class TestEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * By default, bigint will be defined as string by DoctrineExtractor because it can be bigger than PHP_INT_MAX in 32-bit systems.
     * But if you're sure that your bigint will always be less than PHP_INT_MAX, you can override type manually.
     * 
     * @PropertyType(type="int")
     *
     * @ORM\Column(type="bigint")
     */
    private $bigIntAsInt;
    
    /**
     * @ORM\Column(type="bigint")
     */
    private $bigIntAsString;
}
```

#### Client code
```php
<?php

class ClientCode
{
    private PropertyInfoExtractorInterface $propertyInfoExtractor;

    public function __construct(PropertyInfoExtractorInterface $propertyInfoExtractor)
    {
        $this->propertyInfoExtractor = $propertyInfoExtractor;
    }
    
    public function action(): void
    {
        $types = $this->propertyInfoExtractor->getTypes(TestEntity::class, 'bigIntAsInt');
        
        echo $types[0]->getBuiltinType(); // int
        
        $types = $this->propertyInfoExtractor->getTypes(TestEntity::class, 'bigIntAsString');
        
        echo $types[0]->getBuiltinType(); // string
    }
}
```
