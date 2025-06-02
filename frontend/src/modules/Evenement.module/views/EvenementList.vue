<template>
    <div class="events-container">
        <h1 class="title">Liste des Événements</h1>
        <div class="flex justify-between items-center mb-4">
        <button class="add-btn" @click="ajouterEvent()">
            <i class="fa fa-plus"></i>
            <span>Ajouter un événement</span>
        </button>
       <div class="filter-bar">
            <label for="year-select" class="filter-label">
                <i class="fa fa-filter"></i> Filtrer par année :
            </label>
            <select id="year-select" v-model="selectedYear" class="filter-select">
                <option value="">Toutes les années</option>
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>
        </div>
        </div>
        <!-- Single event list with pagination -->
        <ul class="event-list">
            <li v-for="event in paginatedEvents" :key="event.id" class="event-card">
            <div class="event-header">
                <span class="event-name">{{ event.titre }}</span>
                <span class="event-date">
                    <i class="fa fa-calendar"></i>
                    {{ event.date_debut }} <span v-if="event.date_fin && event.date_fin !== event.date_debut">- {{ event.date_fin }}</span>
                </span>
                <div >
                    <button class="detail-btn" @click="showDetails(event)">
                        <i class="fa fa-info-circle"></i>
                        <span class="small">Détails</span>
                    </button>
                    <button class="delete-btn" @click="deleteEvent(event.id)">
                        <i class="fa fa-trash"></i>
                        <span class="small">Supprimer</span>
                    </button>
                </div>
            </div>
            <div class="event-details">
                <span class="event-place">
                <i class="fa fa-map-marker"></i> {{ event.lieu }}
                </span>
            </div>
            <div class="event-description" style="color: #444; font-size: 0.96rem; margin-top: 4px;">
                <i class="fa fa-align-left" style="margin-right: 4px; color: #6366f1;"></i>
                {{ event.description }}
            </div>
            </li>
        </ul>
        <!-- Smooth icon-only pagination controls -->
        <div class="pagination" style="margin: 16px 0; display: flex; gap: 8px; justify-content: center;">
            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" aria-label="Précédent">
                <i class="fa fa-chevron-left"></i>
            </button>
            <span class="pagination-numbers">
                <button
                    v-for="page in totalPages"
                    :key="page"
                    :class="['page-btn', { active: page === currentPage }]"
                    @click="goToPage(page)"
                >
                    {{ page }}
                </button>
            </span>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" aria-label="Suivant">
                <i class="fa fa-chevron-right"></i>
            </button>
        </div>
    </div>
</template>

<script setup>

import { useRouter } from 'vue-router'
import { ref, onMounted, computed , watch } from 'vue'
import {getEvents , getEventsYears } from '@/modules/Evenement.module/service/event.service.js'


const router = useRouter()
const events = ref([])
const showForm = ref(false)
const selectedYear = ref('')
const years = ref([])
const currentPage = ref(1)
const pageSize = ref(4) // Number of events per page


const EventsList = async (year=null)=>
{
    try {
        const res = await getEvents(year)
        events.value = res.data
    } catch (error) {
        console.log(error)
    }
}
const EventsYears = async ()=> {
    try {
        const res = await getEventsYears();
        years.value = res.data;
        console.log("Events Years:", res.data);
    } catch (error) {
        console.error('Error fetching communaute members count:', error);
    }
};
const filteredEvents = computed(() => {
    if (!selectedYear.value) return events.value;
    return events.value.filter(ev => String(ev.date_debut).startsWith(selectedYear.value));
});

const paginatedEvents = computed(() => {
    const start = (currentPage.value - 1) * pageSize.value;
    return filteredEvents.value.slice(start, start + pageSize.value);
});

const totalPages = computed(() => {
    return Math.ceil(filteredEvents.value.length / pageSize.value) || 1;
});

watch(selectedYear, () => {
    currentPage.value = 1;
});
function goToPage(page) {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}

function ajouterEvent() {
router.push({ name: 'evenementCreation'});
}
function showDetails(event) {
router.push({ name: 'evenementDetail', params: { id: event.id } })
}

onMounted(() => {
    EventsList(2024);
    EventsYears();
   
})

</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

.add-btn, .detail-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    outline: none;
    font-weight: 600;
    transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
    box-shadow: 0 2px 8px rgba(99,102,241,0.08);
    cursor: pointer;
    user-select: none;
}

