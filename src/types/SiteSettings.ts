import type { MenuItemTranslation } from "@/types/MenuItem";

export type SocialType =
  | "instagram"
  | "facebook"
  | "tiktok"
  | "youtube"
  | "telegram"
  | "whatsapp"
  | "viber"
  | "x";

export interface SocialLink {
  type: SocialType;
  url: string;
}

export interface SiteSettings {
  name: string;
  phone: string;
  currency: string;
  logo: string;
  headerImage: string;
  mapUrl: string;
  address: MenuItemTranslation;
  hours: {
    title: MenuItemTranslation;
    lines: MenuItemTranslation[];
  };
  socials: SocialLink[];
}
