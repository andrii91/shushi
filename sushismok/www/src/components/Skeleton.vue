<template>
  <span class="skeleton" />
</template>

<script setup lang="ts">
defineOptions({
  name: "Skeleton",
});
</script>

<style lang="scss" scoped>
.skeleton {
  display: block;
  background: #252525;
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;

  @keyframes pulse {
    0%,
    100% {
      opacity: 1;
    }
    50% {
      opacity: 0.5;
    }
  }
}
</style>
