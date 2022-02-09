<template>
    <div class="result-list">
        <div class="label-text" v-if="hasResult">
            <div class="result-message"> We found {{ total }} result</div>
            <div class="input-checkbox-container" v-for="option in resultList">
                <SingleResultElement :resultModel="option"></SingleResultElement>
            </div>
        </div>
        <div class="result-message" v-else>Sorry, no result found!</div>
    </div>
</template>

<script>

    import SingleResultElement from "./SingleResultElement";
    export default {
        name: "ResultList",
        components: {SingleResultElement},
        props: {
            resultList: {
                type: Array,
                default: function () {
                    return []
                },
            },
        },
        computed: {
            total: function () {
                return this.resultList.length;
            },
            hasResult: function () {
                return this.total > 0;
            },
        }
    };

</script>

<style lang="scss" scoped>

  .topElement-content {
    text-align: left;
    width: 100%;
  }

</style>
