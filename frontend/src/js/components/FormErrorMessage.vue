<template>
  <small v-if="message" :class="classes" class="form-text">
    {{ message }}
  </small>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: '',
    },
    classes: {
      type: String,
      default: ''
    }
  },

  computed: {}
}
</script>
