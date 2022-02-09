<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Weather2;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public static function getPreferredCity()
    {
        return 'Quebec'; //preferredCity definition
    }

    /**
     * Display the homepage.
     */
    public function renderHomePage()
    {
        return view('weather_dashboard', ['resultList' => []]);
    }

    private static function sanitizeFieldValue($value = "")
    {
        return $value ? filter_var($value, FILTER_SANITIZE_STRING) : $value;
    }

    public static function getSanitizedRequest(Request $request)
    {
        $today = date("Y-m-d");
        $maxDate = date("Y-m-d", strtotime("+1 Year"));

        $serviceData = $request->serviceData ? json_decode($request->serviceData) : $request;
        $result = new \stdClass();
        $result->startDate = self::sanitizeFieldValue($serviceData->startDate ?? $today);
        $result->endDate = self::sanitizeFieldValue($serviceData->endDate ?? $maxDate);
        $result->lat = self::sanitizeFieldValue($serviceData->lat ?? '');
        $result->lon = self::sanitizeFieldValue($serviceData->lon ?? '');
        $result->city = self::sanitizeFieldValue($serviceData->city ?? '');
        $result->state = self::sanitizeFieldValue($serviceData->state ?? '');
        $result->startTemperature = self::sanitizeFieldValue($serviceData->startTemperature ?? '');
        $result->endTemperature = self::sanitizeFieldValue($serviceData->endTemperature ?? '');

        return $result;
    }

    public function weather(Request $request)
    {
        $weatherResult = self::getWeatherRequestList($request);

        return view('weather_dashboard', ['resultList' => $weatherResult]);
    }

    public function getAllWeatherRecord(Request $request)
    {
        $parameters = self::getSanitizedRequest($request);
        $startDateTZ = explode('T', $parameters->startDate);
        $endDateTZ = explode('T', $parameters->endDate);
        $startDate = $startDateTZ[0];
        $endDate = $endDateTZ[0];

        $weatherQueryResult = Weather2::all()
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate);

        return self::populateWeatherRecordList($weatherQueryResult);
    }

    public function getAllLocationRecord(Request $request)
    {
        return Location::query()->get();
    }

    public function getWeatherRequestList(Request $request)
    {
        $parameters = self::getSanitizedRequest($request);
        $startDateTZ = explode('T', $parameters->startDate);
        $endDateTZ = explode('T', $parameters->endDate);
        $startDate = $startDateTZ[0];
        $endDate = $endDateTZ[0];

        $lowTempRequest = $parameters->startTemperature;
        $highTempRequest = $parameters->endTemperature;
        $lat = $parameters->lat;
        $lon = $parameters->lon;
        $city = $parameters->city;
        $state = $parameters->state;

        // This should check the value before fetch data or not but it seems not working here when you have missing parameter ( but it works on my local sql)
        $locationQueryResult = Location::query()
//            ->where('city', '=', $city)
//            ->where('lat', '=', $lat ?? '`lat`')
//            ->where('lon', '=', $lon ?? '`lon`')
//            ->where('state', '=', $state ?? '`state`')
            ->get();

        $locQueryArr = array();
        foreach ($locationQueryResult as $item) {
            $locQueryArr[] = $item->id;
        }

        $weatherQueryResult = Weather2::query()
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->whereIn('location', $locQueryArr)
            ->get();

        return self::populateWeatherRecordList($weatherQueryResult, $lowTempRequest, $highTempRequest);
    }

    private function getLocationResultIdList($locationQueryResult)
    {
        $list = array();
        foreach ($locationQueryResult as $item) {
            $list[] = $item->id;
        }

        return $list;
    }

    private function populateWeatherRecordList($weatherQueryResult = array(), $lowTempRequest = "", $highTempRequest = "")
    {
        $weatherResult = array();
        foreach ($weatherQueryResult as $item) {
            $currentItem = $item->getResultWithTemperatureFields();
            $matchLowTemp = !$lowTempRequest || $currentItem->lowTemp <= $lowTempRequest;
            $matchHighTemp = !$highTempRequest || $currentItem->highTemp >= $highTempRequest;
            if($matchLowTemp && $matchHighTemp){
                $weatherResult[] = $currentItem;
            }
        }

        return $weatherResult;
    }

    public function eraseWeatherRecord(Request $request)
    {
        $hasKey = count($request->all()) > 0;
        if($hasKey){
            $isAll = false;
            $parameters = self::getSanitizedRequest($request);
            // use query to find request result then delete records by using ->delete()
        } else {
            $isAll = true;
            Weather2::query()->delete();
        }

        return view('deleted_weather', ['isAll' => $isAll]);
    }

    public function getWeatherByTemperature(Request $request)
    {
        $request->startTemperature = self::sanitizeFieldValue($request->start ?? 0);
        $request->endTemperature = self::sanitizeFieldValue($request->end ?? 100);
        return self::weather($request);
    }

    public function addWeatherRecord(Request $request)
    {
        $parameters = self::getSanitizedRequest($request);

        $id = Location::query()->create([
            'lat' => $parameters->lat,
            'lon' => $parameters->lon,
            'city' => $parameters->city,
            'state' => $parameters->state,
        ])->get('id');

        return Weather2::query()->create([
            'date' => $parameters->date,
            'location' => $id,
            'temperature' => $parameters->temperature,
            ])->get('id');
    }

    public function updateWeatherRecord(Request $request)
    {
        $weatherDate = self::sanitizeFieldValue($request->weatherDate);
        $weatherTemperature = self::sanitizeFieldValue($request->weathertTemperature);
        $parameters = self::getSanitizedRequest($request);

        $lat = $parameters->lat;
        $lon = $parameters->lon;
        $city = $parameters->city;
        $state = $parameters->state;

        if($lat || $lon || $city || $state){
            $array = array();
            if($lat){
                $array['lat'] = $lat;
            }
            if($lon){
                $array['lon'] = $lon;
            }
            if($city){
                $array['city'] = $city;
            }
            if($state){
                $array['state'] = $state;
            }
            $weatherResult = self::getAllLocationRecord($request);
            $weatherResult[0]->update($array);
        }

        if($weatherDate || $weatherTemperature){
            $array = array();
            if($weatherDate){
                $array['date'] = $weatherDate;
            }
            if($weatherTemperature){
                $array['temperature'] = $weatherTemperature;
            }
            $weatherResult = self::getWeatherRequestList($request);
            $weatherResult[0]->update($array);
        }

        return 'success';
    }
}
