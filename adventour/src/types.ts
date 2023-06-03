import type { Ref } from "vue";

export type ToggleableProps = {
  active: Readonly<Ref<boolean>>;
  toggle(): void;
  open(): void;
  close(): void;
};

export type CarouselItem = { show(): void; hide(): void };
