<template>
  <Loader v-if="initialLoading" />

  <header class="header">
    <div class="container">
      <img :src="headerSrc" alt="header" />
      <img :src="logoSrc" class="logo" :alt="settings?.name" />
      <I18nSelector 
        @change="updateLocale"
      />
    </div>
  </header>
  <main class="main">
    <div class="container">
      <div class="main-place">
        <div class="main-place-row">
          <h1 class="main-place-title">{{ settings?.name }}</h1>
          <a :href="`tel:${phoneHref}`" class="main-place-phone">
            {{ settings?.phone }}</a
          >
        </div>
               
        <a
          class="main-place-address"
          :href="settings?.mapUrl"
          rel="nofollow"
          target="_blank"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 256 256"
            width="16"
            height="16"
            fill="currentColor"
          >
            <g>
              <path
                d="M128,64a40,40,0,1,0,40,40A40,40,0,0,0,128,64Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,128Zm0-112a88.1,88.1,0,0,0-88,88c0,31.4,14.51,64.68,42,96.25a254.19,254.19,0,0,0,41.45,38.3,8,8,0,0,0,9.18,0A254.19,254.19,0,0,0,174,200.25c27.45-31.57,42-64.85,42-96.25A88.1,88.1,0,0,0,128,16Zm0,206c-16.53-13-72-60.75-72-118a72,72,0,0,1,144,0C200,161.23,144.53,209,128,222Z"
              ></path>
            </g>
          </svg>
          <span>
            {{ addressText }}
          </span>
        </a>

        <div class="main-social-row">
          <a
            v-for="social in activeSocials"
            :key="social.type"
            class="main-place-social"
            :href="social.url"
            rel="nofollow"
            target="_blank"
          >
            <SocialIcon :type="social.type" />
          </a>
        </div>
       
      </div>
      <div class="cards">
        <ul class="menu">
          <li v-for="(items, index) in menu" :key="index">
            <a href="#" @click.prevent="scrollTo(items.category)">
              {{ items.category }}
            </a>
          </li>
        </ul>
        <Skeleton class="menu-skeleton" v-if="loading" />

        <template v-else>
          <div
            class="cards-item"
            v-for="(items, index) in menu"
            :key="items.category"
            :id="items.category"
          >
            <h4 class="cards-item-title">
              {{ items.category }}
            </h4>

            <CardItemList :items="menu[index].items" @update-favorite="updateFavorite"/>
          </div>
        </template>
      </div>
    </div>
  </main>
  <footer class="footer">
    <div class="main-place-address main-place-time">
      <div class="main-place-time-title">{{ hoursTitle }}</div>

      <div v-for="(line, i) in hoursLines" :key="i">{{ line }}</div>
    </div>
    <div class="main-social-row">
      <a
        v-for="social in activeSocials"
        :key="social.type"
        class="main-place-social"
        :href="social.url"
        rel="nofollow"
        target="_blank"
      >
        <SocialIcon :type="social.type" />
      </a>
    </div>
    <div> &#169; {{ settings?.name }} {{ year }}</div>
  </footer>

  <div v-if="isShowFavorite" class="open-favorite-button">
    <button class="modal-button" @click="openModal = true">
      <span>{{countFavorite}} {{ t("common.favoriteButton") }}</span>
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.25 1.75H4.75C3.64543 1.75 2.75 2.64543 2.75 3.75V14.2504L8 10.75L13.25 14.2504V3.75C13.25 2.64543 12.3546 1.75 11.25 1.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" id="icon-bookmark"></path></svg>
    </button>
  </div>

  <Modal :isOpen="openModal" @close="closeModal">
    <CardItemList v-if="isShowFavorite" :items="favoriteData" @update-favorite="updateFavorite"/>
    <p v-else class="text-center modal-price">{{ t("common.component.modal.empty.title") }}</p>
    <p v-if="isShowFavorite" class="modal-price"> {{ t("common.component.modal.empty.subtitle") }} <span>{{ prices }}zł</span></p>

    <button @click="closeModal" type="button" class="modal-button">  {{ t("common.component.modal.empty.button") }} </button>
  </Modal>
</template>

<script setup lang="ts">
import { computed, onMounted, ref, watch } from "vue";
import CardItemList from "./components/CardItemList.vue";
import type { MenuItem, MenuCategoryRaw } from "./types/MenuItem";
import { transformMenu } from "./utils/data";
import Modal from "./components/Modal.vue";
import Skeleton from "./components/Skeleton.vue";
import Loader from "./components/Loader.vue";
import { useI18n } from "vue-i18n";
import I18nSelector from "./components/I18nSelector.vue";
import SocialIcon from "./components/SocialIcon.vue";
import type { SiteSettings } from "./types/SiteSettings";
import headerFallback from "./assets/header.webp";
import logoFallback from "./assets/logo.webp";
import { useHead } from '@vueuse/head'

const { t, locale } = useI18n();

