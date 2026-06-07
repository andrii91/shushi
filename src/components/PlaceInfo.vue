<template>
  <div class="place-info">
    <div class="place-info-row">
      <h1 class="place-info-title">{{ name }}</h1>
      <a :href="`tel:${phoneHref}`" class="place-info-phone">{{ phone }}</a>
    </div>

    <a class="place-info-address" :href="mapUrl" rel="nofollow" target="_blank">
      <LocationIcon />
      <span>{{ addressText }}</span>
    </a>

    <div class="place-info-socials">
      <a
        v-for="social in socials"
        :key="social.type"
        class="place-info-social"
        :href="social.url"
        rel="nofollow"
        target="_blank"
      >
        <SocialIcon :type="social.type" />
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
import SocialIcon from "@/components/SocialIcon.vue";
import LocationIcon from "@/components/LocationIcon.vue";
import type { SocialLink } from "@/types/SiteSettings";

interface PlaceInfoProps {
  name?: string;
  phone?: string;
  phoneHref?: string;
  mapUrl?: string;
  addressText?: string;
  socials?: SocialLink[];
}

const {
  name = "",
  phone = "",
  phoneHref = "",
  mapUrl = "",
  addressText = "",
  socials = [],
} = defineProps<PlaceInfoProps>();
</script>

<style scoped lang="scss">
.place-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
  color: #fff;
  margin-bottom: 24px;

  &-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }

  &-title {
    font-size: 24px;
    font-weight: bold;
  }

  &-phone {
    color: #d1be8f;
    font-size: 21px;
    font-weight: bold;
    text-decoration: none;

    @media screen and (max-width: 480px) {
      font-size: 16px;
    }
  }

  &-address,
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

  &-socials {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    margin-top: 12px;
  }
}
</style>
