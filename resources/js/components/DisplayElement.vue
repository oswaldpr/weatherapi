<template>
    <div class="result-field">
        <span class="col-6 col-form-label label labelWrapper">
            <label><b>{{ label }}</b>:</label>
        </span>
        <span class="col-6 resulWrap controls">
            {{  value }}
        </span>
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
            value: {},
        },
    };

</script>

<style lang="scss" scoped>

  .result-field {
      span {
          padding: 0;
      }
  }

</style>
