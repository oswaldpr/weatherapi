<template>
    <div class="form-group row input-wrapper-element" :class="'input-wrapper-element-' + name">
        <div class="col-12 col-form-label label labelWrapper " :class="'label-' + name">
            <label :for=name>
                {{label}}
            </label>
        </div>
        <div class="col-12 inputWrap controls " :class="'controls-' + name">
            <slot></slot>
        </div>
    </div>
</template>

<script>

    export default {
        name: "InputWrapperElement",
        props: {
            label: {
                type: String,
                default: ""
            },
            name: {
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
