<template>
  <ul class="cards-item-list">
    <CardItemListItem v-for="item in items" :key="item.name" :item="item" />
  </ul>
</template>
<script lang="ts" setup>
import type { PropType } from 'vue';
import type { MenuItem } from '../types/MenuItem';
import CardItemListItem from './CardItemListItem.vue'

defineProps({
  items: {
    type: Object as PropType<MenuItem[]>,
  }
})
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

</style>
