<template>
  <div class="i18n-selector">
    <button
      @click="toggleDropdown"
      class="dropdown-button"
      :aria-expanded="isOpen"
      aria-haspopup="listbox"
      :title="t(`common.component.i18nSelector.${locale}`)"
    >
      <component :is="currentFlagComponent" />
      <svg class="dropdown-arrow" :class="{ 'rotated': isOpen }" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5z" fill="currentColor"/>
      </svg>
    </button>
    
    <div v-if="isOpen" class="dropdown-menu" role="listbox">
      <button
        v-for="lang in languages"
        :key="lang.code"
        @click="selectLanguage(lang.code)"
        :class="{ 'active': locale === lang.code }"
        class="dropdown-item"
        role="option"
        :aria-selected="locale === lang.code"
        :title="t(`common.component.i18nSelector.${lang.code}`)"
      >
        <component :is="lang.flagComponent" />
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import { ref, computed, onMounted, onUnmounted, nextTick } from "vue";
import FlagPL from "./icons/FlagPL.vue";
import FlagEN from "./icons/FlagEN.vue";
import FlagUA from "./icons/FlagUA.vue";

defineOptions({
  name: "I18nSelector",
});

const { t, locale } = useI18n({ useScope: "global" });
const savedLocale = localStorage.getItem("locale");
locale.value = savedLocale ?? "pl";

const isOpen = ref(false);

const languages = [
  {
    code: "pl",
    name: "Polski",
    flagComponent: FlagPL
  },
  {
    code: "en",
    name: "English",
    flagComponent: FlagEN
  },
  {
    code: "ua",
    name: "Українська",
    flagComponent: FlagUA
  }
];

const currentFlagComponent = computed(() => {
  return languages.find(lang => lang.code === locale.value)?.flagComponent || FlagPL;
});

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const selectLanguage = async (langCode: string) => {
  locale.value = langCode;
  localStorage.setItem("locale", langCode);
  isOpen.value = false;
  
  // Чекаємо наступний тик для оновлення DOM
  await nextTick();
};

const closeDropdown = (event: Event) => {
  const target = event.target as Element;
  if (!target.closest('.i18n-selector')) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
  document.removeEventListener('click', closeDropdown);
});
</script>

<style lang="scss" scoped>
.i18n-selector {
  position: absolute;
  top: 14px;
  right: 16px;
  z-index: 99;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

.dropdown-button {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background: none;
  border: none;
  cursor: pointer;
  width: fit-content;
  border-radius: 8px;
  transition: background-color 0.2s ease;

  &:hover {
    background: rgba(0, 0, 0, 0.05);
  }

  &:focus {
    outline: 2px solid #007bff;
    outline-offset: -2px;
  }
}

.current-lang {
  flex: 1;
  text-align: left;
  font-size: 14px;
}

.dropdown-arrow {
  width: 16px;
  height: 16px;
  transition: transform 0.2s ease;
  
  &.rotated {
    transform: rotate(180deg);
  }
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-top: none;
  border-radius: 0 0 8px 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background: none;
  border: none;
  cursor: pointer;
  width: 100%;
  text-align: left;
  font-size: 14px;
  transition: background-color 0.2s ease;

  &:hover {
    background: rgba(0, 0, 0, 0.05);
  }

  &.active {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
  }

  &:focus {
    outline: none;
    background: rgba(0, 0, 0, 0.05);
  }
}
</style>
