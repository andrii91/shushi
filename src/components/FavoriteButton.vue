<template>
  <div class="favorite-button">
    <button class="favorite-button-trigger modal-button" @click="$emit('open')">
      <span>{{ count }} {{ t("common.favoriteButton") }}</span>
      <BookmarkIcon />
    </button>
  </div>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import BookmarkIcon from "@/components/icons/BookmarkIcon.vue";

defineEmits<{
  open: [];
}>();

interface FavoriteButtonProps {
  count?: number;
}

const { count = 0 } = defineProps<FavoriteButtonProps>();

const { t } = useI18n();
</script>

<style scoped lang="scss">
.favorite-button {
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

  &-trigger {
    width: fit-content;
    margin: auto;
  }
}
</style>
