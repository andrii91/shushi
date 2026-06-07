<template>
  <Modal :is-open="isOpen" @close="$emit('close')">
    <CardItemList v-if="isShowFavorite" :items="items" />
    <p v-else class="text-center modal-price">
      {{ t("common.component.modal.empty.title") }}
    </p>
    <p v-if="isShowFavorite" class="modal-price">
      {{ t("common.component.modal.empty.subtitle") }} <span>{{ prices }} {{ currency }}</span>
    </p>

    <button type="button" class="modal-button" @click="$emit('close')">
      {{ t("common.component.modal.empty.button") }}
    </button>
  </Modal>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import { useCurrency } from "@/composables/currency";
import Modal from "@/components/Modal.vue";
import CardItemList from "@/components/CardItemList.vue";
import type { MenuItem } from "@/types/MenuItem";

defineEmits<{
  close: [];
}>();

interface FavoriteModalProps {
  isOpen?: boolean;
  isShowFavorite?: boolean;
  items?: MenuItem[];
  prices?: number;
}

const {
  isOpen = false,
  isShowFavorite = false,
  items = [],
  prices = 0,
} = defineProps<FavoriteModalProps>();

const { t } = useI18n();
const currency = useCurrency();
</script>
