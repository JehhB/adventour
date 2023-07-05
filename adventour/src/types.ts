import type { Ref } from "vue";

export type ToggleableProps = {
  active: Ref<boolean>;
  toggle(): void;
  open(): void;
  close(): void;
};

export type CarouselItem = { show(): void; hide(): void };

export type Offering = {
  offeringId: number;
  stays: number;
  maxPerson: number;
  mealPlan: "none" | "breakfast" | "all_inclusive";
  price: number;
  originalPrice: number;
  link: string;
};
