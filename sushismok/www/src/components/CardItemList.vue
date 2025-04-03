<template>
  <ul class="cards-item-list">
    <CardItemListItem 
      v-for="item in items" 
      :key="item.name" 
      :item="item"
      @update-favorite="emit('updateFavorite')"
      @open-media="openModal"
    />
  </ul>

  <Modal class="media" :isOpen="openMedia" @close="openMedia = false">
    <h5 class="media-title">
      {{ mediaItem?.name }}

      <span> {{ mediaItem?.price }}zł</span>
    </h5>
    <img class="media-image" :src="mediaItem?.image" alt="media">
    <p class="media-description">
      {{ mediaItem?.description }} <br>
      {{ mediaItem?.count }}
    </p>

    <button @click="openMedia = false" type="button" class="modal-button">  {{ t("common.component.modal.empty.button") }} </button>

  </Modal>
</template>
<script lang="ts" setup>
import { ref, type PropType } from 'vue';
import type { MenuItem } from '../types/MenuItem';
import CardItemListItem from './CardItemListItem.vue';
import Modal from './Modal.vue';
import { useI18n } from 'vue-i18n';

const emit = defineEmits(['updateFavorite']);

defineProps({
  items: {
    type: Object as PropType<MenuItem[]>,
  }
})

const { t } = useI18n();
const mediaItem = ref<MenuItem>();
const openMedia = ref(false);

const openModal = (item: MenuItem) => {
  mediaItem.value = item;
  openMedia.value = true;
}
</script>


<style scoped lang="scss">
  .cards {
    &-item {
      &-list {
        display: flex;
        flex-direction: column;
        row-gap: 6px;
      }
    }
  }

  .media {

    &-image {
      width: 100%;
      height: 100%;
      max-width: fit-content;
      max-height: fit-content;
      object-fit: contain;
      display: block;
      margin: 20px auto;
      border-radius: 12px;
    }

    &-title {
      color: #fff;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: space-between;
      span {
        font-size: 24px;
        color: #d1be8f;
      }
    }

    &-description {
      color: #fff;
      margin-bottom: 20px;
    }
  }

</style>
