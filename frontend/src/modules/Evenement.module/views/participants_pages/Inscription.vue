<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="max-w-6xl mx-auto">
      <!-- Event Selection View (when no eventId in URL) -->
      <div v-if="!eventIdFromUrl">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="flex items-center justify-center gap-3 mb-4">
            <div class="p-3 bg-blue-600 rounded-full">
              <Calendar class="h-8 w-8 text-white" />
            </div>
            <h1 class="text-4xl font-bold text-gray-900">Ajouter des Participants</h1>
          </div>
          <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Sélectionnez un événement pour ajouter des participants
          </p>
        </div>

        <!-- Events List -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-if="isLoadingEvents" v-for="i in 6" :key="i" class="bg-white rounded-lg shadow-lg">
            <div class="p-6">
              <div class="h-6 bg-gray-200 rounded animate-pulse mb-4"></div>
              <div class="h-4 bg-gray-200 rounded animate-pulse mb-2"></div>
              <div class="h-4 bg-gray-200 rounded animate-pulse w-3/4 mb-4"></div>
              <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
            </div>
          </div>

          <div
            v-else
            v-for="event in events"
            :key="event.id"
            class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow cursor-pointer"
            @click="selectEvent(event.id)"
          >
            <div class="p-6">
              <div class="flex items-start justify-between mb-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                  <Calendar class="h-6 w-6 text-blue-600" />
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                  {{ event.inscription.length }} participants
                </span>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ event.titre }}</h3>
              <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ event.description }}</p>

              <div class="space-y-2 text-sm text-gray-500 mb-4">
                <div class="flex items-center gap-2">
                  <Clock class="h-4 w-4" />
                  <span>{{ formatDate(event.date_debut) }} </span>
                </div>
                <div class="flex items-center gap-2">
                  <MapPin class="h-4 w-4" />
                  <span>{{ event.lieu }}</span>
                </div>
              </div>

              <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center justify-center gap-2">
                <UserPlus class="h-4 w-4" />
                Ajouter des participants
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Participant Addition Form (when eventId in URL) -->
      <div v-else>
        <!-- Header with Navigation -->
        <div class="mb-8">
          <div class="flex items-center justify-between mb-6">
            <button
              @click="goBackToEventsList"
              class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors"
            >
              <ArrowLeft class="h-4 w-4" />
              Retour à la liste des événements
            </button>

            <!-- Event Switcher Dropdown -->
            <div class="flex items-center gap-3">
              <span class="text-sm font-medium text-gray-700">Changer d'événement:</span>
              <select
                :value="eventIdFromUrl"
                @change="switchEvent($event.target.value)"
                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
              >
                <option v-for="event in events" :key="event.id" :value="event.id.toString()">
                  {{ event.titre }}
                </option>
              </select>
            </div>
          </div>

          <div class="text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
              <div class="p-3 bg-blue-600 rounded-full">
                <Calendar class="h-8 w-8 text-white" />
              </div>
              <h1 class="text-4xl font-bold text-gray-900">Ajouter des Participants</h1>
            </div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
              Ajoutez plusieurs participants à l'événement sélectionné
            </p>
          </div>
        </div>

        <!-- Event Info Card -->
        <div v-if="selectedEventData && !isLoadingEvents" class="bg-white shadow-lg rounded-lg mb-8">
          <div class="bg-blue-600 text-white p-6 rounded-t-lg">
            <div class="flex items-center justify-between">
              <div>
                <h2 class="text-xl font-semibold flex items-center gap-2">
                  <Calendar class="h-5 w-5" />
                  {{ selectedEventData.titre }}
                </h2>
                <p class="text-blue-100 mt-1">{{ selectedEventData.description }}</p>
              </div>
              <div class="text-right">
                <div class="text-2xl font-bold">{{ selectedEventData.inscription.length }}</div>
                <div class="text-sm text-blue-200">participants actuels</div>
              </div>
            </div>
          </div>
          <div class="p-6">
            <div class="grid md:grid-cols-4 gap-4">
              <div class="flex items-center gap-2">
                <Calendar class="h-4 w-4 text-gray-500" />
                <span class="text-sm">{{ formatDate(selectedEventData.date_debut) }}</span>
              </div>
              <div class="flex items-center gap-2">
                <MapPin class="h-4 w-4 text-gray-500" />
                <span class="text-sm">{{ selectedEventData.lieu }}</span>
              </div>
              <div class="flex items-center gap-2">
                <Users class="h-4 w-4 text-gray-500" />
                <span class="text-sm">{{ selectedEventData.inscription.length}} participants</span>
              </div>

            </div>
          </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
          <!-- Main Form -->
          <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-lg">
              <div class="p-6 border-b">
                <h2 class="text-xl font-semibold flex items-center gap-2">
                  <UserPlus class="h-5 w-5" />
                  Ajouter des Participants
                </h2>
                <p class="text-gray-600 mt-1">Sélectionnez les apprenants à ajouter à l'événement</p>
              </div>
              <div class="p-6">
                <!-- Apprenants Selection -->
                <div class="space-y-6">
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <div class="space-y-2 flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700">Rechercher des apprenants</label>
                        <div class="relative">
                          <Search class="absolute left-3 top-3 h-4 w-4 text-gray-400" />
                          <input
                            id="search"
                            v-model="searchTerm"
                            type="text"
                            placeholder="Tapez le nom, email ou groupe..."
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          />
                        </div>
                      </div>
                      <div class="ml-4 text-right">
                        <p class="text-sm font-medium text-blue-600">
                          {{ selectedApprenants.length }} sélectionné(s)
                        </p>
                        <button
                          v-if="selectedApprenants.length > 0"
                          @click="selectedApprenants = []"
                          class="text-xs text-gray-500 hover:text-gray-700"
                        >
                          Tout désélectionner
                        </button>
                      </div>
                    </div>

                    <div class="space-y-2">
                      <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Apprenants disponibles</label>
                        <button
                          @click="selectAllApprenants"
                          class="text-sm text-blue-600 hover:text-blue-700"
                        >
                          Tout sélectionner
                        </button>
                      </div>

                      <!-- Loading State -->
                      <div v-if="isLoadingApprenants" class="max-h-64 overflow-y-auto space-y-2 border rounded-lg p-2">
                        <div v-for="i in 5" :key="i" class="flex items-center gap-3 p-3 border rounded-lg">
                          <div class="h-4 w-4 bg-gray-200 rounded animate-pulse"></div>
                          <div class="h-10 w-10 bg-gray-200 rounded-full animate-pulse"></div>
                          <div class="flex-1 space-y-2">
                            <div class="h-4 bg-gray-200 rounded animate-pulse w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded animate-pulse w-1/2"></div>
                          </div>
                        </div>
                      </div>

                      <!-- Apprenants List -->
                      <div v-else class="max-h-64 overflow-y-auto space-y-2 border rounded-lg p-2">
                        <div
                          v-for="apprenant in filteredApprenants"
                          :key="apprenant.id"
                          :class="[
                            'flex items-center gap-3 p-3 rounded-lg cursor-pointer transition-colors',
                            selectedApprenants.includes(apprenant.id.toString())
                              ? 'bg-blue-100 border-2 border-blue-300'
                              : 'bg-white hover:bg-gray-50 border'
                          ]"
                          @click="toggleApprenant(apprenant.id.toString())"
                        >
                          <input
                            type="checkbox"
                            :checked="selectedApprenants.includes(apprenant.id.toString())"
                            @click.stop
                            @change="toggleApprenant(apprenant.id.toString())"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                          />
                          <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                            {{ apprenant.user.name.charAt(0).toUpperCase() }}
                          </div>
                          <div class="flex-1">
                            <p class="font-medium">{{ apprenant.user.name }}</p>
                            <p class="text-sm text-gray-600">{{ apprenant.user.email }}</p>
                            <p class="text-xs text-gray-500">
                              {{ apprenant.groupe.nom }} - Promotion {{ apprenant.groupe.annee_promotion }}
                            </p>
                          </div>
                          <div class="text-right">
                            <span class="px-2 py-1 text-xs border rounded-full">{{ apprenant.groupe.nom }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="border-t my-6"></div>

                <button
                  @click="handleSubmit"
                  :disabled="!isFormValid || isSubmitting"
                  class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-md transition-colors flex items-center justify-center gap-2"
                >
                  <div v-if="isSubmitting" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                  <UserPlus v-else class="h-4 w-4" />
                  {{ isSubmitting ? 'Ajout en cours...' : `Ajouter ${selectedApprenants.length} participant(s)` }}
                </button>
              </div>
            </div>
          </div>

          <!-- Preview Section -->
          <div class="space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white shadow-lg rounded-lg">
              <div class="p-6 border-b">
                <h3 class="text-lg font-semibold">Actions Rapides</h3>
              </div>
              <div class="p-6 space-y-3">
                <button
                  @click="goBackToEventsList"
                  class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors"
                >
                  <ArrowLeft class="h-4 w-4" />
                  Changer d'événement
                </button>
                <button
                  v-if="selectedApprenants.length > 0"
                  @click="selectedApprenants = []"
                  class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-md transition-colors"
                >
                  <X class="h-4 w-4" />
                  Tout désélectionner
                </button>
                <button
                  @click="selectAllApprenants"
                  class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-md transition-colors"
                >
                  <CheckCircle class="h-4 w-4" />
                  Tout sélectionner
                </button>
              </div>
            </div>

            <!-- Selected Participants Summary -->
            <div class="bg-white shadow-lg rounded-lg">
              <div class="p-6 border-b">
                <h3 class="text-lg font-semibold">Participants Sélectionnés ({{ selectedApprenants.length }})</h3>
              </div>
              <div class="p-6">
                <!-- Selected Apprenants -->
                <div v-if="selectedApprenantsData.length > 0" class="mb-6">
                  <h4 class="font-medium text-blue-900 mb-3">Apprenants ({{ selectedApprenantsData.length }})</h4>
                  <div class="space-y-2 max-h-48 overflow-y-auto">
                    <div
                      v-for="apprenant in selectedApprenantsData"
                      :key="apprenant.id"
                      class="flex items-center gap-3 p-2 bg-blue-50 rounded-lg"
                    >
                      <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-semibold">
                        {{ apprenant.user.name.charAt(0).toUpperCase() }}
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm truncate">{{ apprenant.user.name }}</p>
                        <p class="text-xs text-gray-600 truncate">{{ apprenant.groupe.nom }}</p>
                      </div>
                      <button
                        @click="toggleApprenant(apprenant.id.toString())"
                        class="text-red-500 hover:text-red-700 p-1"
                      >
                        <X class="h-3 w-3" />
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Empty State -->
                <div v-if="selectedApprenants.length === 0" class="text-center py-8 text-gray-500">
                  <Users class="h-12 w-12 mx-auto mb-4 opacity-50" />
                  <p>Aucun participant sélectionné</p>
                </div>
              </div>
            </div>

            <!-- Success Message -->
            <div v-if="submitSuccess" class="bg-green-50 border border-green-200 rounded-lg">
              <div class="p-6">
                <div class="text-center">
                  <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <CheckCircle class="h-6 w-6 text-green-600" />
                  </div>
                  <h3 class="text-lg font-medium text-green-900 mb-2">Participants ajoutés !</h3>
                  <p class="text-sm text-green-700">{{ selectedApprenants.length }} participant(s) ont été ajoutés à l'événement avec succès.</p>
                  <button
                    @click="goBackToEventsList"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors"
                  >
                    Retour aux événements
                  </button>
                </div>
              </div>
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg">
              <div class="p-6">
                <h3 class="font-medium text-blue-900 mb-2">Instructions</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                  <li>• Utilisez le menu déroulant pour changer d'événement</li>
                  <li>• Sélectionnez plusieurs apprenants avec les cases à cocher</li>
                  <li>• Utilisez "Tout sélectionner" pour sélectionner tous les apprenants</li>
                  <li>• Utilisez la recherche pour filtrer les apprenants</li>
                  <li>• Vérifiez le résumé avant de confirmer</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch ,} from 'vue'
