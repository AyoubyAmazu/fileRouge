<script setup>
import StatsWidget from '@/modules/EntretienIndividuel.module/components/dashboard/StatsWidget.vue';
import { ref, onMounted } from 'vue';
import { getPromotions } from '@/modules/EntretienIndividuel.module/service/groupe.service';
import { getInterviewCountByPromotion } from '@/modules/EntretienIndividuel.module/service/entretient.service';
import { getPreEntretiensByPromotion } from '@/modules/EntretienIndividuel.module/service/pre-entretient.service';

const promotions = ref([]);
const selectedPromotion = ref('');

const fetchPromotions = async () => {
  const res = await getPromotions();
  const data = res.data.data;
  const uniqueMap = new Map();
  data.forEach(item => {
    if (!uniqueMap.has(item.annee_promotion)) {
      uniqueMap.set(item.annee_promotion, item);
    }
  });
  promotions.value = Array.from(uniqueMap.values());

  if (promotions.value.length) {
    selectedPromotion.value = promotions.value[0].annee_promotion;
  }
};

onMounted(fetchPromotions);
</script>

<template>
  <div>
    <label>Promotion</label>
    <select v-model="selectedPromotion" class="border px-2 py-1 rounded">
      <option v-for="promo in promotions" :key="promo.id" :value="promo.annee_promotion">
        {{ promo.annee_promotion }}
      </option>
    </select>

    <div class="grid grid-cols-12 gap-4 mt-4">
      <StatsWidget
        title="Interviews Total"
        icon-class="pi pi-user text-blue-500 !text-xl"
        :promotion="selectedPromotion"
        :fetchCount="getInterviewCountByPromotion"
      />
      <StatsWidget
        title="Submitted Forms"
        icon-class="pi pi-file text-yellow-500 !text-xl"
        :promotion="selectedPromotion"
        :fetchCount="getPreEntretiensByPromotion"
      />
    </div>
  </div>
</template>
