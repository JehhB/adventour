import type { InjectionKey } from "vue";
import type { ToggleableProps, CarouselItem } from "./types";

export const toggleableProvider = Symbol() as InjectionKey<ToggleableProps>;

export const galleryProvider = Symbol() as InjectionKey<{
  register(src: string, alt: string): void;
  spotlight(src: string, alt: string): void;
}>;

export const carouselProvider = Symbol() as InjectionKey<{
  register(item: CarouselItem): () => void;
}>;
