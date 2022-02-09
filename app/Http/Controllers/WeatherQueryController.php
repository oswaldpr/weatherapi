<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use mysqli;

class WeatherQueryController extends Controller
{
    const SUCCESS_MESSAGE = "New record created successfully";

    public static function sanitizeFieldValue($value = "")
    {
        return $value ? filter_var($value, FILTER_SANITIZE_STRING) : $value;
    }

    public static function getSanitizedRequest(Request $request)
    {
        $serviceData = json_decode($request->serviceData);
        $result = new \stdClass();
        $result->startDate = self::sanitizeFieldValue($serviceData->startDate ?? '');
        $result->endDate = self::sanitizeFieldValue($serviceData->endDate ?? '');
        $result->lat = self::sanitizeFieldValue($serviceData->lat ?? '');
        $result->lon = self::sanitizeFieldValue($serviceData->lon ?? '');
        $result->city = self::sanitizeFieldValue($serviceData->city ?? '');
        $result->state = self::sanitizeFieldValue($serviceData->state ?? '');
        $result->startTemperature = self::sanitizeFieldValue($serviceData->startTemperature ?? '');
        $result->endTemperature = self::sanitizeFieldValue($serviceData->endTemperature ?? '');

        return $result;
    }

    public static function buildLocationQuery(Request $request, $locationID = null){
        $parameters = self::getSanitizedRequest($request);
        $lat = $parameters->lat;
        $lon = $parameters->lon;
        $city = $parameters->city;
        $state = $parameters->state;

        $latQuery = $lat ? "lat = '" . $lat . "'" : '';
        $lonQuery = $lon ? "lon = '" . $lon . "'" : '';
        $cityQuery = $city ? "city = '" . $city . "'" : '';
        $stateQuery = $state ? "state = '" . $state . "'" : '';

        $idQuery = $locationID ? "location = '" . $locationID . "'" : "";
        $whereQuery = $idQuery === '' ? '' : $idQuery;
        if($lat || $lon || $city || $state){
            $locQueryArray = [$latQuery, $lonQuery, $cityQuery, $stateQuery];
            foreach ($locQueryArray as $query) {
                $whereQuery = $whereQuery === '' ? $query : " AND " . $query;
            }
        }

        return "SELECT * FROM locations" . ( $whereQuery ? " WHERE " . $whereQuery : "") . ";";
    }

    public static function buildWeatherQuery(Request $request, $onlyGetID = false){
        $parameters = self::getSanitizedRequest($request);
        $startDate = explode('T', $parameters->startDate);
        $endDate = explode('T', $parameters->endDate);
        $realStartDate = $startDate[0];
        $realEndDate = $endDate[0];

        $startTemperature = $parameters->startTemperature;
        $endTemperature = $parameters->endTemperature;

        $endStr = $realEndDate ? " AND date <= '" . $realEndDate . "'"  : "";
        $dateRangeQuery = "WHERE date >= '" . $realStartDate . "'" . $endStr;

        // Search only with date filter and then treat temperature fields from the result
        $selector = $onlyGetID ? 'location' : '*'; //Should be locationID instead of location but that what i previously build the db
        return "SELECT " . $selector . " FROM weather2s " . $dateRangeQuery . ";";
    }

    private static function connectDatabase(){
        $servername = env('DB_HOST');
        $dbname = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public static function executeQuery($sql){
        $conn = self::connectDatabase();
        $result = $conn->query($sql);
        return $result->fetch_all();
    }
}
