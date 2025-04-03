<template>
  <header class="header">
    <div class="container">
      <img src="./assets/header.webp" alt="header" />
      <img src="./assets/logo.webp" class="logo" alt="header" />
      <I18nSelector 
        @change="updateLocale"
      />
    </div>
  </header>
  <main class="main">
    <div class="container">
      <div class="main-place">
        <div class="main-place-row">
          <h1 class="main-place-title">Sushi Smok</h1>
          <a href="tel:+48880503760" class="main-place-phone">
            +48 880 503 760</a
          >
        </div>
               
        <a
          class="main-place-address"
          href="https://maps.app.goo.gl/QGLZegSUG5hXpC527"
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
            {{ t("common.address") }}
          </span>
        </a>
        <a
          class="main-place-social mb-2"
          href="https://www.instagram.com/sushismok_s/"
          rel="nofollow"
          target="_blank"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"
            />
          </svg>

          @sushismok_s
        </a>
      </div>
      <div class="cards">
        <ul class="menu">
          <li v-for="(items, index) in menu" :key="index">
            <a href="#" @click.prevent="scrollTo(items.category)">
              {{ items.category }}
            </a>
          </li>
        </ul>
        <div
          v-if="!loading" 
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

        <Skeleton class="menu-skeleton" v-else />
      </div>
    </div>
  </main>
  <footer class="footer">
    <div class="main-place-address main-place-time">
      <div class="main-place-time-title">{{ t("common.hours.title")}}</div>

      <div>{{ t("common.hours.time1")}}</div>
      <div>{{ t("common.hours.time2")}}</div>
    </div>
    <div> &#169; sushismok.ct.ws</div>
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

  {{ t("common.menu.dodatki.items.6.name") }}
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import CardItemList from "./components/CardItemList.vue";
import type { MenuItem } from "./types/MenuItem";
import { getMenu } from "./utils/data";
import Modal from "./components/Modal.vue";
import Skeleton from "./components/Skeleton.vue";
import { useI18n } from "vue-i18n";
import I18nSelector from "./components/I18nSelector.vue";

const { t, locale } = useI18n();
const favoriteData = ref<MenuItem[]>([]);
const openModal = ref(false);
const loading = ref(true);
const menu = ref(getMenu(t));

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
}

const closeModal = () => {
  openModal.value = false;
  loading.value = true;

  setTimeout(function(){
    loading.value = false;
  },100)
}

const isShowFavorite = computed((): boolean => {
  return countFavorite.value > 0;
})

const prices = computed(() => {
  return favoriteData.value.reduce((sum, item) => sum + item.price, 0);
});

onMounted(()=> {
  updateFavorite();
  loading.value = false;
})

const updateLocale = () => {
  localStorage.setItem("locale", locale.value);
  loading.value = true;

  menu.value = getMenu(t);

  setTimeout(function(){
    loading.value = false;
  },100)
};
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
