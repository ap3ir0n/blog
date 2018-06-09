<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Tests\Domain\User;

use App\Domain\User\Email;
use App\Domain\User\UserSignedIn;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserSignedInTest extends TestCase
{

    /**
     * @test
     * @group unit
     */
    public function deserialize()
    {
        $event = UserSignedIn::deserialize([
            'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
            'email' => 'test@test.com'
        ]);

        self::assertEquals('test@test.com', $event->email());
        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $event->uuid());
    }

    /**
     * @test
     * @group unit
     */
    public function serialize()
    {
        $event = new UserSignedIn(
            Uuid::fromString('91e576bf-483b-4b14-8fa0-61a2731edfff'),
            Email::fromString('test@test.com')
        );

        $data = $event->serialize();

        self::assertArrayHasKey('uuid', $data);
        self::assertArrayHasKey('email', $data);
        self::assertEquals('test@test.com', $data['email']);
        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $data['uuid']);
    }

    /**
     * @test
     * @group unit
     * @dataProvider deserializationDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function deserializingWrongDataShouldThrowAnException($data) {
        $event = UserSignedIn::deserialize($data);
    }

    public function deserializationDataProvider()
    {
        return [
            [
                [
                    'email' => 'test@test.com'
                ]
            ],
            [
                [
                    'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
                ]
            ],
            [
                []
            ]
        ];
    }
}
