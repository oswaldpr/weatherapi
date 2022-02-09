<template>
    <div class="single-result">
        <DisplayElement label="Date" :value="this.dateGMT" />
        <DisplayElement label="Medium temperature" :value="this.resultModel.temperature" />
        <DisplayElement label="City" :value="this.resultModel.location.city" />
        <DisplayElement label="State" :value="this.resultModel.location.state" />
    </div>
</template>

<script>

    import DisplayElement from "./DisplayElement";

    export default {
        name: "SingleResultElement",
        components: {
            DisplayElement
        },
        props: {
            resultModel: {
                type: Object,
                default: function () {
                    return {
                        id: '',
                        date: '',
                        location: {},
                        temperature: 0,
                    }
                },
            },
        },
        computed: {
            dateGMT: function (){
                return new Date(this.resultModel.date);
            }
        }
    };

</script>

<style lang="scss" scoped>
  .single-result {
    margin-bottom: 15px;
  }

</style>
