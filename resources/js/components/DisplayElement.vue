<template>
    <div class="result-list">
        <div class="col-6 col-form-label label labelWrapper">
            <label>{{ label }}</label>
        </div>
        <div class="col-6 resulWrap controls">
            {{ value }}
        </div>
    </div>
</template>

<script>

    export default {
        name: "DisplayElement",
        props: {
            label: {
                type: String,
                default: ""
            },
            value: {
                type: String,
                default: ""
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
