<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <!-- Indicateur de chargement -->
    <div v-if="!event" class="flex flex-col items-center justify-center py-16">
      <div class="relative">
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200 border-t-blue-600"></div>
        <div class="absolute inset-0 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
            <line x1="16" x2="16" y1="2" y2="6"/>
            <line x1="8" x2="8" y1="2" y2="6"/>
            <line x1="3" x2="21" y1="10" y2="10"/>
          </svg>
        </div>
      </div>
      <p class="text-gray-700 text-lg font-medium mt-4">Chargement de l'événement...</p>
      <p class="text-gray-500 text-sm mt-2">Récupération des détails en cours</p>
    </div>

    <!-- Contenu principal -->
    <div v-else class="container mx-auto max-w-6xl">
      <!-- Bouton retour -->
      <div class="mb-6">
        <button 
          @click="$router.go(-1)"
          class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
          </svg>
          <span class="font-medium">Retour à la liste</span>
        </button>
      </div>

      <!-- En-tête de l'événement -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
          <div class="flex-1">
            <div class="flex items-center gap-4 mb-4">
              <div class="h-16 w-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                  <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                  <line x1="16" x2="16" y1="2" y2="6"/>
                  <line x1="8" x2="8" y1="2" y2="6"/>
                  <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
              </div>
              <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ event.titre }}</h1>
                <div class="flex items-center gap-2 text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 2v4"/>
                    <path d="M16 2v4"/>
                    <rect width="18" height="18" x="3" y="4" rx="2"/>
                    <path d="M3 10h18"/>
                  </svg>
                  <span class="font-medium">{{ formatEventDate() }}</span>
                </div>
              </div>
            </div>

            <!-- Informations principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Durée -->
              <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl">
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12,6 12,12 16,14"/>
                  </svg>
                </div>
                <div>
                  <div class="font-semibold text-gray-900">{{ getEventDuration() }}</div>
                  <div class="text-sm text-gray-600">Durée de l'événement</div>
                </div>
              </div>

              <!-- Lieu -->
              <div class="flex items-center gap-3 p-4 bg-green-50 rounded-xl">
                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                    <circle cx="12" cy="10" r="3"/>
                  </svg>
                </div>
                <div>
                  <div class="font-semibold text-gray-900">{{ event.lieu }}</div>
                  <div class="text-sm text-gray-600">Lieu de l'événement</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex flex-col gap-3">
            <button 
              @click="goToUpdate"
              class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                <path d="m15 5 4 4"/>
              </svg>
              Modifier l'événement
            </button>
            
            <button class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-xl font-medium transition-colors flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7,10 12,15 17,10"/>
                <line x1="12" x2="12" y1="15" y2="3"/>
              </svg>
              Exporter
            </button>
          </div>
        </div>

        <!-- Description -->
        <div v-if="event.description" class="mt-6 pt-6 border-t border-gray-100">
          <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
            <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                <circle cx="12" cy="12" r="10"/>
                <path d="m9 12 2 2 4-4"/>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
              <p class="text-gray-700 leading-relaxed">{{ event.description }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Section des jours -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-3 mb-6">
          <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
              <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
              <line x1="16" x2="16" y1="2" y2="6"/>
              <line x1="8" x2="8" y1="2" y2="6"/>
              <line x1="3" x2="21" y1="10" y2="10"/>
              <path d="M8 14h.01"/>
              <path d="M12 14h.01"/>
              <path d="M16 14h.01"/>
            </svg>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Programme détaillé</h2>
            <p class="text-gray-600">{{ event.evenement_jours?.length || 0 }} jour(s) planifié(s)</p>
          </div>
        </div>

        <!-- Liste des jours -->
        <div v-if="event.evenement_jours && event.evenement_jours.length" class="space-y-6">
          <div 
            v-for="(jour, index) in event.evenement_jours" 
            :key="index"
            class="border border-gray-200 rounded-2xl p-6 hover:shadow-md transition-shadow duration-200"
          >
            <!-- En-tête du jour -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
                  <span class="text-white font-bold text-lg">{{ index + 1 }}</span>
                </div>
                <div>
                  <h3 class="text-xl font-semibold text-gray-900">{{ getDayName(jour.date) }}</h3>
                  <p class="text-gray-600">{{ formatDate(jour.date) }}</p>
                </div>
              </div>
              
              <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                  <circle cx="12" cy="12" r="10"/>
                  <polyline points="12,6 12,12 16,14"/>
                </svg>
                <span class="font-semibold text-blue-900">{{ jour.heure_debut }} - {{ jour.heure_fin }}</span>
              </div>
            </div>

            <!-- Badges des services -->
            <div class="flex flex-wrap gap-3 mb-4">
              <div :class="[
                'flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium',
                jour.pause_dejeuner 
                  ? 'bg-green-100 text-green-800 border border-green-200' 
                  : 'bg-red-100 text-red-800 border border-red-200'
              ]">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                  <path d="M7 2v20"/>
                  <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                </svg>
                <span>Déjeuner: {{ jour.pause_dejeuner ? 'Inclus' : 'Non inclus' }}</span>
              </div>

              <div :class="[
                'flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium',
                jour.pause_cafe 
                  ? 'bg-amber-100 text-amber-800 border border-amber-200' 
                  : 'bg-gray-100 text-gray-800 border border-gray-200'
              ]">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M10 2v2a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2"/>
                  <path d="M22 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2"/>
                  <path d="M6 8h12"/>
                  <path d="M6 12h12"/>
                  <path d="M6 16h12"/>
                </svg>
                <span>Pause café: {{ jour.pause_cafe ? 'Incluse' : 'Non incluse' }}</span>
              </div>

              <div v-if="jour.apporter" class="flex items-center gap-2 px-3 py-2 bg-purple-100 text-purple-800 border border-purple-200 rounded-lg text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="8" width="18" height="4" rx="1"/>
                  <path d="m12 8-2-4h4l-2 4"/>
                  <path d="m8 12-2 4h12l-2-4"/>
                </svg>
                <span>À apporter: {{ jour.apporter }}</span>
              </div>
            </div>

            <!-- Description du jour -->
            <div v-if="jour.description" class="bg-gray-50 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <div class="h-8 w-8 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                  </svg>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 mb-1">Description de la journée</h4>
                  <p class="text-gray-700 leading-relaxed">{{ jour.description }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- État vide -->
        <div v-else class="text-center py-12">
          <div class="h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
              <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
              <line x1="16" x2="16" y1="2" y2="6"/>
              <line x1="8" x2="8" y1="2" y2="6"/>
              <line x1="3" x2="21" y1="10" y2="10"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun jour planifié</h3>
          <p class="text-gray-500 mb-6">Commencez par ajouter des jours à votre événement</p>
          <button 
            @click="goToUpdate"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors"
          >
            Ajouter des jours
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getEventById } from '@/modules/Evenement.module/service/event.service.js'

