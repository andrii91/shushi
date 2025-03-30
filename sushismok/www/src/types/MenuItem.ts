export interface MenuItem {
  id: string | number;
  name: string;
  price: number;
  image?: string;
  description?: string;
  count?: string;
};

export interface MenuCategory {
  category: string;
  items: MenuItem[];
};
