<script setup>
import StatsWidget from '@/modules/Evenement.module/components/dashboard/StatsWidget.vue';
import { ref, onMounted ,watch } from 'vue';
import { getCommunauteNumber } from '@/modules/Evenement.module/service/communaute.service';
import {getCounteMembers , getMembers} from '@/modules/Evenement.module/service/communauteMembers.service';
import {getEventCount , getEventsYears } from '@/modules/Evenement.module/service/event.service';

const CommunauteCount = ref(null);
const communauteMembersCount = ref(null);
const eventCount = ref(null);
const eventsYears = ref();
const members = ref();
const currentYear = ref(new Date().getFullYear());





const fetchCommunauteCount = async () => {
    try {
        const res = await getCommunauteNumber();
        CommunauteCount.value = res.data["count"];
    } catch (error) {
        console.error('Error fetching event scout count:', error);
    }
};
const CommunauteMemebrsCount = async (year=currentYear.value) => {
    try {
        const res = await getCounteMembers(year);
        communauteMembersCount.value = res.data["count"];
        console.log("Communaute Members Count:",  communauteMembersCount.value);    
    } catch (error) {
        console.error('Error fetching communaute members count:', error);
    }
}
const getEvents = async (year=null) => {
    try {
        const res = await getEventCount(year);
        eventCount.value = res.data["count"];
    } catch (error) {
        console.error('Error fetching communaute members count:', error);
    }
}
const EventsYears= async ()=> {
    try {
        const res = await getEventsYears();
        eventsYears.value = res.data;
        console.log("Events Years:", res.data);
    } catch (error) {
        console.error('Error fetching communaute members count:', error);
    }
};

const getmembers = async (year=currentYear.value) => {
    try {
        const res = await getMembers(year);
        members.value = res.data
        console.log("Members:",res.data);
    } catch (error) {
        console.error('Error fetching communaute members count:', error);
    }
};


onMounted(async () => {
    fetchCommunauteCount();
    CommunauteMemebrsCount();
    getEvents();
    EventsYears();
    getmembers();

});

const selectedYear = ref('');
watch(selectedYear, (newYear) => {
    console.log( newYear);
    fetchCommunauteCount(newYear);
    CommunauteMemebrsCount(newYear);
    getEvents(newYear);
    getmembers(newYear);
});


</script>

<template>
    <div v-if="members" >
        <label>Promotion</label>
        <select v-model="selectedYear" class="border px-2 py-1 rounded ml-2">
            <option value="" disabled selected>Choisir une promotion</option>
            <option v-for="year in eventsYears" :key="year" :value="year">
                {{ year }}
            </option>
        </select>
        <div class="grid grid-cols-10 gap-8 mt-4 mb-6">
            <StatsWidget title="Comunicate Total"
            icon-class="pi pi-user text-blue-500 !text-xl"
            :fetchCount="CommunauteCount"

            />
            <StatsWidget title="Comunicate Members Total"
            icon-class="pi pi-users text-blue-500 !text-xl"
            :fetchCount="communauteMembersCount"

            />
            <StatsWidget title="Events Total"
            icon-class="pi pi-calendar-clock text-blue-500 !text-xl"
            :fetchCount="eventCount"

            />

        </div>
       <div>
        <!-- ...existing widgets and controls... -->

        <div class="card mt-8">
            <h4 class="mb-4">Liste des membres</h4>
            <DataTable
                :value="members"
                dataKey="id"
                :paginator="true"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Affichage {first} à {last} sur {totalRecords} membres"
            >
                <Column field="apprenant.user.name" header="Nom">
                    <template #body="slotProps">
                        {{ slotProps.data.apprenant?.user?.name }}
                    </template>
                </Column>
                <Column field="apprenant.user.email" header="Email">
                    <template #body="slotProps">
                        {{ slotProps.data.apprenant?.user?.email }}
                    </template>
                </Column>
                <Column field="communaute.nom" header="Communauté">
                    <template #body="slotProps">
                        {{ slotProps.data.communaute?.nom }}
                    </template>
                </Column>
                <Column field="created_at" header="Date d'ajout">
                    <template #body="slotProps">
                        {{ new Date(slotProps.data.created_at).toLocaleDateString() }}
                    </template>
                </Column>
            </DataTable>
        </div>


    </div>
    </div>
    <div v-else class="loading">
        <div class="spinner"></div>
        <span>Chargement...</span>
    </div>
</template>

<style scoped>      
.loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 4rem;
    color: #3f51b5;
    font-size: 1.2rem;
}
.spinner {
    border: 4px solid #e3e9f7;
    border-top: 4px solid #3f51b5;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
}
@keyframes spin {
    0% { transform: rotate(0deg);}
    100% { transform: rotate(360deg);}
}



</style>
