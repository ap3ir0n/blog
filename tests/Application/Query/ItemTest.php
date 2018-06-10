<?php
declare(strict_types=1);

/**
 * Date: 10/06/2018
 */

namespace App\Tests\Application\Query;

use App\Application\Query\Item;
use Broadway\ReadModel\SerializableReadModel;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function creation()
    {
        $readModel = self::getMockBuilder(SerializableReadModel::class)->getMock();

        $readModel
            ->method('getId')
            ->willReturn('91e576bf-483b-4b14-8fa0-61a2731edfff');

        $readModel
            ->method('serialize')
            ->willReturn(['id' => '91e576bf-483b-4b14-8fa0-61a2731edfff']);

        $item = new Item($readModel);

        self::assertEquals('91e576bf-483b-4b14-8fa0-61a2731edfff', $item->id());
        self::assertEquals($readModel, $item->readModel());
        self::assertEquals(
            [ 'id' => '91e576bf-483b-4b14-8fa0-61a2731edfff' ],
            $item->resource()
        );
        self::assertEquals(get_class($readModel), $item->type());
    }
}
