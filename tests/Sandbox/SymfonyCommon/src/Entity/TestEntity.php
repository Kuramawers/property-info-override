<?php

declare(strict_types=1);

namespace App\Entity;

use Amacode\PropertyInfoOverride\Annotation\PropertyType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpKernel\Kernel;

if (PHP_MAJOR_VERSION < 8 || Kernel::MAJOR_VERSION < 5) {
    /**
     * @ORM\Entity()
     */
    final class TestEntity
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        private int $id;

        /**
         * @ORM\Column(type="bigint")
         */
        private int $bigIntAsString;

        /**
         * @PropertyType(type="int")
         *
         * @ORM\Column(type="bigint")
         */
        private int $bigIntAsInt;

        /**
         * @PropertyType(type="int", nullable=false)
         *
         * @ORM\Column(type="integer", nullable=true)
         */
        private ?int $notRealNullable;

        /**
         * @PropertyType(type="int")
         *
         * @ORM\Column(type="integer", nullable=true)
         */
        private ?int $changeTypeButKeepNullable;
    }
} else {
    #[ORM\Entity]
    final class TestEntity
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private int $id;

        #[ORM\Column(type: 'bigint')]
        private int $bigIntAsString;

        #[PropertyType(type: 'int')]
        #[ORM\Column(type: 'bigint')]
        private int $bigIntAsInt;

        #[PropertyType(type: 'int', nullable: false)]
        #[ORM\Column(type: 'integer', nullable: true)]
        private ?int $notRealNullable;

        #[PropertyType(type: 'int')]
        #[ORM\Column(type: 'integer', nullable: true)]
        private ?int $changeTypeButKeepNullable;
    }
}
