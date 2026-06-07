import { computed, type ComputedRef, type WritableComputedRef } from "vue";
import { useI18n } from "vue-i18n";
import type { MenuItemTranslation } from "@/types/MenuItem";
import { normalizeLang, pickTranslation, type Lang } from "@/utils/i18n";

const STORAGE_KEY = "locale";

interface UseLocale {
  locale: WritableComputedRef<string>;
  lang: ComputedRef<Lang>;
  setLocale: (value: string) => void;
  translate: (field?: MenuItemTranslation) => string;
}

// Shared locale access: the normalized language and the translation helper.
// Initial locale is already restored from localStorage in `i18n.ts`.
export const useLocale = (): UseLocale => {
  const { locale } = useI18n({ useScope: "global" });

  const lang = computed((): Lang => normalizeLang(locale.value));

  const setLocale = (value: string): void => {
    locale.value = value;
    localStorage.setItem(STORAGE_KEY, value);
  };

  const translate = (field?: MenuItemTranslation): string => {
    return pickTranslation(field, lang.value);
  };

  return { locale, lang, setLocale, translate };
};
