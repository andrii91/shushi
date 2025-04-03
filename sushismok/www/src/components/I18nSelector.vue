<template>
  <select
    v-model="locale"
    data-testid="i18n-selector"
    class="i18n-selector"
  >
    <option value="pl">{{ t("common.component.i18nSelector.pl") }}</option>
    <option value="en">{{ t("common.component.i18nSelector.en") }}</option>
    <option value="ua">{{ t("common.component.i18nSelector.ua") }}</option>
  </select>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";

defineOptions({
  name: "I18nSelector",
});

const { t, locale } = useI18n({ useScope: "global" });
const savedLocale = localStorage.getItem("locale");
locale.value = savedLocale ?? "pl";

</script>

<style lang="scss" scoped>
.i18n-selector {
  position: absolute;
  top: 14px;
  right: 16px;
  z-index: 99;
  padding: 4px 8px;
  border-radius: 6px;
}
</style>
