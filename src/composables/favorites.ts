import { computed, ref, watch, type ComputedRef, type Ref } from "vue";
import type { MenuItem } from "@/types/MenuItem";

const STORAGE_KEY = "favorite";

const readStorage = (): MenuItem[] => {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    return raw ? (JSON.parse(raw) as MenuItem[]) : [];
  } catch {
    return [];
  }
};

// Single shared source of truth for favorites across the whole app.
const favorites = ref<MenuItem[]>(readStorage());

// Persist on every change.
watch(
  favorites,
  (value) => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(value));
  },
  { deep: true }
);

// Keep favorites in sync when another browser tab updates them.
window.addEventListener("storage", (event) => {
  if (event.key === STORAGE_KEY) {
    favorites.value = readStorage();
  }
});

interface UseFavorites {
  favorites: Ref<MenuItem[]>;
  count: ComputedRef<number>;
  total: ComputedRef<number>;
  hasFavorites: ComputedRef<boolean>;
  isFavorite: (id: MenuItem["id"]) => boolean;
  toggle: (item: MenuItem) => void;
}

export const useFavorites = (): UseFavorites => {
  const count = computed((): number => favorites.value.length);
  const total = computed((): number => {
    return favorites.value.reduce((sum, item) => sum + item.price, 0);
  });
  const hasFavorites = computed((): boolean => count.value > 0);

  const isFavorite = (id: MenuItem["id"]): boolean => {
    return favorites.value.some((item) => item.id === id);
  };

  const toggle = (item: MenuItem): void => {
    const index = favorites.value.findIndex((fav) => fav.id === item.id);
    if (index !== -1) {
      favorites.value.splice(index, 1);
    } else {
      favorites.value.push(item);
    }
  };

  return { favorites, count, total, hasFavorites, isFavorite, toggle };
};
