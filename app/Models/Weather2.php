<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather2 extends Model
{
    use HasFactory;

    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'date',
        'location',
        'temperature'
    ];

    /** @var int $id */
    public $id;

    /** @var string $date */
    public $date;

    /** @var Location $location */
    public $location;

    /** @var array $temperature */
    public $temperature;

    public function create($id, $date, $location, $temperature)
    {
        $this->id = $id;
        $this->date = $date;
        $this->location = $location;
        $this->temperature = $temperature;

        return $this;
    }

    public function createFromArray($locationArray)
    {
        $obj = new \stdClass();
        $obj->id = $locationArray[0];
        $obj->date = $locationArray[1];
        $obj->location = $locationArray[2];
        $obj->temperature = $locationArray[3];

        return $obj;
    }
}
