<script setup>
import { ref, watch } from 'vue';
import { getRecentStudentCheckins } from '@/modules/EntretienIndividuel.module/service/StudentCheckin.service';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';

const props = defineProps({
  promotionId: { type: [Number, String], default: null },
});

const recentStudentCheckins = ref([]);
const loading = ref(false);
const error = ref(null);

const fetchRecentCheckins = async (id) => {
  if (!id) {
    recentStudentCheckins.value = [];
    return;
  }

  loading.value = true;
  error.value = null;
  
  try {
    console.log('Fetching recent checkins for promotion:', id);
    const res = await getRecentStudentCheckins(id);
    console.log('Recent checkins response:', res.data);
    recentStudentCheckins.value = res.data || [];
  } catch (err) {
    console.error('Error fetching recent check-ins:', err);
    error.value = err.message || 'Failed to load recent check-ins';
    recentStudentCheckins.value = [];
  } finally {
    loading.value = false;
  }
};

watch(
  () => props.promotionId,
  (newId) => {
    fetchRecentCheckins(newId);
  },
  { immediate: true }
);
</script>

<template>
  <div class="card">
    <h2 class="text-lg font-semibold mb-3">Recent Check-ins</h2>
    
    <div v-if="error" class="text-red-500 mb-3 p-3 bg-red-50 rounded">
      {{ error }}
    </div>

    <DataTable
      :value="recentStudentCheckins"
      class="p-datatable-sm"
      responsiveLayout="scroll"
      :loading="loading"
      :emptyMessage="promotionId ? 'No recent check-ins found' : 'Please select a promotion'"
    >
      <Column header="Learner">
        <template #body="{ data }">
          {{ data.student?.name || data.student?.nom || '—' }}
        </template>
      </Column>
      <Column header="Group">
        <template #body="{ data }">
          {{ data.student?.apprenant?.groupe?.nom || data.group?.name || '—' }}
        </template>
      </Column>
      <Column header="Week">
        <template #body="{ data }">
          {{ data.period?.period || data.week || '—' }}
        </template>
      </Column>
      
      <Column header="Submitted At">
        <template #body="{ data }">
          {{ data.created_at ? new Date(data.created_at).toLocaleString() : '—' }}
        </template>
      </Column>
    </DataTable>
  </div>
</template>