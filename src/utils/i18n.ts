import type { MenuItemTranslation } from "@/types/MenuItem";

export const SUPPORTED_LANGS = ["ua", "en", "pl"] as const;
export type Lang = (typeof SUPPORTED_LANGS)[number];
export const FALLBACK_LANG: Lang = "ua";

// Coerce an arbitrary locale string to a supported language code.
export const normalizeLang = (value: string): Lang => {
  return (SUPPORTED_LANGS as readonly string[]).includes(value)
    ? (value as Lang)
    : FALLBACK_LANG;
};

// Pick a {pl,en,ua} translation for the given language, falling back to pl.
export const pickTranslation = (
  field: MenuItemTranslation | undefined,
  lang: Lang
): string => {
  return field ? field[lang] || field.pl || "" : "";
};
