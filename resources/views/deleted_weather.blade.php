<?php

/** @var boolean $isAll */
?>
@extends('Templates.app')

@section('content')
    <h4><?php echo $isAll ? 'All weather records has been deleted' : 'The weather record has been deleted' ?></h4>
@overwrite
