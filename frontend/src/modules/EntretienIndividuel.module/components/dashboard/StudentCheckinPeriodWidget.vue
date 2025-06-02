<script setup>
import { ref, computed, watch } from 'vue';
import { useLayout } from '@/layout/composables/layout';
import { getStudentCheckinPeriods } from '@/modules/EntretienIndividuel.module/service/StudentCheckin.service';

const { getPrimary, getSurface, isDarkTheme } = useLayout();

// Accept selected promotion ID as prop
const props = defineProps({ 
  promotionId: { 
    type: [Number, String], 
    default: null 
  } 
});

const periods = ref([]);
const loading = ref(false);
const error = ref(null);

// Re-fetch when promotion changes
watch(
  () => props.promotionId,
  async (id) => {
    if (id) {
      loading.value = true;
      error.value = null;
      try {
        console.log('Fetching periods for promotion:', id); // Debug log
        const res = await getStudentCheckinPeriods(id);
        console.log('API Response:', res); // Debug log
        periods.value = res.data || [];
      } catch (err) {
        console.error('Error fetching check-in periods:', err);
        error.value = 'Failed to load check-in data';
        periods.value = [];
      } finally {
        loading.value = false;
      }
    } else {
      periods.value = [];
    }
  },
  { immediate: true }
);

const chartData = computed(() => {
  if (!periods.value.length) return null;

  const labels = periods.value.map(p => p.period?.period || p.period);
  const data = periods.value.map(p => p.total || 0);

  return {
    labels,
    datasets: [
      {
        label: 'Check-ins',
        data,
        backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--p-primary-500'),
        borderRadius: 6,
        barThickness: 24,
        categoryPercentage: 0.6,
        barPercentage: 0.8
      }
    ]
  };
});

const chartOptions = computed(() => {
  const documentStyle = getComputedStyle(document.documentElement);
  const borderColor = documentStyle.getPropertyValue('--surface-border');
  const textColor = documentStyle.getPropertyValue('--text-color');
  const textMutedColor = documentStyle.getPropertyValue('--text-color-secondary');

  return {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
      legend: {
        display: false
      },
      tooltip: {
        mode: 'index',
        intersect: false
      }
    },
    scales: {
      x: {
        ticks: {
          color: textMutedColor,
          font: { weight: '500' }
        },
        grid: {
          color: 'transparent'
        }
      },
      y: {
        ticks: {
          color: textMutedColor,
          stepSize: 1,
          callback: (value) => Number.isInteger(value) ? value : null
        },
        grid: {
          color: borderColor,
          borderDash: [4, 4],
          drawTicks: false
        },
        beginAtZero: true
      }
    }
  };
});
</script>

<template>
  <div class="card shadow-md p-4">
    <h2 class="text-lg font-semibold mb-3">Check-ins per Period</h2>
    
    <div v-if="loading" class="flex justify-center items-center h-80">
      <p class="text-gray-500">Loading...</p>
    </div>
    
    <div v-else-if="error" class="flex justify-center items-center h-80">
      <p class="text-red-500">{{ error }}</p>
    </div>
    
    <Chart
      v-else-if="chartData"
      type="bar"
      :data="chartData"
      :options="chartOptions"
      class="h-80"
    />
    
    <div v-else class="flex justify-center items-center h-80">
      <p class="text-sm text-gray-500">No data available for selected promotion.</p>
    </div>
  </div>
</template>