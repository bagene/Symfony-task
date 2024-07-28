<?php

declare(strict_types=1);

namespace App\Tests;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FunctionalTestCase extends WebTestCase
{
    use PHPMatcherAssertions;

    protected const GET_METHOD = 'GET';
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        exec('bin/console doctrine:database:drop --force --env=test');
        exec('bin/console doctrine:database:create --env=test');
        exec('bin/console doctrine:migrations:migrate --no-interaction --env=test');

        $this->client = self::createClient();
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

    /**
     * @return array<string, mixed>|array<array<string, mixed>>
     */
    protected function getJsonResponse(): array
    {
        /** @var string $response */
        $response = $this->client->getResponse()->getContent();

        return json_decode($response, true) ?? [];
    }
}
