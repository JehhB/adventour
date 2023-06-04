import { watchEffect, MaybeRefOrGetter, toRef } from "vue";

export function useInert(active: MaybeRefOrGetter<boolean>) {
  const ref = toRef(active);
  const app = document.querySelector("#app") as HTMLDivElement & {
    inert: boolean;
  };
  const body = document.querySelector("body");

  watchEffect((onCleanup) => {
    app.inert = ref.value;
    if (body) body.style.overflow = ref.value ? "hidden" : "auto";

    onCleanup(() => {
      app.inert = false;
    });
  });
}
