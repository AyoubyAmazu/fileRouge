<template>
  <div class="max-w-4xl mx-auto mt-14 bg-white rounded-3xl shadow-2xl p-12">
    <h2 class="text-3xl font-extrabold mb-10 text-blue-800 tracking-tight text-center">Modifier l'événement</h2>
    <form @submit.prevent="handleUpdate" class="space-y-10">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <label class="block text-base font-semibold mb-2 text-gray-700">Titre</label>
          <input v-model="event.titre" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block text-base font-semibold mb-2 text-gray-700">Date début</label>
          <input type="date" v-model="event.date_debut" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block text-base font-semibold mb-2 text-gray-700">Date fin</label>
          <input type="date" v-model="event.date_fin" :min="event.date_debut" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-blue-500 transition" />
        </div>
      </div>

      <div>
        <label class="block text-base font-semibold mb-2 text-gray-700">Description de l'événement</label>
        <textarea v-model="event.description" rows="3" placeholder="Description de l'événement"
          class="w-full border-2 border-blue-200 rounded-lg px-4 py-3 text-lg resize-none focus:outline-none focus:border-blue-500 transition"></textarea>
      </div>

      <div>
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-2xl font-bold text-gray-800">Jours de l'événement</h3>
          <button type="button" @click="addJour"
            class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white px-5 py-2 rounded-full shadow-lg hover:scale-105 transition">
            <i class="pi pi-plus text-lg"></i>
            <span class="font-semibold">Ajouter un jour</span>
          </button>
        </div>
        <div v-if="event.evenement_jours.length === 0" class="text-gray-400 text-base mb-4 text-center">Aucun jour ajouté.</div>
        <div v-for="(jour, idx) in event.evenement_jours" :key="jour.id ?? idx"
          class="relative border-2 border-blue-100 rounded-2xl p-6 mb-8 bg-blue-50 shadow-md hover:shadow-lg transition">
          <div class="flex items-center justify-between mb-4">
            <span class="font-bold text-blue-700 text-lg">Jour {{ idx + 1 }}</span>
            <button type="button" @click="removeJour(idx)"
              class="text-red-500 hover:text-red-700 bg-white rounded-full p-2 shadow">
              <i class="pi pi-trash text-xl"></i>
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
              <label class="block text-sm font-medium mb-1">Date</label>
              <input type="date" :min="event.date_debut" v-model="jour.date" class="w-full border rounded-lg px-3 py-2 text-base" />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Heure début</label>
              <input type="time" v-model="jour.heure_debut" class="w-full border rounded-lg px-3 py-2 text-base" />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Heure fin</label>
              <input type="time" v-model="jour.heure_fin" class="w-full border rounded-lg px-3 py-2 text-base" />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">À apporter (optionnel)</label>
              <input v-model="jour.apporter" placeholder="À apporter" class="w-full border rounded-lg px-3 py-2 text-base" />
            </div>
          </div>
          <div class="mt-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea v-model="jour.description" rows="2" placeholder="Description de la journée"
              class="w-full border rounded-lg px-3 py-2 text-base resize-none"></textarea>
          </div>
          <div class="flex items-center gap-8 mt-4">
            <label class="flex items-center gap-2 text-base font-medium">
              <input type="checkbox" v-model="jour.pause_dejeuner" class="accent-blue-600 w-5 h-5" />
              Pause déjeuner
            </label>
            <label class="flex items-center gap-2 text-base font-medium">
              <input type="checkbox" v-model="jour.pause_cafe" class="accent-blue-600 w-5 h-5" />
              Pause café
            </label>
          </div>
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit"
          class="bg-gradient-to-r from-green-500 to-green-700 text-white px-10 py-3 rounded-2xl text-xl font-bold shadow-lg hover:scale-105 transition">
          Mettre à jour
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getEventById, updateEvent } from '@/modules/Evenement.module/service/event.service.js';
import { useToast } from 'primevue/usetoast';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const event = ref({
    titre: '',
    date_debut: '',
    date_fin: '',
    description: '',
    evenement_jours: []
});

const fetchEvent = async () => {
    try {
        const res = await getEventById(route.params.id);

        event.value = {
            titre: res.data.titre || '',
            date_debut: res.data.date_debut || '',
            date_fin: res.data.date_fin || '',
            description: res.data.description || '',
            evenement_jours: Array.isArray(res.data.evenement_jours)
                ? res.data.evenement_jours.map(jour => ({
                    id: jour.id ?? null,
                    evenement_id: route.params.id || null,
                    date: jour.date || '',
                    heure_debut: jour.heure_debut || '',
                    heure_fin: jour.heure_fin || '',
                    pause_dejeuner: !!jour.pause_dejeuner,
                    pause_cafe: !!jour.pause_cafe,
                    apporter: jour.apporter || '',
                    description: jour.description || ''
                }))
                : []
        };
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Erreur', detail: 'Erreur lors du chargement', life: 3000 });
    }
};

const addJour = () => {


    event.value.evenement_jours.push({
        date: '',
        id: null,
        evenement_id: route.params.id || null,
        heure_debut: '',
        heure_fin: '',
        pause_dejeuner: false,
        pause_cafe: false,
        apporter: '',
        description: ''
    });
};

const removeJour = (idx) => {
    event.value.evenement_jours.splice(idx, 1);
};

const handleUpdate = async () => {
    try {

        await updateEvent(route.params.id, event.value);
        toast.add({ severity: 'success', summary: 'Succès', detail: 'Événement mis à jour', life: 3000 });
        router.push({ name: 'evenementDetail' , params: { id: route.params.id } });

    } catch (error) {

        console.log('Payload sent to backend:', event.value);
        console.log('Error updating event:', response.data.message);
        toast.add({ severity: 'error', summary: 'Erreur', detail: error , life: 3000 });
    }
};

onMounted(fetchEvent);
</script>

<style scoped>
</style>
