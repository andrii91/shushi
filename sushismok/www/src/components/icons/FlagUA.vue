<template>
  <svg viewBox="0 0 640 480" class="flag-icon" :class="className">
    <path d="M0 0h640v240H0z" fill="#005BBB" />
    <path d="M0 240h640v240H0z" fill="#FFD700" />
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
