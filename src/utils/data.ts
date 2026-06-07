import type { MenuCategoryRaw, MenuCategory } from "@/types/MenuItem";
import { normalizeLang, pickTranslation } from "@/utils/i18n";

export const transformMenu = (raw: MenuCategoryRaw[], locale: string): MenuCategory[] => {
  const lang = normalizeLang(locale);
  return raw.map((cat) => ({
    category: pickTranslation(cat.title, lang),
    items: cat.items.map((item) => ({
      id: item.id,
      price: item.price,
      image: item.image,
      name: pickTranslation(item.name, lang),
      description: pickTranslation(item.description, lang) || undefined,
      count: pickTranslation(item.count, lang) || undefined,
      rollsDescription: pickTranslation(item.rollsDescription, lang) || undefined,
    })),
  }));
};
