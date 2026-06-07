<template>
  <li class="cards-item-list-li" :data-id="item.id">
    <div class="cards-item-list-li-row">
      <div class="cards-item-list-li-text">
        <div class="cards-item-list-li-name">{{ item.name }}</div>
        <div class="cards-item-list-li-price">{{ item.price }} {{ currency }}</div>
        <div class="cards-item-list-li-info">
          <p v-if="!!item.description" class="mb-2">
            {{ item.description }}
          </p>
          <p v-if="!!item.count" >
            {{ item.count }}
          </p>
          <div v-if="!!item.rollsDescription" class="rolls-details">
            <button 
              v-if="!showRollsDetails" 
              @click="showRollsDetails = true" 
              class="details-button"
            >
              {{ t("common.buttons.details") }}
            </button>
            <transition name="fade">
              <p v-if="showRollsDetails" class="mb-2 rolls-description">
                {{ item.rollsDescription }}
              </p>
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
          
        </div>
      </div>
      <div class="cards-item-list-li-image">
        <img :src="item.image" :alt="item.name" @click="openImage(item)">
        <button
          type="button"
          :class="['cards-item-list-li-button', {'is-favorite': isFavorite(item.id)}]"
          @click="toggle(item)"
        >
          <BookmarkIcon v-if="!isFavorite(item.id)" />
          <TrashIcon v-else />
        </button>
      </div>
    </div>
  </li>
</template>
<script lang="ts" setup>
import { ref, type PropType } from 'vue';
import type { MenuItem } from '@/types/MenuItem';
import { useI18n } from 'vue-i18n';
import { useCurrency } from '@/composables/currency';
import { useFavorites } from '@/composables/favorites';
import BookmarkIcon from '@/components/icons/BookmarkIcon.vue';
import TrashIcon from '@/components/icons/TrashIcon.vue';

const emit = defineEmits(['openMedia']);

defineProps({
  item: {
    type: Object as PropType<MenuItem>,
    required: true,
  }
});

const { t } = useI18n();
const currency = useCurrency();
const { isFavorite, toggle } = useFavorites();

const showRollsDetails = ref(false);

const openImage = (item: MenuItem) => {
  if (item.image != '/images/menu/empty.svg') {
    emit('openMedia', item);
  }
}
</script>


<style scoped lang="scss">
  .cards-item-list-li {
    padding-bottom: 24px;
    margin-bottom: 24px;
    border-bottom: 1px solid #ccc;
    color: #fff;

    &:last-child {
      border: 0;
    }

    &-button {
      position: absolute;
      bottom: -8px;
      right: -4px;
      width: 40px;
      height: 40px;
      background: #181818;
      border: 2px solid #181818;
      border-radius: 24px;
      padding: 12px 10px;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 4px;
      cursor: pointer;

      &.is-favorite {
        color: #181818;
        background: #fff;
        border: 2px solid #fff;
      }
    }

    &-name {
      font-weight: bold;
    }

    &-price {
      font-size: 21px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    &-image {
      max-width: 100px;
      height: 75px;
      flex-shrink: 0;
      cursor: pointer;
      border-radius: 16px;
      -webkit-border-radius: 16px;
      -moz-border-radius: 16px;
      width: 100%;
      position: relative;
      transition: all .2s ease 0s;
      img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        display: block;
        border-radius: 12px;
      }
    }

    &-text {
      max-width: calc(100% - 100px);
    }

    &-row {
      display: flex;
      justify-content: space-between;
      width: 100%;
      gap: 12px;

      &.cursor-pointer {
        * {
          transition: .3s;
        }
        &:hover {
          color: #d1be8f;
        }
      }
    }

    &-info {
      margin-top: 8px;
      
      p {
        font-size: 12px;
      }

      .rolls-description {
        font-size: 11px;
        color: #d1be8f;
        font-style: italic;
        line-height: 1.4;
      }

      .rolls-details {
        margin: 8px 0;
      }

      .details-button {
        background: none;
        border: 1px solid #d1be8f;
        color: #d1be8f;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        
        &:hover {
          background: #d1be8f;
          color: #181818;
        }
      }

      &-icon {
        width: 8px;
        height: 8px;
        fill: currentColor;
        transition: transform 0.3s ease;
        margin-left: 4px;
  
        &.open {
          transform: rotate(180deg);
        }
      }
    }
  }

  .v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
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
