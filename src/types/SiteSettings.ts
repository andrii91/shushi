import type { MenuItemTranslation } from "./MenuItem";

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
