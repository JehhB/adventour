<template>
  <button
    @click="onClick"
    class="grid place-items-center rounded-lg p-2"
    :class="
      isGoing ? 'border-2 border-green-900 bg-transparent' : 'bg-green-900'
    "
  >
    <span
      class="text-base font-semibold leading-none"
      :class="isGoing ? 'text-green-900' : 'text-white'"
    >
      {{
        isGoing
          ? "Cannot attend event"
          : goers > 0
          ? `Attend event with ${formatter.format(goers)} others`
          : "Attend event"
      }}
    </span>
  </button>
</template>
<script setup lang="ts">
import { toggleables } from "../stores";
import { useAxios } from "@vueuse/integrations/useAxios";
import { computed, defineProps } from "vue";

const formatter = new Intl.NumberFormat("en-PH", {
  notation: "compact",
  compactDisplay: "short",
});

const props = defineProps<{
  event_id: number;
}>();

const { data, execute } = useAxios<{
  authenticated: boolean;
  going: boolean;
  goers: number;
}>(
  "/api/attend.php",
  { responseType: "json", params: props },
  { immediate: false }
);

const isAuthenticated = computed(() => {
  if (data.value === undefined) return false;
  return data.value.authenticated;
});

const isGoing = computed(() => {
  if (data.value === undefined) return false;
  return data.value.going;
});

const goers = computed(() => {
  if (data.value === undefined) return 0;
  return data.value.goers;
});

execute({ method: "GET" });

const notAuthenticatedToast = computed(() =>
  toggleables.get("not authenticated toast")
);

function onClick() {
  if (!isAuthenticated.value) {
    if (notAuthenticatedToast.value) {
      notAuthenticatedToast.value.open();
    }
    return;
  }

  const method = isGoing.value ? "DELETE" : "PUT";
  execute({ method });
}
</script>
