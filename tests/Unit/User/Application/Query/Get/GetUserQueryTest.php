<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Application\Query\Get;

use App\Tests\UnitTestCase;
use App\User\Application\Query\Get\GetUserQuery;

final class GetUserQueryTest extends UnitTestCase
{
    public function testGetId(): void
    {
        $id = '1';
        $query = new GetUserQuery($id);
        $this->assertEquals($id, $query->getId());
    }
}
