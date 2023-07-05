<template>
  <div class="hidden">You are not authenticated</div>
</template>

<script setup lang="ts">
import { auth } from "../stores";
auth.value = false;
</script>
