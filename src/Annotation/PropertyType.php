<?php

declare(strict_types=1);

namespace Amacode\PropertyInfoOverride\Annotation;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Symfony\Component\PropertyInfo\Type;

/**
 * @Annotation
 * @NamedArgumentConstructor()
 * @Target({"PROPERTY"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class PropertyType
{
    public string $type;

    public bool $nullable;

    public ?string $class;

    public bool $collection;

    public ?Type $collectionKeyType;

    public ?Type $collectionValueType;

    public function __construct(
        string $type,
        bool $nullable = false,
        ?string $class = null,
        bool $collection = false,
        ?Type $collectionKeyType = null,
        ?Type $collectionValueType = null
    ) {
        $this->type = $type;
        $this->nullable = $nullable;
        $this->class = $class;
        $this->collection = $collection;
        $this->collectionKeyType = $collectionKeyType;
        $this->collectionValueType = $collectionValueType;
    }
}
