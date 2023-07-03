<template>
  <button
    @click="onClick"
    :class="isLiked ? 'text-red-600' : 'text-gray-600'"
    class="flex items-center gap-2"
  >
    <span class="text-base leading-none">{{
      formatter.format(likesCounts)
    }}</span>
    <BIconHeartFill />
  </button>
</template>
<script setup lang="ts">
import { toggleables } from "../stores";
import { useAxios } from "@vueuse/integrations/useAxios";
import { BIconHeartFill } from "bootstrap-icons-vue";
import { computed, defineProps } from "vue";

const formatter = new Intl.NumberFormat("en-PH", {
  notation: "compact",
  compactDisplay: "short",
});

const props = defineProps<{
  id: number;
  type: "hotel" | "event" | "place";
}>();

const { data, execute } = useAxios<{
  authenticated: boolean;
  liked: boolean;
  likes: number;
}>(
  "/api/like.php",
  { responseType: "json", params: props },
  { immediate: false }
);

const isAuthenticated = computed(() => {
  if (data.value === undefined) return false;
  return data.value.authenticated;
});

const isLiked = computed(() => {
  if (data.value === undefined) return false;
  return data.value.liked;
});

const likesCounts = computed(() => {
  if (data.value === undefined) return 0;
  return data.value.likes;
});

execute({ method: "GET" });

const notAuthenticatedToast = computed(() =>
  toggleables.get("not authenticated toast")
);

function onClick() {
  if (!isAuthenticated.value && notAuthenticatedToast.value !== undefined) {
    notAuthenticatedToast.value.open();
    return;
  }

  const method = isLiked.value ? "DELETE" : "PUT";
  execute({ method });
}
</script>
