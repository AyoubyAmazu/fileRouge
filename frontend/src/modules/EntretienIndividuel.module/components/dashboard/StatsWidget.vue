<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  promotion: String,
  fetchCount: Function,
  title: String,
  iconClass: String
});

const count = ref(0);

const loadCount = async () => {
  if (props.promotion && props.fetchCount) {
    const res = await props.fetchCount(props.promotion);
    count.value = res.data.data;
  }
};

watch(() => props.promotion, loadCount, { immediate: true });
</script>

<template>
  <div class="col-span-12 lg:col-span-6 xl:col-span-3">
    <div class="card mb-0">
      <div class="flex justify-between mb-4">
        <div>
          <span class="block text-muted-color font-medium mb-4">{{ title }}</span>
          <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{ count }}</div>
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
