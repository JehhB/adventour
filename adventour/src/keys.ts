import type { InjectionKey } from "vue";

export const GalleryProvider = Symbol() as InjectionKey<{
  register(src: string, alt: string): void;
  spotlight(src: string, alt: string): void;
}>;

export const CarouselProvider = Symbol() as InjectionKey<{
  register(item: { show(): void; hide(): void }): () => void;
}>;
