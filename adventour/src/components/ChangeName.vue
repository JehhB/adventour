<template>
  <div class="max-w-sm">
    <form ref="form" method="post" class="flex w-full">
      <input
        @blur="
          isEditing = false;
          name = initName;
        "
        ref="input"
        type="text"
        v-model="name"
        name="username"
        :readonly="!isEditing"
        id="name"
        class="w-0 flex-1 bg-transparent text-2xl font-medium leading-none"
      />
    </form>
    <slot />
    <hr class="border-gray-400" />
    <button @click="handleClick" class="mt-4 flex items-center gap-2">
      <template v-if="!isEditing">
        <BIconPencilSquare class="h-[14px] w-[14px] text-gray-600" />
        <span>Edit profile</span>
      </template>
      <template v-else>
        <BIconXLg class="h-[14px] w-[14px] text-gray-600" />
        <span>Cancel changes</span>
      </template>
    </button>
    <a href="change-password.php" class="flex items-center gap-2">
      <BIconGearFill class="h-[14px] w-[14px] text-gray-600" />
      <span>Change password</span>
    </a>
  </div>
</template>
<script setup lang="ts">
import {
  BIconPencilSquare,
  BIconXLg,
  BIconGearFill,
} from "bootstrap-icons-vue";
import { defineProps, ref } from "vue";

const props = defineProps<{ initName: string }>();

const name = ref(props.initName);
const isEditing = ref(false);

function handleClick() {
  if (!isEditing.value) {
    isEditing.value = true;
    input.value.focus();
  } else {
    isEditing.value = false;
    name.value = props.initName;
  }
}

const input = ref<HTMLInputElement>();
</script>
