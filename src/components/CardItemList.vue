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
      {{ mediaItem?.description }} 
      <br>
      <br>
      {{ mediaItem?.count }}
      <div v-if="mediaItem?.rollsDescription" class="rolls-details">
        <button 
          v-if="!showRollsDetails" 
          @click="showRollsDetails = true" 
          class="details-button"
        >
          {{ t("common.buttons.details") }}
        </button>
        <transition name="fade">
          <span v-if="showRollsDetails" class="rolls-description">
            {{ mediaItem?.rollsDescription }}
          </span>
        </transition>
        <transition name="fade">
                  <button 
          v-if="showRollsDetails" 
          @click="showRollsDetails = false" 
          class="details-button"
        >
          {{ t("common.buttons.hide") }}
        </button>
        </transition>
      </div>
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
const showRollsDetails = ref(false);

const openModal = (item: MenuItem) => {
  mediaItem.value = item;
  openMedia.value = true;
  showRollsDetails.value = false; // Скидаємо стан при відкритті нового модального вікна
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

      .rolls-description {
        font-size: 13px;
        color: #d1be8f;
        font-style: italic;
        line-height: 1.4;
        display: block;
        margin: 8px 0;
      }

      .rolls-details {
        margin: 12px 0;
      }

      .details-button {
        background: none;
        border: 1px solid #d1be8f;
        color: #d1be8f;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 4px 0;
        display: block;
        width: fit-content;
        margin-left: auto;

        &:hover {
          background: #d1be8f;
          color: #181818;
        }
      }
    }
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }

</style>
