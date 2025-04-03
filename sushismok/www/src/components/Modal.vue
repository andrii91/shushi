<template>
  <div v-if="isOpen" class="modal-overlay" @click.self="close">
    <div class="modal">
      <button class="close-btn" @click="close">&times;</button>
      <div class="modal-content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, watch, onUnmounted } from 'vue';

const props = defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};

// Додаємо/видаляємо клас до body
watch(() => props.isOpen, (newVal) => {
  if (newVal) {
    document.body.classList.add('modal-opened');
  } else {
    document.body.classList.remove('modal-opened');
  }
});

// Чистимо клас при демонтажі компонента
onUnmounted(() => {
  document.body.classList.remove('modal-opened');
});
</script>

<style scoped lang="scss">
.modal {
  background: #272727;
  padding: 40px 20px;
  border-top-left-radius: 24px;
  border-top-right-radius: 24px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  position: relative;
  width: 100%;
  max-width: 560px;
  &-content {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
    padding: 24px 8px 0;
    overflow-x: hidden;
  }

  &-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    z-index: 100;
  }
}

.close-btn {
  position: absolute;
  top: 14px;
  right: 18px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #d1be8f;
}
</style>
