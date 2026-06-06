export interface MenuItemTranslation {
  pl: string;
  en: string;
  ua: string;
}

export interface MenuItemRaw {
  id: number;
  price: number;
  image: string;
  name: MenuItemTranslation;
  description?: MenuItemTranslation;
  count?: MenuItemTranslation;
  rollsDescription?: MenuItemTranslation;
}

export interface MenuCategoryRaw {
  id: string;
  title: MenuItemTranslation;
  items: MenuItemRaw[];
}

export interface MenuItem {
  id: string | number;
  name: string;
  price: number;
  image: string;
  description?: string;
  count?: string;
  rollsDescription?: string;
}

export interface MenuCategory {
  category: string;
  items: MenuItem[];
}
