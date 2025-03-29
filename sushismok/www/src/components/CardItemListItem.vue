<template>
  <li class="cards-item-list-li" @click="isOpen = !isOpen">
    <div :class="['cards-item-list-li-row', {'cursor-pointer': isDescription}]" >
      <span>{{ item.name }}</span>
      <span class="ml-auto">{{ item.price }}zł</span>
      <svg v-if="isDescription" :class="['cards-item-list-li-info-icon', {'open': isOpen}]" viewBox="0 0 330 330"><path d="M325.607 79.393c-5.857-5.857-15.355-5.858-21.213.001l-139.39 139.393L25.607 79.393c-5.857-5.857-15.355-5.858-21.213.001-5.858 5.858-5.858 15.355 0 21.213l150.004 150a14.999 14.999 0 0 0 21.212-.001l149.996-150c5.859-5.857 5.859-15.355.001-21.213z"/></svg>
    </div>
    <transition>
      <div v-if="isDescription && isOpen" class="cards-item-list-li-info">
        <img v-if="!!item.image" :src="item.image" :alt="item.name">
        <p v-if="!!item.count" class="text-center mb-2">
          {{ item.count }}
        </p>
        <p v-if="!!item.description">
          {{ item.description }}
        </p>
      </div>
    </transition>
  </li>
</template>
<script lang="ts" setup>
import { computed, ref, type PropType } from 'vue';
import type { MenuItem } from '../types/MenuItem';

const props = defineProps({
  item: {
    type: Object as PropType<MenuItem>,
    required: true,
  }
});

const isOpen = ref(false);

const isDescription = computed(():boolean => {
  return !!props.item.image || !!props.item.description || !!props.item.count;
})
</script>


<style scoped lang="scss">
  .cards-item-list-li {
    padding-bottom: 12px;
    margin-bottom: 12px;
    border-bottom: 1px solid #ccc;
    color: #fff;

    &-row {
      display: flex;
      justify-content: space-between;
      width: 100%;
      align-items: center;

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
      img {
        max-height: 160px;
        max-width: 100%;
        width: 100%;
        object-fit: cover;
        display: block;
        margin-bottom: 6px;
      }
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
