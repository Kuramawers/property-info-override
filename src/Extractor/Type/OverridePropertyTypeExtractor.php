<?php

declare(strict_types=1);

namespace Amacode\PropertyInfoOverride\Extractor\Type;

use Amacode\PropertyInfoOverride\Annotation\PropertyType;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

final class OverridePropertyTypeExtractor implements PropertyTypeExtractorInterface
{
    private const CONTEXT_CALLEE = '_callee';

    private Reader $annotationReader;

    private PropertyTypeExtractorInterface $propertyTypeExtractor;

    public function __construct(Reader $annotationReader, PropertyTypeExtractorInterface $propertyTypeExtractor)
    {
        $this->annotationReader = $annotationReader;
        $this->propertyTypeExtractor = $propertyTypeExtractor;
    }

    /**
     * @inheritDoc
     */
    public function getTypes($class, $property, array $context = []): ?array
    {
        if (($context[self::CONTEXT_CALLEE] ?? null) === self::class) {
            return null;
        }

        return $this->resolveTypes($class, $property);
    }

    private function resolveTypes(string $class, string $property): ?array
    {
        try {
            $typeAnnotations = $this->getTypeAnnotations($class, $property);
            $typeAnnotations = \array_map($this->createDefaultTypeDataFiller($class, $property), $typeAnnotations);

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

    private function createDefaultTypeDataFiller(string $class, string $property): callable
    {
        $types = $this->propertyTypeExtractor->getTypes($class, $property, [self::CONTEXT_CALLEE => self::class]);

        return static function (PropertyType $type) use ($types): PropertyType {
            $newType = clone $type;
            $newType->nullable = $newType->nullable ?? isset($types[0]) && $types[0]->isNullable();

            return $newType;
        };
    }
}
