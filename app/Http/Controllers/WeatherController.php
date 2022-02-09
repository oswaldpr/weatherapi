<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Weather2;
use App\Models\WeatherServiceOutput;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WeatherController extends Controller
{
    /**
     * Display the homepage.
     */
    public function renderHomePage()
    {
        return view('weather_dashboard', ['resultList' => []]);
    }

    /**
     * Display the homepage.
     */
    public function weather(Request $request)
    {
        $weatherResult = self::getWeatherRequestList($request);

        return view('weather_dashboard', ['resultList' => $weatherResult]);
    }

    public function getWeatherRequestList(Request $request)
    {
        $parameters = WeatherQueryController::getSanitizedRequest($request);
        $startDateTZ = explode('T', $parameters->startDate);
        $endDateTZ = explode('T', $parameters->endDate);

        $lowTempRequest = $parameters->startTemperature;
        $highTempRequest = $parameters->endTemperature;
        $lat = $parameters->lat;
        $lon = $parameters->lon;
        $city = $parameters->city;
        $state = $parameters->state;
        $startDate = $startDateTZ[0];
        $endDate = $endDateTZ[0];

        $weatherQueryResult = Weather2::all()
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate);

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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * service to get the weather
     **/
    public function getWeather(Request $request)
    {
        $serviceData = json_decode($request->serviceData);
        $startDate = $serviceData->startDate;
        $endDate = $serviceData->endDate;
        $city = $serviceData->city;
        $state = $serviceData->state;
        $startTemperature = $serviceData->startTemperature;
        $endTemperature = $serviceData->endTemperature;

        $weather = Weather2::all();
        $weather = Weather2::where();


        echo(json_encode(
            array(
                'result' => $serviceData,
                'errorList' => [],
            )
        ));
        die;
    }

    /**
     * service to get the weather
     **/
    public function getRequestList(Request $request)
    {
//        $onlyGetID = false;
        // Time is up, the idea here is to check parameter and only fetch the locationID and build the hole object at the end
        $parameters = WeatherQueryController::getSanitizedRequest($request);
        $startDateTZ = explode('T', $parameters->startDate);
        $endDateTZ = explode('T', $parameters->endDate);
        $lat = $parameters->lat;
        $lon = $parameters->lon;
        $city = $parameters->city;
        $state = $parameters->state;
        $startDate = $startDateTZ[0];
        $endDate = $endDateTZ[0];


        $weatherQueryResult = Weather2::all()
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->all();

        $weatherResult = array();
        foreach ($weatherQueryResult as $item) {
            $weatherResult[] = $item->getAttributes();
        }

        $locationQueryResult = Location::all()->all();
        $locationResult = array();
        foreach ($locationQueryResult as $item) {
            $locationResult[] = $item->getAttributes();
        }


        $queryWeather = WeatherQueryController::buildWeatherQuery($request);
        $queryLoc = WeatherQueryController::buildLocationQuery($request);

//        $lAll = Location::all()
//            ->where('lat','=', $lat ?: $lAllll)
//            ->where('lon','=', $lon ?: 'lon')
//            ->where('city','=', $city ?: 'city')
//            ->where('state','=', $state ?: 'state')
//            ->all();
//
//        $requestQueryWeather = WeatherQueryController::executeQuery($queryWeather);
//        $requestQueryLoc = WeatherQueryController::executeQuery($queryLoc);

        echo(json_encode(array(
            'weather' => $weatherResult,
            'location' => $locationResult,
        )

        ));
        die;
    }
}
