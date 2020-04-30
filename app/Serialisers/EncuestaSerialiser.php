<?php
namespace App\Serialisers;

use Illuminate\Database\Eloquent\Model;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;

class EncuestaSerialiser implements SerialiserInterface
{
    private $headerRow = [];

    public function __construct(Model $data)
    {
        $this->headerRow = array_keys($data->toArray());
    }

    public function getData(Model $data)
    {
        return $data->toArray();
    }

    public function getHeaderRow()
    {
        return $this->headerRow;
    }
}