const route = useRoute()
const router = useRouter()
const event = ref(null)

const fetchEvent = async (id) => {
  try {
    const response = await getEventById(id)
    event.value = response.data
  } catch (error) {
    console.error('Error fetching event:', error)
  }
}

const formatDate = (dateStr) => {
  const options = { year: "numeric", month: "long", day: "numeric" }
  return new Date(dateStr).toLocaleDateString("fr-FR", options)
}

const getDayName = (dateStr) => {
  const options = { weekday: "long" }
  return new Date(dateStr).toLocaleDateString("fr-FR", options)
}

const formatEventDate = () => {
  if (!event.value) return ''
  
  const startDate = new Date(event.value.date_debut)
  const endDate = new Date(event.value.date_fin)
  
  if (event.value.date_debut === event.value.date_fin) {
    return startDate.toLocaleDateString('fr-FR', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  } else {
    return `Du ${startDate.toLocaleDateString('fr-FR')} au ${endDate.toLocaleDateString('fr-FR')}`
  }
}

const getEventDuration = () => {
  if (!event.value) return ''
  
  const startDate = new Date(event.value.date_debut)
  const endDate = new Date(event.value.date_fin)
  const diffTime = Math.abs(endDate - startDate)
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1
  
  if (diffDays === 1) {
    return "1 jour"
  } else {
    return `${diffDays} jours`
  }
}

const goToUpdate = () => {
  router.push(`/evenements/update/${event.value.id}`)
}

onMounted(() => {
  const eventId = route.params.id
  fetchEvent(eventId)
})
</script>

<style scoped>
/* Animation pour le spinner */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Transitions fluides */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>
