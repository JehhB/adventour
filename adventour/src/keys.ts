import type { InjectionKey } from "vue";
import type { CarouselItem, Offering } from "./types";

export const galleryProvider = Symbol() as InjectionKey<{
  register(src: string, alt: string): void;
  spotlight(src: string, alt: string): void;
}>;

export const carouselProvider = Symbol() as InjectionKey<{
  register(item: CarouselItem): () => void;
}>;

export const offeringSelectProvider = Symbol() as InjectionKey<{
  register(item: Offering): void;
}>;