import {
  Calendar, Users, UserPlus, Search, CheckCircle, User, MapPin,
  Plus, X, Clock, ArrowLeft
} from 'lucide-vue-next'
import { useToast } from 'primevue/usetoast'

import { upcomingEvents } from '@/modules/Evenement.module/service/event.service';
import{apprenantNoInscripEvent } from '@/modules/Evenement.module/service/apprenant.service';
import {creatInscription} from '@/modules/Evenement.module/service/inscription.service';
// Get event ID from URL
const getEventIdFromUrl = () => {
  const urlParams = new URLSearchParams(window.location.search)
  return urlParams.get('eventId')
}

const apprenantToInscrip = async (id) =>
{
    try
    {
        if (!eventIdFromUrl.value) return
        isLoadingApprenants.value = true

        const response = await apprenantNoInscripEvent(id);
        apprenants.value = response.data;
    }
    catch(erreur)
    {
        console.log("something go wrong",erreur);
    }finally
    {
            isLoadingApprenants.value = false

    }
}

const Events = async ()=>
{
    try
    {
        const response = await upcomingEvents()
        events.value = response.data.data
        console.log("events: ",events.value);
    }
    catch(erreur)
    {
        console.log("problem in fetching upcoming events",erreur)
    }
}

const addParticipant = async (data) =>
{
    try {
        const response = await creatInscription(data);
       toast.add({
            severity: 'success',
            summary: 'Succès',
            detail: 'participant update succefuly !'+response,
            life: 3000
            });
    } catch (error) {
        console.log("something went wrong",erreur);
    }
}
// Reactive state
const eventIdFromUrl = ref(getEventIdFromUrl())
const events = ref([])
const apprenants = ref([])
const selectedApprenants = ref([])
const searchTerm = ref('')
const isSubmitting = ref(false)
const submitSuccess = ref(false)
const toast = useToast()

