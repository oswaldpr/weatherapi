<template>
    <div class="single-result">
        <DisplayElement label="Date" :value="this.resultModel.date" />
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
    };

</script>

<style lang="scss" scoped>
  .single-result {
    margin-bottom: 15px;
  }

</style>
