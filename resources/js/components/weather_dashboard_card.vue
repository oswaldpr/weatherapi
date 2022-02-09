<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">My Weather dashboard</div>
                    <div class="card-body">
<!--                        <img src="https://media.giphy.com/media/24652QfeZzNIPzoH36/giphy.gif" />-->
                        <form method="post" id="weather-form" class="form-horizontal" ref="getWeatherForm">
                            Custom search
                            <div class="location">
                                <InputWrapperElement label="City" name="city" class="col-6 float-left">
                                    <input id="city_input" name="city" class="form-control" v-model="city">
                                </InputWrapperElement>

                                <InputWrapperElement label="State" name="state" class="col-6 float-right">
                                    <input id="state_input" name="state" class="form-control" v-model="state">
                                </InputWrapperElement>
                                <div class="clearfix"></div>
                            </div>

<!--                            <div class="location">-->
<!--                                <InputWrapperElement label="City" name="city" class="col-6 float-left">-->
<!--                                    <vSelect label="City"-->
<!--                                             id="city_input"-->
<!--                                             name="city"-->
<!--                                             :options="cityOptionList"-->
<!--                                             v-model="city">-->
<!--                                    </vSelect>-->
<!--                                </InputWrapperElement>-->

<!--                                <InputWrapperElement label="State" name="state" class="col-6 float-right">-->
<!--                                    <vSelect label="State"-->
<!--                                             id="state_input"-->
<!--                                             name="state"-->
<!--                                             :options="stateOptionList"-->
<!--                                             v-model="state">-->
<!--                                    </vSelect>-->
<!--                                </InputWrapperElement>-->
<!--                                <div class="clearfix"></div>-->
<!--                            </div>-->

                            <div class="dates-range">
                                <InputWrapperElement label="Start date" name="startDate" class="col-6 float-left">
                                    <datepicker format="yyyy-MM-dd"
                                                name="startDate"
                                                placeholder="Select a start Date"
                                                :open-date="dateMin"
                                                :disabled-dates="disabledDates"
                                                v-model="startDate">
                                    </datepicker>
                                </InputWrapperElement>

                                <InputWrapperElement label="End date" name="startDate" class="col-6 float-right">
                                    <datepicker format="yyyy-MM-dd"
                                                name="endDate"
                                                placeholder="Select an end Date"
                                                :open-date="dateMin"
                                                :disabled-dates="disabledDates"
                                                v-model="endDate">
                                    </datepicker>
                                </InputWrapperElement>
                                <div class="clearfix"></div>
                            </div>

                            <div class="temperatures-range">
                                <InputWrapperElement label="Minimum temperature" name="startTemperature" class="col-6 float-left">
                                    <input id="startTemperature_input" name="startTemperature" class="form-control" v-model="startTemperature">
                                </InputWrapperElement>
                                <InputWrapperElement label="Maximum temperature" name="endTemperature" class="col-6 float-right">
                                    <input id="endTemperature_input" name="endTemperature" class="form-control" v-model="endTemperature">
                                </InputWrapperElement>
                                <div class="clearfix"></div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="getWeather" class="btn btn-default" @click="getWeather()">
                                    getWeather
                                </button>
                            </div>
                        </form>
                        <ResultList v-if="showResultList" :resultList="resultList"></ResultList>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {axiosOperation} from "../appAxiosOperation";
import InputWrapperElement from "./InputWrapperElement";
import Datepicker from "vuejs-datepicker";
import vSelect from "vue-select";
import ResultList from "./ResultList";

    export default {
        name: "weather-dashboard-card",
        components: {
            InputWrapperElement,
            ResultList,
            vSelect,
            Datepicker
        },
        props: {
            resultList: {
                type: Array,
                default: function () {
                    return []
                },
            },
            weatherQueryModel: {
                type: Object,
                default: function () {
                    return {
                        startDate: '',
                        endDate: '',
                        city: '',
                        state: '',
                        startTemperature: '',
                        endTemperature: '',
                    }
                },
            },
        },
        computed: {
            cityOptionList: function () {
                const currentState = this.state;
                const cityByStateList = this.getCityByStateList();
                return [];
            },
            stateOptionList: function () {
                const currentCity = this.city;
                const cityByStateList = this.getCityByStateList();
                return [];
            },
            dateMin: function () {
                return new Date();
            },
            dateMax: function () {
                return new Date(new Date().setFullYear(new Date().getFullYear() + 1))
            },
            disabledDates: function () {
                // Doc: https://www.npmjs.com/package/vuejs-datepicker-fixed-disabled-dates
                const dateRange = {};
                dateRange.to = this.dateMin; // TO: Disable all dates up to min date
                dateRange.from = this.dateMax; // FROM: Disable all dates after max date
                return dateRange;
            },
            //Model
            startDate: {
                get: function () {
                    return this.weatherQueryModel.startDate;
                },
                set: function (value) {
                    this.weatherQueryModel.startDate = value;
                },
            },
            endDate: {
                get: function () {
                    return this.weatherQueryModel.endDate;
                },
                set: function (value) {
                    this.weatherQueryModel.endDate = value;
                },
            },
            city: {
                get: function () {
                    return this.weatherQueryModel.city;
                },
                set: function (value) {
                    this.weatherQueryModel.city = value;
                },
            },
            state: {
                get: function () {
                    return this.weatherQueryModel.state;
                },
                set: function (value) {
                    this.weatherQueryModel.state = value;
                },
            },
            startTemperature: {
                get: function () {
                    return this.weatherQueryModel.startTemperature;
                },
                set: function (value) {
                    this.weatherQueryModel.startTemperature = value;
                },
            },
            endTemperature: {
                get: function () {
                    return this.weatherQueryModel.endTemperature;
                },
                set: function (value) {
                    this.weatherQueryModel.endTemperature = value;
                },
            },
        },
        methods:{
            getWeatherQueryModel() {
                const weatherQueryModel = this.weatherQueryModel;
                const defaultStartDate = weatherQueryModel.startDate ? weatherQueryModel.startDate : this.dateMin;
                const defaultEndDate = weatherQueryModel.endDate ? weatherQueryModel.endDate : this.dateMax;
                return  {
                    startDate : defaultStartDate,
                    endDate : defaultEndDate,
                    city : weatherQueryModel.city,
                    state : weatherQueryModel.state,
                    startTemperature : weatherQueryModel.startTemperature,
                    endTemperature : weatherQueryModel.endTemperature,
                }
            },
            getWeather: async function(){
                const formData = this.getWeatherQueryModel()
                const appOutput = await axiosOperation('weather', formData);
                this.showResultList = true;
                this.resultList = appOutput;
            },
            postWeather: async function(){
                const formData = this.getWeatherQueryModel()
                const appOutput = await axiosOperation('weather', formData);
                // const message = success ? 'Success' : 'Error';
                console.log(appOutput);
            },
        },
        data: function (){
            const showResultList = false;

            return {
                showResultList
            }
        }
    }
</script>
