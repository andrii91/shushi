<template>
  <Loader v-if="initialLoading" />

  <AppHeader
    :header-src="headerSrc"
    :logo-src="logoSrc"
    :name="settings?.name"
  />
  <main class="main">
    <div class="container">
      <PlaceInfo
        :name="settings?.name"
        :phone="settings?.phone"
        :phone-href="phoneHref"
        :map-url="settings?.mapUrl"
        :address-text="addressText"
        :socials="activeSocials"
      />
      <MenuSection :menu="menu" :loading="loading" />
    </div>
  </main>

  <AppFooter
    :hours-title="hoursTitle"
    :hours-lines="hoursLines"
    :socials="activeSocials"
    :name="settings?.name"
  />

  <FavoriteButton
    v-if="hasFavorites"
    :count="count"
    @open="openModal = true"
  />

  <FavoriteModal
    :is-open="openModal"
    :is-show-favorite="hasFavorites"
    :items="favorites"
    :prices="total"
    @close="closeModal"
  />
</template>

<script setup lang="ts">
import { computed, onMounted, ref, watch } from "vue";
import type { MenuCategoryRaw } from "@/types/MenuItem";
import { transformMenu } from "@/utils/data";
import Loader from "@/components/Loader.vue";
import AppHeader from "@/components/AppHeader.vue";
import PlaceInfo from "@/components/PlaceInfo.vue";
import MenuSection from "@/components/MenuSection.vue";
import AppFooter from "@/components/AppFooter.vue";
import FavoriteButton from "@/components/FavoriteButton.vue";
import FavoriteModal from "@/components/FavoriteModal.vue";
import type { SiteSettings } from "@/types/SiteSettings";
import { provideCurrency } from "@/composables/currency";
import { useLocale } from "@/composables/locale";
import { useFavorites } from "@/composables/favorites";
import headerFallback from "@/assets/header.webp";
import logoFallback from "@/assets/logo.webp";
import { useHead } from '@vueuse/head'

const { locale, translate } = useLocale();
const { favorites, count, total, hasFavorites } = useFavorites();

const settings = ref<SiteSettings | null>(null);

const currency = computed((): string => settings.value?.currency || "zł");
provideCurrency(currency);

const headerSrc = computed((): string => settings.value?.headerImage || headerFallback);
const logoSrc = computed((): string => settings.value?.logo || logoFallback);
const phoneHref = computed((): string => (settings.value?.phone ?? "").replace(/[^\d+]/g, ""));
const addressText = computed((): string => translate(settings.value?.address));
const hoursTitle = computed((): string => translate(settings.value?.hours?.title));
const hoursLines = computed((): string[] =>
  (settings.value?.hours?.lines ?? []).map((line) => translate(line)).filter(Boolean)
);
const activeSocials = computed(() =>
  (settings.value?.socials ?? []).filter((s) => s.type && s.url?.trim())
);

useHead(() => {
  const name = settings.value?.name ?? "";
  const title = `${name} - Menu`;
  const desc = `${title} | Tel: ${settings.value?.phone ?? ""} | ${settings.value?.address?.ua ?? ""}`;
  return {
    title,
    meta: [
      { name: "Title", content: title },
      { name: "description", content: desc },
      { property: "og:type", content: "article" },
      { property: "og:description", content: desc },
      { property: "og:url", content: "https://depozhrat.example.com/" },
      { property: "og:sitename", content: title },
      { property: "og:title", content: title },
      { property: "og:image", content: "https://depozhrat.example.com/images/og.jpeg" },
    ],
  };
});

const openModal = ref(false);
// Spinner for the initial page load (while fetching settings/menu).
const initialLoading = ref(true);
// Skeleton while switching language / reloading content.
const loading = ref(false);
const menuRaw = ref<MenuCategoryRaw[]>([]);

const menu = computed(() => transformMenu(menuRaw.value, locale.value));

// Brief skeleton flash while content re-renders (language switch, modal close).
const reloadContent = (): void => {
  loading.value = true;
  setTimeout(() => { loading.value = false; }, 100);
};

const closeModal = (): void => {
  openModal.value = false;
  reloadContent();
};

onMounted(async () => {
  try {
    const res = await fetch("/data/settings.json");
    settings.value = await res.json();
  } catch {
    settings.value = null;
  }
  try {
    const res = await fetch("/data/menu.json");
    const data = await res.json();
    menuRaw.value = data.categories ?? [];
  } catch {
    menuRaw.value = [];
  }
  initialLoading.value = false;
});

watch(locale, reloadContent);
</script>

<style scoped lang="scss">
.main {
  max-width: 560px;
  margin: 0 auto;
  background: #181818;
  border-radius: 24px 24px 0 0;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  margin-top: -32px;
  padding-bottom: 24px;
  padding-top: 24px;
  position: relative;
  padding-left: 16px;
  padding-right: 16px;
  min-height: 100vh;
}
</style>
