/ Main Dashboard Component
<script setup>
import StatsWidget from '@/modules/EntretienIndividuel.module/components/dashboard/StatsWidget.vue';
import StudentCheckinPeriodWidget from '@/modules/EntretienIndividuel.module/components/dashboard/StudentCheckinPeriodWidget.vue';
import RecentStudentCheckins from '@/modules/EntretienIndividuel.module/components/dashboard/RecentStudentCheckins.vue';
import { ref, onMounted } from 'vue';
import { 
  getSTodayStudentCheckinCount, 
  getAvgCheckinsPerPeriod,
  getStudentCheckinPeriods,  // ADD THIS IMPORT
  getRecentStudentCheckins   // ADD THIS IMPORT
} from '@/modules/EntretienIndividuel.module/service/StudentCheckin.service';
import { getStudents } from '@/modules/EntretienIndividuel.module/service/Student.service';
import { getPromotions } from '@/modules/EntretienIndividuel.module/service/Promotion.service';

// stats state
const todayCheckins = ref(0);
const avgCheckins = ref(0);
const students = ref(0);

// promotions filter state
const promotions = ref([]);
const selectedPromotion = ref(null);

onMounted(async () => {
  try {
    // Load stats
    const todayRes = await getSTodayStudentCheckinCount();
    todayCheckins.value = todayRes.data;

    const avgRes = await getAvgCheckinsPerPeriod();
    avgCheckins.value = parseFloat(avgRes.data).toFixed(1);

    const studentsRes = await getStudents();
    students.value = studentsRes.data.length;

    // Load promotions for filter
    const promotionsRes = await getPromotions();
    promotions.value = promotionsRes.data;
    
    // Default select first promotion
    if (!selectedPromotion.value && promotionsRes.data.length) {
      selectedPromotion.value = promotionsRes.data[0].id;
    }
  } catch (error) {
    console.error('Error loading dashboard data:', error);
  }
});
</script>

<template>
  <div>


    <div class="grid grid-cols-12 gap-4 mt-4">
      <StatsWidget
        title="Student Check-ins"
        mini-title="Today"
        icon-class="pi pi-check-circle text-green-500 !text-xl"
        :count="todayCheckins"
      />
      <StatsWidget
        title="Avg Check-ins"
        mini-title="Per Period"
        icon-class="pi pi-percentage text-yellow-500 !text-xl"
        :count="avgCheckins"
      />
      <StatsWidget
        title="Students"
        mini-title="Total"
        icon-class="pi pi-user text-blue-500 !text-xl"
        :count="students"
      />
    </div>
    <label class="block mb-2 font-medium">Promotion</label>
    <select v-model="selectedPromotion" class="border rounded px-3 py-2 mb-4 w-48">
      <option disabled value="">Select a promotion</option>
      <option v-for="promo in promotions" :key="promo.id" :value="promo.id">
        {{ promo.year }}
      </option>
    </select>
    
    <div class="grid grid-cols-12 gap-4 mt-4">
      <div class="col-span-12 lg:col-span-6">
        <StudentCheckinPeriodWidget :promotion-id="selectedPromotion" />
      </div>
      <div class="col-span-12 lg:col-span-6">
        <RecentStudentCheckins :promotion-id="selectedPromotion" />
      </div>
    </div>
  </div>
</template>