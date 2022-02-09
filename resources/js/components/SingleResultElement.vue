<template>
    <div class="single-result">
        <DisplayElement label="City" :value="this.resultModel.city" />
        <DisplayElement label="State" :value="this.resultModel.state" />
        <DisplayElement label="Date" :value="this.resultModel.date" />
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
                        city: '',
                        state: '',
                    }
                },
            },
        },
    };

</script>

<style lang="scss" scoped>

  .topElement-content {
    text-align: left;
    width: 100%;
  }

</style>
