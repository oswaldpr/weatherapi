<?php

/** @var $resultList */
?>

@extends('Templates.app')

@section('content')
        <weather-dashboard-card :str-result-list='<?php echo json_encode($resultList)?>' :show-result='true'></weather-dashboard-card>
@overwrite

