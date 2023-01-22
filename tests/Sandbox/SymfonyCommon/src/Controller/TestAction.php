<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tests/types")
 */
final class TestAction extends AbstractController
{
    private PropertyInfoExtractorInterface $propertyInfoExtractor;

    public function __construct(PropertyInfoExtractorInterface $propertyInfoExtractor)
    {
        $this->propertyInfoExtractor = $propertyInfoExtractor;
    }

    public function __invoke(Request $request): Response
    {
        $className = $request->get('className');
        $propertyName = $request->get('propertyName');

        $types = $this->propertyInfoExtractor->getTypes($className, $propertyName);

        return $this->json(\array_map([$this, 'convertTypeToArray'], $types));
    }

    private function convertTypeToArray(Type $type): array
    {
        return [
            'builtinType' => $type->getBuiltinType(),
            'isNullable' => $type->isNullable(),
            'className' => $type->getClassName(),
        ];
    }
}
