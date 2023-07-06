<template>
  <div class="grid place-items-center">
    <form
      ref="form"
      enctype="multipart/form-data"
      method="post"
      class="sr-only"
    >
      <input
        @change="form.submit()"
        ref="fileInput"
        type="file"
        name="pic"
        id="pic"
        accept="image/*"
      />
    </form>
    <button @click="fileInput.click()">
      <b-icon-pencil-fill class="text-gray-400"></b-icon-pencil-fill>
    </button>
  </div>
</template>
<script setup lang="ts">
import { BIconPencilFill } from "bootstrap-icons-vue";
import { ref } from "vue";

const form = ref<HTMLFormElement>();
const fileInput = ref<HTMLInputElement>();
</script>
