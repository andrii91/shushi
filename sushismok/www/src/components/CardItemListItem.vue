<template>
  <li class="cards-item-list-li">
    <div class="cards-item-list-li-row" >
      <div class="cards-item-list-li-text">
        <div class="cards-item-list-li-name">{{ item.name }}</div>
        <div class="cards-item-list-li-price">{{ item.price }}zł</div>
        <div class="cards-item-list-li-info">
          <p v-if="!!item.description" class="mb-2">
            {{ item.description }}
          </p>
          <p v-if="!!item.count" >
            {{ item.count }}
          </p>
        </div>
      </div>
      <div class="cards-item-list-li-image">
        <img :src="item.image" :alt="item.name">
        <button 
          type="button" 
          :class="['cards-item-list-li-button', {'is-favorite': isFavorite}]" 
          @click="toggleFavorite(item)"
        >
          <svg v-if="!isFavorite" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.25 1.75H4.75C3.64543 1.75 2.75 2.64543 2.75 3.75V14.2504L8 10.75L13.25 14.2504V3.75C13.25 2.64543 12.3546 1.75 11.25 1.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" id="icon-bookmark"></path></svg>
          <svg v-else width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 7H20" stroke="#FE5659" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" id="icon-trash"></path>
            <path d="M10 11V17" stroke="#FE5659" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M14 11V17" stroke="#FE5659" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M9 7V4C9 3.73478 9.10536 3.48043 9.29289 3.29289C9.48043 3.10536 9.73478 3 10 3H14C14.2652 3 14.5196 3.10536 14.7071 3.29289C14.8946 3.48043 15 3.73478 15 4V7M5 7L6 19C6 19.5304 6.21071 20.0391 6.58579 20.4142C6.96086 20.7893 7.46957 21 8 21H16C16.5304 21 17.0391 20.7893 17.4142 20.4142C17.7893 20.0391 18 19.5304 18 19L19 7H5Z" stroke="#FE5659" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
      </div>
    </div>
  </li>
</template>
<script lang="ts" setup>
import { computed, ref, watchEffect, type PropType } from 'vue';
import type { MenuItem } from '../types/MenuItem';

const emit = defineEmits(['updateFavorite']);

const props = defineProps({
  item: {
    type: Object as PropType<MenuItem>,
    required: true,
  }
});

const favoriteData = ref<MenuItem[]>([]);

// Завантажуємо улюблені елементи з localStorage при завантаженні компонента
const loadFavorites = () => {
  const storedData = localStorage.getItem("favorite");
  favoriteData.value = storedData ? JSON.parse(storedData) : [];
};

// Викликаємо при монтуванні компонента
loadFavorites();

// computed для визначення, чи є елемент у списку обраних
const isFavorite = computed(() => {
  return favoriteData.value.some(favItem => favItem.id === props.item.id);
});

const toggleFavorite = (item: MenuItem) => {
  loadFavorites();

  const index = favoriteData.value.findIndex(favItem => favItem.id === item.id);
  if (index !== -1) {
    // Видаляємо елемент, якщо він уже є
    favoriteData.value.splice(index, 1);
  } else {
    // Додаємо новий елемент
    favoriteData.value.push(item);
  }

  // Оновлюємо localStorage
  localStorage.setItem("favorite", JSON.stringify(favoriteData.value));
  emit('updateFavorite');
};

// Автоматично оновлюємо `favoriteData` при зміні localStorage (на випадок оновлення в іншій вкладці)
watchEffect(() => {
  loadFavorites();
});
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
</style>