// Loading states
const isLoadingEvents = ref(true)
const isLoadingApprenants = ref(true)

// Utility functions
const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  })
}

// Navigation functions
const selectEvent = (eventId) => {
  const url = new URL(window.location)
  url.searchParams.set('eventId', eventId)
  window.history.pushState({}, '', url)
  eventIdFromUrl.value = eventId.toString()
  apprenantToInscrip(eventId);
}

const switchEvent = (eventId) => {
  if (eventId === eventIdFromUrl.value) return

  // Reset form state when switching events
  selectedApprenants.value = []
  searchTerm.value = ''
  submitSuccess.value = false

  const url = new URL(window.location)
  url.searchParams.set('eventId', eventId)
  window.history.pushState({}, '', url)
  eventIdFromUrl.value = eventId
  apprenantToInscrip(eventId);
}

const goBackToEventsList = () => {
  const url = new URL(window.location)
  url.searchParams.delete('eventId')
  window.history.pushState({}, '', url)
  eventIdFromUrl.value = null
  // Reset form state
  selectedApprenants.value = []
  searchTerm.value = ''
  submitSuccess.value = false
}

// Computed properties
const selectedEventData = computed(() => {
  if (!eventIdFromUrl.value) return null
  return events.value.find(event => event.id === eventIdFromUrl.value)
})

