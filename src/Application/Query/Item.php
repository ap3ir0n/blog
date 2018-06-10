<?php
declare(strict_types=1);

/**
 * Date: 10/06/2018
 */

namespace App\Application\Query;


use Broadway\ReadModel\SerializableReadModel;

final class Item
{
    /** @var string */
    private $id;

    /** @var string */
    private $type;

    /** @var array */
    private $resource;

    /** @var array */
    private $relationships = [];

    /** @var SerializableReadModel */
    private $readModel;

    public function __construct(SerializableReadModel $readModel, array $relationships = [])
    {
        $this->id = $readModel->getId();
        $this->type = get_class($readModel);
        $this->resource = $readModel->serialize();
        $this->relationships = $relationships;
        $this->readModel = $readModel;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function resource(): array
    {
        return $this->resource;
    }

    /**
     * @return array
     */
    public function relationships(): array
    {
        return $this->relationships;
    }

    /**
     * @return SerializableReadModel
     */
    public function readModel(): SerializableReadModel
    {
        return $this->readModel;
    }

}