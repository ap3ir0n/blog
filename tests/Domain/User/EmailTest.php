<?php
/**
 * Created by PhpStorm.
 * User: patri
 * Date: 09/06/2018
 * Time: 17:32
 */

namespace App\Tests\Domain\User;

use App\Domain\User\Email;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function itShouldBePossibleToInitFromValidEmail()
    {
        $email = Email::fromString('test@test.com');

        self::assertEquals('test@test.com', $email->toString());
        self::assertEquals('test@test.com', (string) $email);
    }

    /**
     * @test
     * @dataProvider emailProvider
     * @expectedException \InvalidArgumentException
     */
    public function invalidEmailShouldThrowAnException($email)
    {
        Email::fromString($email);
    }

    public function emailProvider()
    {
        return [
            ['ciao'],
            ['ciao@ciao'],
            ['@ciao.it'],
            ['@'],
            ['DROP TABLE users']
        ];
    }
}
