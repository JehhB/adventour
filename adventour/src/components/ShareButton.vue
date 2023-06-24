<template>
  <OpenButton v-bind="$attrs" :target="toast" @click="handleClick">
    <BIconShareFill />
  </OpenButton>
  <ToastContainer :name="toast">
    <div class="flex items-center gap-3 p-4">
      <img
        src="../assets/images/share.svg"
        alt="Authenticate to continue"
        class="w-20"
      />
      <div class="w-0 flex-1">
        <div class="font-heading font-semibold text-neutral-800">
          Ready to share
        </div>
        <div class="text-sm">Copied to clipboard</div>
      </div>
    </div>
  </ToastContainer>
</template>
<script setup lang="ts">
import { withDefaults, defineProps } from "vue";
import OpenButton from "./OpenButton.vue";
import ToastContainer from "./ToastContainer.vue";
import { BIconShareFill } from "bootstrap-icons-vue";

const props = withDefaults(
  defineProps<{
    title?: string;
  }>(),
  { title: "Adventour" }
);

async function handleClick() {
  const hero = "Easily find your next travel destination with Adventour";
  const link = window.location.href;
  const data = {
    title: props.title,
    text: hero,
    url: link,
  };

  if (navigator.share && navigator.canShare(data)) {
    await navigator.share(data);
  } else {
    await navigator.clipboard.writeText(`${hero}\n\n${link}`);
  }
}

const toast = Symbol();
</script>
