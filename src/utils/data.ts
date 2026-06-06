import type { MenuCategoryRaw, MenuCategory } from "../types/MenuItem";

export const transformMenu = (raw: MenuCategoryRaw[], locale: string): MenuCategory[] => {
  const lang = (["pl", "en", "ua"].includes(locale) ? locale : "pl") as "pl" | "en" | "ua";
  return raw.map((cat) => ({
    category: cat.title[lang] ?? cat.title.pl,
    items: cat.items.map((item) => ({
      id: item.id,
      price: item.price,
      image: item.image,
      name: item.name[lang] ?? item.name.pl,
      description: item.description?.[lang] ?? item.description?.pl,
      count: item.count?.[lang] ?? item.count?.pl,
      rollsDescription: item.rollsDescription?.[lang] ?? item.rollsDescription?.pl,
    })),
  }));
};
