<template>
  <footer class="app-footer">
    <div class="app-footer-hours">
      <div class="app-footer-hours-title">{{ hoursTitle }}</div>

      <div v-for="(line, i) in hoursLines" :key="i" class="app-footer-hours-line">
        {{ line }}
      </div>
    </div>

    <div class="app-footer-socials">
      <a
        v-for="social in socials"
        :key="social.type"
        class="app-footer-social"
        :href="social.url"
        rel="nofollow"
        target="_blank"
      >
        <SocialIcon :type="social.type" />
      </a>
    </div>

    <div class="app-footer-copyright">&#169; {{ name }} {{ year }}</div>
  </footer>
</template>

<script setup lang="ts">
import SocialIcon from "@/components/SocialIcon.vue";
import type { SocialLink } from "@/types/SiteSettings";

interface AppFooterProps {
  hoursTitle?: string;
  hoursLines?: string[];
  socials?: SocialLink[];
  name?: string;
}

const {
  hoursTitle = "",
  hoursLines = [],
  socials = [],
  name = "",
} = defineProps<AppFooterProps>();

const year = new Date().getFullYear();
</script>

<style scoped lang="scss">
.app-footer {
  text-align: center;
  color: #676767;
  max-width: 560px;
  margin: 0 auto;
  position: relative;
  background: #181818;
  padding-bottom: 100px;

  &-hours {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    margin-bottom: 12px;
    color: #676767;

    &-title {
      font-size: 18px;
      font-weight: bold;
    }
  }

  &-socials {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin: 32px 0;
  }

  &-social {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #676767;
    text-decoration: none;
    transition: 0.3s;

    &:hover {
      color: #fff;
    }
  }
}
</style>
