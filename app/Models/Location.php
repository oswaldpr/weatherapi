<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /** @var int $id */
    public $id;

    /** @var float $lat */
    public $lat;

    /** @var float $lon */
    public $lon;

    /** @var string $city */
    public $city;

    /** @var string $state */
    public $state;

    public function create($id, $lat, $lon, $city, $state)
    {
        $obj = new \stdClass();
        $obj->id = $id;
        $obj->lat = $lat;
        $obj->lon = $lon;
        $obj->city = $city;
        $obj->state = $state;

        return $obj;
    }

    public function createFromArray($locationArray)
    {
        $obj = new \stdClass();
        $obj->id = $locationArray[0];
        $obj->lat = $locationArray[1];
        $obj->lon = $locationArray[2];
        $obj->city = $locationArray[3];
        $obj->state = $locationArray[4];

        return $obj;
    }

}
