<template>
  <ul ref="navRef" class="menu-nav">
    <li
      v-for="(category, index) in categories"
      :key="index"
      class="menu-nav-item"
    >
      <a
        href="#"
        class="menu-nav-link"
        :class="{ 'menu-nav-link--active': category === active }"
        @click.prevent="$emit('select', category)"
      >
        {{ category }}
      </a>
    </li>
  </ul>
</template>

<script setup lang="ts">
import { ref, watch, nextTick } from "vue";

defineEmits<{
  select: [category: string];
}>();

interface MenuNavProps {
  categories?: string[];
  active?: string;
}

const { categories = [], active = "" } = defineProps<MenuNavProps>();

const navRef = ref<HTMLUListElement | null>(null);

watch(
  () => active,
  async (): Promise<void> => {
    await nextTick();

    const nav = navRef.value;
    const activeLink = nav?.querySelector<HTMLElement>(".menu-nav-link--active");
    if (!nav || !activeLink) {
      return;
    }

    // Center the active item within the horizontal nav scroll.
    const target =
      activeLink.offsetLeft - nav.clientWidth / 2 + activeLink.clientWidth / 2;
    nav.scrollTo({ left: target, behavior: "smooth" });
  }
);
</script>

<style scoped lang="scss">
.menu-nav {
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

  &-link {
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

    &--active {
      background: #d1be8f;
      border-color: #d1be8f;
      color: #181818;
    }
  }
}
</style>
