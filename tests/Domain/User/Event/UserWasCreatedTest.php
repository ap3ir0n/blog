<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Tests\Domain\User\Event;

use App\Domain\User\ValueObject\Credentials;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\HashedPassword;
use App\Domain\User\Event\UserWasCreated;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserWasCreatedTest extends TestCase
{

    /**
     * @test
     * @group unit
     */
    public function serialize()
    {
        $event = new UserWasCreated(
            Uuid::fromString('91e576bf-483b-4b14-8fa0-61a2731edfff'),
            new Credentials(
                Email::fromString('test@test.com'),
                HashedPassword::fromHash('$2a$12$eeJCuDeKrQD9Z4ltZRMTe.bp9sDlj/V14vbGfYD5mm88F/nhYJUPi')
            )
        );

        $data = $event->serialize();

        self::assertArrayHasKey('uuid', $data);
        self::assertArrayHasKey('credentials', $data);
        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $data['uuid']);
        self::assertEquals([
            'email' => 'test@test.com',
            'password' => '$2a$12$eeJCuDeKrQD9Z4ltZRMTe.bp9sDlj/V14vbGfYD5mm88F/nhYJUPi'
        ], $data['credentials']);
    }

    /**
     * @test
     */
    public function deserialize()
    {
        $event = UserWasCreated::deserialize([
            'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
            'credentials' => [
                'email' => 'test@test.com',
                'password' => '$2a$12$eeJCuDeKrQD9Z4ltZRMTe.bp9sDlj/V14vbGfYD5mm88F/nhYJUPi'
            ]
        ]);

        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $event->uuid());
        self::assertEquals('test@test.com', $event->credentials()->email());
        self::assertEquals(
            '$2a$12$eeJCuDeKrQD9Z4ltZRMTe.bp9sDlj/V14vbGfYD5mm88F/nhYJUPi',
            $event->credentials()->password()
        );
    }

    /**
     * @test
     * @group unit
     * @dataProvider deserializationDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function deserializingWrongDataShouldThrowAnException($data) {
        UserWasCreated::deserialize($data);
    }

    public function deserializationDataProvider()
    {
        return [
            [
                [
                    'credentials' => [
                        'email' => 'test@test.com',
                        'password' => '$2a$12$eeJCuDeKrQD9Z4ltZRMTe.bp9sDlj/V14vbGfYD5mm88F/nhYJUPi'
                    ]
                ]
            ],
            [
                [
                    'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
                ]
            ],
            [
                [
                    'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
                    'credentials' => [
                        'password' => '$2a$12$eeJCuDeKrQD9Z4ltZRMTe.bp9sDlj/V14vbGfYD5mm88F/nhYJUPi'
                    ]
                ]
            ],
            [
                [
                    'uuid' => '91e576bf-483b-4b14-8fa0-61a2731edfff',
                    'credentials' => [
                        'email' => 'test@test.com',
                    ]
                ]
            ]
        ];
    }
}
