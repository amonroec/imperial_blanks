<template>
  <div class="card inner_card">
    <div v-if="title" class="card-header">
      {{ title }}
    </div>

    <div class="card-body">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InnerCard',

  props: {
    title: { type: String, default: null }
  }
}
</script>
