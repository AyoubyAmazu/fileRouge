<script>

import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { getEventById } from '@/modules/Evenement.module/service/event.service.js';

const eventData = ref(null);


export default {
     name: "EvenementDetail",
    data() {
        return {
            event: null,
        };
    },
    async created() {
        const eventId = this.$route.params.id;
        await this.fetchEvent(eventId);
    },
    methods: {
        async fetchEvent(id) {
            try {
                const response = await getEventById(id); // Call your real API
                this.event = response.data; // Adjust according to your API response
                console.log('Event fetched:', this.event);
            } catch (error) {
                console.error('Error fetching event:', error);
            }
        },
        formatDate(dateStr) {
            const options = { year: "numeric", month: "short", day: "numeric" };
            return new Date(dateStr).toLocaleDateString("fr-FR", options);
        },
        getDayName(dateStr) {
            const options = { weekday: "short" };
            return new Date(dateStr).toLocaleDateString("fr-FR", options);
        },
    },
};
</script>
<template>
    <div class="evenement-detail" v-if="event">
        <div class="header">
            <h2>{{ event.titre }}</h2>
        </div>
        <div
            v-for="(jour, idx) in event.jours"
            :key="idx"
            class="jour-card"
        >
            <div class="jour-label">Jour {{ idx + 1 }}</div>
            <div class="jour-header">
                <div class="date-block">
                    <span class="date">{{ formatDate(jour.date) }}</span>
                    <span class="day">{{ getDayName(jour.date) }}</span>
                </div>
                <span class="time">
                    <i class="fa fa-clock-o"></i>
                    {{ jour.heure_debut }} - {{ jour.heure_fin }}
                </span>
            </div>
            <div class="jour-info">
                <span :class="['badge', jour.pause_dejeuner ? 'yes' : 'no']">
                    <i class="fa fa-coffee"></i>
                    Petit dej: <b>{{ jour.pause_dejeuner ? 'Oui' : 'Non' }}</b>
                </span>
                <span :class="['badge', jour.pause_cafe ? 'yes' : 'no']">
                    <i class="fa fa-mug-hot"></i>
                    Pause café: <b>{{ jour.pause_cafe  ? 'Oui' : 'Non' }}</b>
                </span>
                <span v-if="jour.apporter" class="badge apporter">
                    <i class="fa fa-gift"></i>
                    Apporter: <b>{{ jour.apporter }}</b>
                </span>
            </div>
            <div class="desc">
                {{ jour.description }}
            </div>
        </div>
    </div>
    <div v-else class="loading">
        <div class="spinner"></div>
        <span>Chargement...</span>
    </div>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

.evenement-detail {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(44, 62, 80, 0.07);
    margin: 2rem 0 0 0;
    padding: 2rem 2.5rem;
    min-width: 320px;
    width: 100%;
    font-family: 'Segoe UI', Arial, sans-serif;
    color: #263238;
    animation: fadeIn 0.5s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px);}
    to { opacity: 1; transform: translateY(0);}
}

.header {
    border-bottom: 2px solid #e3e9f7;
    margin-bottom: 1.5rem;
    padding-bottom: 0.7rem;
    text-align: left;
}

.header h2 {
    color: #3f51b5;
    font-size: 2rem;
    font-weight: 600;
    margin: 0;
    letter-spacing: 1px;
}

.jour-card {
    background: #f7f9fc;
    border-radius: 14px;
    margin-bottom: 2rem;
    padding: 1.7rem 2.2rem;
    box-shadow: 0 2px 10px rgba(63,81,181,0.09);
    border-left: 8px solid #3f51b5;
    position: relative;
    transition: background 0.2s, border-color 0.2s;
}
/* Remove .jour-card.odd and .jour-card.odd .jour-label for same color */

.jour-label {
    position: absolute;
    top: -18px;
    left: 18px;
    background: #fff;
    color: #3f51b5;
    font-weight: bold;
    font-size: 1.05rem;
    padding: 2px 14px;
    border-radius: 8px;
    box-shadow: 0 2px 8px #e3e9f7;
    z-index: 2;
}

.jour-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.7rem;
}

.date-block {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.date {
    font-size: 1.1rem;
    color: #fff;
    background: #3f51b5;
    padding: 0.2rem 0.8rem;
    border-radius: 8px 8px 0 0;
    font-weight: 500;
    margin-bottom: 2px;
}

.day {
    font-size: 0.98rem;
    color: #3f51b5;
    background: #e3e9f7;
    padding: 0.1rem 0.7rem;
    border-radius: 0 0 8px 8px;
}

.time {
    font-size: 1.05rem;
    color: #555;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    background: #e3e9f7;
    padding: 0.2rem 0.8rem;
    border-radius: 8px;
}

.time .fa {
    color: #3f51b5;
}

.jour-info {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.7rem;
}

.badge {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.18rem 0.7rem;
    border-radius: 8px;
    font-size: 0.98rem;
    font-weight: 500;
    background: #e3e9f7;
    border: 1px solid #e3e9f7;
}

.badge .fa {
    font-size: 1em;
}

.badge.yes {
    background: #e8f5e9;
    color: #388e3c;
    border: 1px solid #b2dfdb;
}
.badge.no {
    background: #ffebee;
    color: #c62828;
    border: 1px solid #ffcdd2;
}
.badge.apporter {
    background: #fffde7;
    color: #f59e42;
    border: 1px solid #ffe082;
}

.desc {
    margin: 0;
    color: #555;
    line-height: 1.6;
    font-size: 1.04rem;
    background: #fff;
    border-radius: 6px;
    padding: 0.6rem 1rem;
    box-shadow: 0 1px 4px #e3e9f7;
}

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