const settings = ref<SiteSettings | null>(null);

const lang = computed(() =>
  (["pl", "en", "ua"].includes(locale.value) ? locale.value : "pl") as "pl" | "en" | "ua"
);

const headerSrc = computed(() => settings.value?.headerImage || headerFallback);
const logoSrc = computed(() => settings.value?.logo || logoFallback);
const phoneHref = computed(() => (settings.value?.phone ?? "").replace(/[^\d+]/g, ""));
const addressText = computed(() => settings.value?.address?.[lang.value] || settings.value?.address?.pl || "");
const hoursTitle = computed(() => settings.value?.hours?.title?.[lang.value] || settings.value?.hours?.title?.pl || "");
const hoursLines = computed(() =>
  (settings.value?.hours?.lines ?? [])
    .map((l) => l[lang.value] || l.pl)
    .filter(Boolean)
);
const activeSocials = computed(() =>
  (settings.value?.socials ?? []).filter((s) => s.type && s.url?.trim())
);
const year = new Date().getFullYear();

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

const favoriteData = ref<MenuItem[]>([]);
const openModal = ref(false);
// Спінер на перше завантаження сторінки (поки тягнемо settings/menu).
const initialLoading = ref(true);
// Skeleton під час зміни мови / перезавантаження контенту.
const loading = ref(false);
const menuRaw = ref<MenuCategoryRaw[]>([]);

const menu = computed(() => transformMenu(menuRaw.value, locale.value));

const scrollTo = (category: string) => {
  const element = document.getElementById(category);
  if (element) {
    const offset = 28;
    const elementPosition =
      element.getBoundingClientRect().top + window.scrollY;
    window.scrollTo({ top: elementPosition - offset, behavior: "smooth" });
  }
};

const countFavorite = ref(favoriteData.value.length);

const updateFavorite = () => {
  const storedData = localStorage.getItem("favorite");
  if (storedData) {
    favoriteData.value = JSON.parse(storedData);
  }
  countFavorite.value = favoriteData.value.length;
};

const closeModal = () => {
  openModal.value = false;
  loading.value = true;
  setTimeout(() => { loading.value = false; }, 100);
};

const isShowFavorite = computed((): boolean => countFavorite.value > 0);

const prices = computed(() =>
  favoriteData.value.reduce((sum, item) => sum + item.price, 0)
);

onMounted(async () => {
  updateFavorite();
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

const updateLocale = () => {
  localStorage.setItem("locale", locale.value);
  loading.value = true;
  setTimeout(() => { loading.value = false; }, 100);
};

watch(locale, updateLocale);
</script>

<style scoped lang="scss">
.header {
  max-width: 560px;
  margin: 0 auto;
  position: relative;

  img {
    height: 172px;
    object-fit: cover;
    width: 100%;
    object-position: 50% 98%;

    &.logo {
      height: 82px;
      width: 82px;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translateX(-50%) translateY(-50%);
    }
  }
}

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
  max-width: 560px;
  padding-left: 16px;
  padding-right: 16px;
  min-height: 100vh;

  &-place {
    display: flex;
    flex-direction: column;
    gap: 8px;
    color: #fff;
    margin-bottom: 24px;

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

    &-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
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

    &-time {
      flex-direction: column;
      margin-bottom: 12px;

      &-title {
        font-size: 18px;
        font-weight: bold;
      }
    }
  }

  &-social-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    margin-top: 12px;
  }
}

.cards {
  display: flex;
  flex-direction: column;
  row-gap: 12px;

  &-item {
    background: #252525;
    border-radius: 24px;
    padding: 24px 12px 0;

    &-title {
      color: #d1be8f;
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 8px;
    }
  }
}

.menu {
  position: sticky;
  top: 0;
  display: flex;
  align-items: center;
  gap: 6px;
  width: 100%;
  overflow-x: auto;
  background: #181818;
  padding: 4px 0;
  z-index: 99;

  li {
    a {
      display: block;
      color: #ccc;
      border: 1px solid #ccc;
      padding: 4px 8px;
      text-decoration: none;
      border-radius: 100px;
      transition: 0.3s;
      text-wrap: nowrap;

      &:hover {
        background: #ccc;
        color: #181818;
      }
    }
  }
}

.footer {
  text-align: center;
  color: #676767;
  max-width: 560px;
  margin: 0 auto;
  position: relative;
  background: #181818;
  padding-bottom: 100px;

  .main-social-row {
    justify-content: center;
    margin: 32px 0
  }
}

.open-favorite-button {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  max-width: 560px;
  z-index: 50;
  padding: 20px 20px 24px;
  background: #181818;
  border-top-left-radius: 24px;
  border-top-right-radius: 24px;
  width: 100%;

  .modal-button {
    width: fit-content;
    margin: auto;
  }
}

.menu-skeleton {
  min-height: 100vh;
  width: 100%;
  border-radius: 24px;
}
</style>
