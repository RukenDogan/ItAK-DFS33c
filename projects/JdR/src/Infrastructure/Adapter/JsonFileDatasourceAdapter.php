<?php

namespace Infrastructure\Adapter;

use Lib\File\File;
use Lib\Persistence\Datasource;

class JsonFileDatasourceAdapter implements Datasource
{
    public function __construct(
        private File $jsonFile
    ) {
        if (strcasecmp($this->jsonFile->extension, 'json') !== 0) {
            throw new \InvalidArgumentException('Given file is not a json file.');
        }
    }

    public function loadAll(): \Iterator
    {
        $jsonData = $this->jsonFile->getContents();
        if (!json_validate($jsonData)) {
            throw new \UnexpectedValueException(json_last_error_msg());
        }

        $data = json_decode(
            json: $jsonData,
            associative: true
        );

        if (array_is_list($data)) {
            yield from $data;     // lance chaque ligne une par une dans le générateur

            return;
        }

        yield $data;
    }
}
