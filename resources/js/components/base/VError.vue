<script setup lang="ts">
export interface VErrorProps {
  error?: string
}

const props = withDefaults(defineProps<VErrorProps>(), {
  error: '',
})

</script>

<template>
  <p class="help error" v-if="props.error">
    {{ props.error }}
  </p>
</template>

<style lang="scss">
  .error {
    color: red;
  }
</style>
