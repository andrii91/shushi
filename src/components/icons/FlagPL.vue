<template>
  <svg viewBox="0 0 640 480" class="flag-icon" :class="className">
    <path d="M640 480H0V240h640z" fill="#fff" />
    <path d="M640 240H0V0h640z" fill="#dc143c" />
  </svg>
</template>

<script setup lang="ts">
defineProps<{
  className?: string;
}>();
</script>

<style scoped>
.flag-icon {
  width: 20px;
  height: 15px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  flex-shrink: 0;
}
</style>
