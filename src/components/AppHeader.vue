<template>
  <header class="app-header">
    <div class="container">
      <img :src="headerSrc" class="app-header-image" alt="header" />
      <img :src="logoSrc" class="app-header-logo" :alt="name" />
      <I18nSelector />
    </div>
  </header>
</template>

<script setup lang="ts">
import I18nSelector from "@/components/I18nSelector.vue";

interface AppHeaderProps {
  headerSrc?: string;
  logoSrc?: string;
  name?: string;
}

const {
  headerSrc = "",
  logoSrc = "",
  name = "",
} = defineProps<AppHeaderProps>();
</script>

<style scoped lang="scss">
.app-header {
  max-width: 560px;
  margin: 0 auto;
  position: relative;

  &-image,
  &-logo {
    height: 172px;
    object-fit: cover;
    width: 100%;
    object-position: 50% 98%;
  }

  &-logo {
    height: 82px;
    width: 82px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
  }
}
</style>
