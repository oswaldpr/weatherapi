<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather2 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'date',
        'location',
        'temperature'
    ];

    /** @var  float $highTemp */
    public $highTemp;

    /** @var  float $lowTemp */
    public $lowTemp;

    public function populateObj()
    {
        $this->fillTemperatureFields();
    }

    public function resultArray($resultArray = array())
    {
        $weatherResult = array();
        foreach ($resultArray as $item) {
            $weatherResult[] = $item->getAttributes();
        }
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function getResultWithTemperatureFields()
    {
        $tempArray = json_decode($this->temperature);
        $medTem = array_sum($tempArray) / count($tempArray);
        $this->highTemp = current($tempArray);
        $this->lowTemp = end($tempArray);
        $this->temperature = round($medTem, 2);

        return $this;
    }
}
