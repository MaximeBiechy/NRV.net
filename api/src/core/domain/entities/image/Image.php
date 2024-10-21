<?php

namespace nrv\core\domain\entities\image;

use nrv\core\domain\entities\Entity;

class Image extends Entity implements \JsonSerializable
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

}