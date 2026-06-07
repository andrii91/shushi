import { inject, provide, ref, type InjectionKey, type Ref } from "vue";

const CURRENCY_KEY: InjectionKey<Ref<string>> = Symbol("currency");
const DEFAULT_CURRENCY = "zł";

// Provide the shop currency to the whole component tree (called once in the root).
export const provideCurrency = (currency: Ref<string>): void => {
  provide(CURRENCY_KEY, currency);
};

// Read the reactive currency symbol anywhere below the provider.
export const useCurrency = (): Ref<string> => {
  return inject(CURRENCY_KEY, ref(DEFAULT_CURRENCY));
};
