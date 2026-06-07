<template>
  <div ref="rootRef" class="menu-section">
    <MenuNav
      :categories="categoryNames"
      :active="activeCategory"
      @select="onCategoryClick"
    />

    <Skeleton v-if="loading" class="menu-section-skeleton" />

    <template v-else>
      <div
        v-for="category in menu"
        :id="category.category"
        :key="category.category"
        class="menu-section-item"
      >
        <h4 class="menu-section-item-title">
          {{ category.category }}
        </h4>

        <CardItemList :items="category.items" />
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from "vue";
import CardItemList from "@/components/CardItemList.vue";
import Skeleton from "@/components/Skeleton.vue";
import MenuNav from "@/components/MenuNav.vue";
import type { MenuCategory } from "@/types/MenuItem";

interface MenuSectionProps {
  menu?: MenuCategory[];
  loading?: boolean;
}

const { menu = [], loading = false } = defineProps<MenuSectionProps>();

const rootRef = ref<HTMLElement | null>(null);
const activeCategory = ref("");
let observer: IntersectionObserver | null = null;

const categoryNames = computed((): string[] => {
  return menu.map((category) => category.category);
});

const onIntersect = (entries: IntersectionObserverEntry[]): void => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      activeCategory.value = entry.target.id;
    }
  });
};

const setupObserver = async (): Promise<void> => {
  observer?.disconnect();

  if (loading || !menu.length) {
    return;
  }

  await nextTick();

  const sections =
    rootRef.value?.querySelectorAll<HTMLElement>(".menu-section-item");
  if (!sections?.length) {
    return;
  }

  // A thin band near the top of the viewport: an item becomes active when its
  // section reaches just under the sticky nav.
  observer = new IntersectionObserver(onIntersect, {
    rootMargin: "-15% 0px -80% 0px",
    threshold: 0,
  });
  sections.forEach((section) => observer?.observe(section));

  activeCategory.value = sections[0].id;
};

const onCategoryClick = (category: string): void => {
  const element = document.getElementById(category);
  if (!element) {
    return;
  }

  const offset = 28;
  const elementPosition = element.getBoundingClientRect().top + window.scrollY;
  window.scrollTo({ top: elementPosition - offset, behavior: "smooth" });
};

onMounted(setupObserver);

onBeforeUnmount(() => {
  observer?.disconnect();
});

watch([() => menu, () => loading], setupObserver);
</script>

<style scoped lang="scss">
.menu-section {
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

  &-skeleton {
    min-height: 100vh;
    width: 100%;
    border-radius: 24px;
  }
}
</style>