.add-btn {
    margin-bottom: 18px;
    background: linear-gradient(90deg, #6366f1 60%, #818cf8 100%);
    color: #fff;
    padding: 10px 22px;
    border-radius: 6px;
    font-size: 1.05rem;
    letter-spacing: 0.2px;
}
.add-btn:hover, .add-btn:focus {
    background: linear-gradient(90deg, #4f46e5 60%, #6366f1 100%);
    box-shadow: 0 4px 16px rgba(99,102,241,0.18);
    transform: translateY(-2px) scale(1.03);
}

.delete-btn {
    background: linear-gradient(90deg, #e53935 60%, #ff7043 100%);
    color: #fff;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 1rem;
    letter-spacing: 0.1px;
    margin-top: 10px;
    margin-left: 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
    box-shadow: 0 2px 8px rgba(229,57,53,0.08);
}
.delete-btn:hover, .delete-btn:focus {
    background: linear-gradient(90deg, #b71c1c 60%, #e53935 100%);
    box-shadow: 0 4px 16px rgba(229,57,53,0.15);
    transform: translateY(-2px) scale(1.03);
}

.detail-btn {
    background: linear-gradient(90deg, #f59e42 60%, #fbbf24 100%);
    color: #fff;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 1rem;
    letter-spacing: 0.1px;
    margin-top: 10px;
}
.detail-btn:hover, .detail-btn:focus {
    background: linear-gradient(90deg, #ea580c 60%, #f59e42 100%);
    box-shadow: 0 4px 16px rgba(245,158,66,0.15);
    transform: translateY(-2px) scale(1.03);
}

/* Small variant for detail button */
.detail-btn.small {
    padding: 4px 8px;
    font-size: 0.85rem;
    border-radius: 4px;
    margin-top: 0;
    margin-left: 10px;
    min-width: 28px;
    min-height: 28px;
    height: 28px;
    width: 28px;
    justify-content: center;
    gap: 0;
}
.detail-btn.small span {
    display: none;
}

.events-container {
    padding: 0 16px;
    background: #fff;
    box-shadow: none;
    max-width: 100%;
}

.title {
    text-align: left;
    color: #222;
    margin-bottom: 18px;
    font-size: 1.4rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.event-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.event-card {
    background: transparent;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 0;
    padding: 14px 0;
    box-shadow: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: background 0.2s;
}

.event-card:last-child {
    border-bottom: none;
}

.event-card:hover {
    background: #f3f4f6;
}

.event-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.event-name {
    font-size: 1rem;
    font-weight: 500;
    color: #222;
}

.event-date {
    color: #6366f1;
    font-size: 0.98rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.event-details {
    display: flex;
    gap: 18px;
    color: #555;
    font-size: 0.95rem;
}

.event-place, .event-time {
    display: flex;
    align-items: center;
    gap: 4px;
}

.pagination {
    margin: 16px 0;
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}
.pagination button {
    padding: 6px 10px;
    border: none;
    background: transparent;
    color: #6366f1;
    border-radius: 50%;
    cursor: pointer;
    font-weight: 500;
    font-size: 1.1rem;
    transition: background 0.2s, color 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pagination button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    background: none;
}
.pagination .page-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: transparent;
    color: #6366f1;
    border: none;
    margin: 0 2px;
    font-size: 1rem;
    transition: background 0.2s, color 0.2s;
}
.pagination .page-btn.active,
.pagination .page-btn:hover {
    background: #6366f1;
    color: #fff;
}
.pagination-numbers {
    display: flex;
    gap: 2px;
}

.filter-bar {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #f7f9fc;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(99,102,241,0.07);
    padding: 12px 20px;
    margin-bottom: 22px;
    margin-left: auto;
    margin-right: 0;
    width: fit-content;
}

.filter-label {
    font-weight: 600;
    color: #3f51b5;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    gap: 7px;
}

.filter-select {
    border: 1.5px solid #cfd8dc;
    border-radius: 7px;
    padding: 7px 16px;
    font-size: 1.05rem;
    background: #fff;
    color: #283593;
    transition: border 0.2s, box-shadow 0.2s;
    outline: none;
}
.filter-select:focus {
    border-color: #6366f1;
    box-shadow: 0 2px 8px #e3e9f7;
}
</style>
