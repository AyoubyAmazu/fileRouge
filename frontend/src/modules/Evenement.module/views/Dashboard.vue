<script setup>
import StatsWidget from '@/modules/Evenement.module/components/dashboard/StatsWidget.vue';
import { ref, onMounted } from 'vue';
import { getCommauteNumber } from '@/modules/Evenement.module/service/communaute.service';

const eventscout = ref(null);
const fetchEventScoutCount = async () => {
    try {
        const res = await getCommauteNumber();
        eventscout.value = res.data;
    } catch (error) {
        console.error('Error fetching event scout count:', error);
    }
};
onMounted(async () => {
    fetchEventScoutCount();

});
</script>

<template>
    <div>
        <label>Promotion</label>
        <!-- <select v-model="selectedPromotion" class="border px-2 py-1 rounded">
            <option v-for="promo in promotions" :key="promo.id" :value="promo.annee_promotion">
                {{ promo.annee_promotion }}
            </option>
        </select> -->
        <div class="grid grid-cols-12 gap-4 mt-4">
            <StatsWidget title="Comunicate Total"
            icon-class="pi pi-user text-blue-500 !text-xl"
            :fetchCount="eventscout"

            />
            <StatsWidget title="Comunicate Total"
            icon-class="pi pi-user text-blue-500 !text-xl"
            :fetchCount="eventscout"

            />

        </div>
    </div>
</template>
