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
        return view('weather_dashboard');
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

    public function getSanitizedRequest(Request $request)
    {
        $serviceData = json_decode($request->serviceData);
        $result = new \stdClass();
        $result->startDate = filter_var($serviceData->startDate, FILTER_SANITIZE_STRING);
        $result->endDate = filter_var($serviceData->endDate, FILTER_SANITIZE_STRING);
        $result->city = filter_var($serviceData->city, FILTER_SANITIZE_STRING);
        $result->state = filter_var($serviceData->state, FILTER_SANITIZE_STRING);
        $result->startTemperature = filter_var($serviceData->startTemperature, FILTER_SANITIZE_STRING);
        $result->endTemperature = filter_var($serviceData->endTemperature, FILTER_SANITIZE_STRING);

        return $result;
    }

    /**
     * service to get the weather
     **/
    public function getRequestList(Request $request)
    {
//        $onlyGetID = false;
        // Time is up, the idea here is to check parameter and only fetch the locationID and build the hole object at the end
        $queryWeather = WeatherQueryController::buildWeatherQuery($request);
        $queryLoc = WeatherQueryController::buildLocationQuery($request);

        $requestQueryWeather = WeatherQueryController::executeQuery($queryWeather);
        $requestQueryLoc = WeatherQueryController::executeQuery($queryLoc);

        echo(json_encode(array(
            'weather' => self::mapWeatherResult($requestQueryWeather),
            'location' => self::mapLocationResult($requestQueryLoc),
        )

        ));
        die;
    }

    /**
     * service to get the weather
     **/
    public function mapLocationResult(array $requestQuery)
    {
        $locationResult = [];
        foreach ($requestQuery as $location) {
            $locationResult[] = (new Location())->createFromArray($location);
        }

        return $locationResult;
    }

    /**
     * service to get the weather
     **/
    public function mapWeatherResult(array $requestQuery)
    {
        $locationResult = [];
        foreach ($requestQuery as $location) {
            $locationResult[] = (new Weather2())->createFromArray($location);
        }

        return $locationResult;
    }
}
