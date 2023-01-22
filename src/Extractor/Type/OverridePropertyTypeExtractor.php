<?php

declare(strict_types=1);

namespace Amacode\PropertyInfoOverride\Extractor\Type;

use Amacode\PropertyInfoOverride\Annotation\PropertyType;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

final class OverridePropertyTypeExtractor implements PropertyTypeExtractorInterface
{
    private Reader $annotationReader;

    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritDoc
     */
    public function getTypes($class, $property, array $context = []): ?array
    {
        try {
            $typeAnnotations = $this->getTypeAnnotations($class, $property);

            return !empty($typeAnnotations) ? \array_map([$this, 'createTypeFromAnnotation'], $typeAnnotations) : null;
        } catch (\ReflectionException $e) {
            return null;
        }
    }

    /**
     * @throws \ReflectionException
     * @return PropertyType[]
     */
    private function getTypeAnnotations(string $class, string $property): array
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);

        $annotations = $this->annotationReader->getPropertyAnnotations($reflectionProperty);

        return \array_values(\array_filter($annotations, [$this, 'isTypeAnnotation']));
    }

    private function isTypeAnnotation(object $annotation): bool
    {
        return $annotation instanceof PropertyType;
    }

    private function createTypeFromAnnotation(PropertyType $annotation): Type
    {
        return new Type(
            $annotation->type,
            $annotation->nullable,
            $annotation->class,
            $annotation->collection,
            $annotation->collectionKeyType,
            $annotation->collectionValueType
        );
    }
}
