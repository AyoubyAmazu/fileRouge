<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    iconClass: {
        type: String,
        required: true
    },

    fetchCount: {
        type: Function,
        required: true
    }

});

const count = ref(0);



</script>

<template>
  <div class="col-span-12 lg:col-span-6 xl:col-span-3">
    <div class="card mb-0">
      <div class="flex justify-between mb-4">
        <div>
          <span class="block text-muted-color font-medium mb-4">{{ title }}</span>
          <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{ fetchCount }}</div>
        </div>
        <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border" style="width: 2.5rem; height: 2.5rem">
          <i :class="iconClass"></i>
        </div>
      </div>
      <span class="text-primary font-medium">By </span>
      <span class="text-muted-color">promotion</span>
    </div>
  </div>
</template>
