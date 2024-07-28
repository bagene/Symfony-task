<?php

declare(strict_types=1);

namespace App\Tests;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IntegrationTestCase extends KernelTestCase
{
    use PHPMatcherAssertions;

    protected function setUp(): void
    {
        self::bootKernel();
        exec('bin/console doctrine:database:drop --force --env=test');
        exec('bin/console doctrine:database:create --env=test');
        exec('bin/console doctrine:migrations:migrate --no-interaction --env=test');
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn() => null);

            restore_exception_handler();

            if ($previousHandler === null) {
                break;
            }

            restore_exception_handler();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }
}
