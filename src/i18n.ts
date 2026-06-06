import pl from "./locales/pl.json";
import ua from "./locales/ua.json";
import en from "./locales/en.json";
import { createI18n } from "vue-i18n";

const messages = {
  "pl": { ...pl},
  "ua": { ...ua},
  "en": { ...en},
};

function getLocale(): string {
  const savedLocale = localStorage.getItem("locale");
  if (savedLocale) {
    return savedLocale;
  }
  return "pl"; // Default locale
}

export default createI18n({
  legacy: false,
  globalInjection: true,
  locale: getLocale(),
  fallbackLocale: "pl",
  messages,
});



