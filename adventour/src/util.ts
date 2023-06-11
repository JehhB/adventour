import { ref, watchEffect, MaybeRefOrGetter, toRef } from "vue";
import { ToggleableProps } from "./types";

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

export function useToggleable(init = false): ToggleableProps {
  const active = ref(init);

  function toggle() {
    active.value = !active.value;
  }

  function close() {
    active.value = false;
  }

  function open() {
    active.value = true;
  }

  return { active, toggle, close, open };
}
