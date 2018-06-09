<?php
/**
 * Created by PhpStorm.
 * User: patri
 * Date: 09/06/2018
 * Time: 17:11
 */

namespace App\Tests\Domain\User;

use App\Domain\User\HashedPassword;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HashedPasswordTest extends TestCase
{
    /**
     * @test
     * @group unit
     * @expectedException InvalidArgumentException
     */
    public function passwordMustHaveAtLeast6Characters()
    {
        HashedPassword::encode('12345');
    }

    /**
     * @test
     * @group unit
     */
    public function encodedPasswordShouldBeValidated()
    {
        $password = HashedPassword::encode('verysecretpassword');

        self::assertTrue($password->match('verysecretpassword'));
    }

    /**
     * @test
     * @group unit
     */
    public function itShouldBePossibleToInitializeWithAHash()
    {
        $hash = HashedPassword::encode('this_is_apassword')->toString();
        $password = HashedPassword::fromHash($hash);

        self::assertTrue($password->match('this_is_apassword'));
    }
}
