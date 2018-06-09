<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Tests\Domain\User;

use App\Domain\User\Email;
use App\Domain\User\User;
use App\Domain\User\UserEmailChanged;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserEmailChangedTest extends TestCase
{

    /**
     * @test
     * @group unit
     */
    public function deserialize()
    {
        $event = UserEmailChanged::deserialize([
            'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
            'email' => 'test@test.com'
        ]);

        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $event->uuid());
        self::assertEquals('test@test.com', $event->email());
    }

    /**
     * @test
     * @group unit
     */
    public function serialize()
    {
        $event = new UserEmailChanged(
            Uuid::fromString('91e576bf-483b-4b14-8fa0-61a2731edfff'),
            Email::fromString('test@test.com')
        );

        $data = $event->serialize();

        self::assertArrayHasKey('uuid', $data);
        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $data['uuid']);
        self::assertArrayHasKey('email', $data);
        self::assertEquals('test@test.com', $data['email']);
    }

    /**
     * @test
     * @group unit
     * @dataProvider deserializationDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function deserializingWrongDataShouldThrowAnException($data) {
        $event = UserEmailChanged::deserialize($data);
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
