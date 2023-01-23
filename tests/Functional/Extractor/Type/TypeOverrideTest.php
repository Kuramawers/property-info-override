<?php

declare(strict_types=1);

namespace Amacode\PropertyInfoOverride\Tests\Functional\Extractor\Type;

use App\Entity\TestEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class TypeOverrideTest extends WebTestCase
{
    /**
     * @dataProvider propertiesDataProvider
     * @throws \JsonException
     */
    public function testTypesOverriddenSuccessfully(string $className, string $propertyName, array $expectedTypes): void
    {
        $client = self::createClient();

        $client->request('GET', '/tests/types', [
            'className' => $className,
            'propertyName' => $propertyName,
        ]);

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        self::assertSame($client->getResponse()->getContent(), \json_encode($expectedTypes, JSON_THROW_ON_ERROR));
    }

    public function propertiesDataProvider(): iterable
    {
        yield 'bigIntAsString' => [
            'className' => TestEntity::class,
            'propertyName' => 'bigIntAsString',
            'expectedTypes' => [
                [
                    'builtinType' => 'string',
                    'isNullable' => false,
                    'className' => null,
                ],
            ],
        ];

        yield 'bigIntAsInt' => [
            'className' => TestEntity::class,
            'propertyName' => 'bigIntAsInt',
            'expectedTypes' => [
                [
                    'builtinType' => 'int',
                    'isNullable' => false,
                    'className' => null,
                ],
            ],
        ];

        yield 'notRealNullable' => [
            'className' => TestEntity::class,
            'propertyName' => 'notRealNullable',
            'expectedTypes' => [
                [
                    'builtinType' => 'int',
                    'isNullable' => false,
                    'className' => null,
                ],
            ],
        ];

        yield 'changeTypeButKeepNullable' => [
            'className' => TestEntity::class,
            'propertyName' => 'changeTypeButKeepNullable',
            'expectedTypes' => [
                [
                    'builtinType' => 'int',
                    'isNullable' => true,
                    'className' => null,
                ],
            ],
        ];
    }

    public function testFailedForNonExistingProperty(): void
    {
        $client = self::createClient();

        $client->request('GET', '/tests/types', [
            'className' => TestEntity::class,
            'propertyName' => 'non_existing',
        ]);

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        self::assertSame($client->getResponse()->getContent(), '[]');
    }
}
