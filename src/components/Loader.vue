<template>
  <div class="loader" role="status" aria-live="polite">
    <span class="loader-spinner" />
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: "Loader",
});
</script>

<style lang="scss" scoped>
.loader {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #272727;

  &-spinner {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 4px solid rgba(209, 190, 143, 0.25);
    border-top-color: #d1be8f;
    animation: loader-spin 0.8s linear infinite;
  }

  @keyframes loader-spin {
    to {
      transform: rotate(360deg);
    }
  }
}
</style>