const filteredApprenants = computed(() => {
  return apprenants.value.filter(
    (apprenant) =>
      apprenant.user.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      apprenant.user.email.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      apprenant.groupe.nom.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

const selectedApprenantsData = computed(() => {
  return apprenants.value.filter((a) => selectedApprenants.value.includes(a.id))
})

const isFormValid = computed(() => {
  return selectedApprenants.value.length > 0
})

// Methods
const toggleApprenant = (id) => {
  const index = selectedApprenants.value.indexOf(id)
  if (index > -1) {
    selectedApprenants.value.splice(index, 1)
  } else {
    selectedApprenants.value.push(id)
  }
}

const selectAllApprenants = () => {
  selectedApprenants.value = filteredApprenants.value.map(a => a.id.toString())
}

const handleSubmit = async () => {
  if (!isFormValid.value) return
    const apprenants =ref({
        apprenantId:selectedApprenants.value,

    })
    for(const apprenant of apprenants.value.apprenantId){
        const data = ref({
           "participant_id": apprenant,
            "evenement_id":eventIdFromUrl.value
        })
      await addParticipant(data.value);
    }
      await apprenantToInscrip(getEventIdFromUrl())

  isSubmitting.value = true


  isSubmitting.value = false
  submitSuccess.value = true

  // Reset form after success
  setTimeout(() => {
    submitSuccess.value = false
    selectedApprenants.value = []
    searchTerm.value = ''
  }, 3000)
}


// Lifecycle
onMounted(async () => {
  isLoadingEvents.value = true
  await Events()
if (eventIdFromUrl.value) {
  await apprenantToInscrip(getEventIdFromUrl())
    }
    isLoadingEvents.value = false


})
</script>

<style scoped>
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .5;
  }
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
