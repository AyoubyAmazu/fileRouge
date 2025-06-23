<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Gestion des Inscriptions</h1>
            <p class="text-lg text-gray-600">
              Suivi et gestion des inscriptions
              <span v-if="selectedEvent" class="font-medium text-blue-600">
                - {{ selectedEvent.titre }}
              </span>
            </p>
          </div>
        <div class="flex gap-2">
    <button
      v-if="selectedEvent && new Date(selectedEvent.date_debut) >= new Date()"
      @click="showAddModal = true"
      class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
    >
      <Plus class="h-4 w-4" />
      Ajouter inscription
    </button>

  </div>
</div>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Event Filter -->
            <div>
              <label class="text-sm font-medium text-gray-700 mb-2 block">Événement</label>
              <div v-if="isLoadingEvents" class="h-10 bg-gray-200 rounded animate-pulse"></div>
              <select
                v-else
                v-model="selectedEventId"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option v-for="event in events" :key="event.id" :value="event.id.toString()">
                  {{ event.titre }}
                </option>
              </select>
            </div>

            <!-- Search -->
            <div>
              <label class="text-sm font-medium text-gray-700 mb-2 block">Recherche</label>
              <div class="relative">
                <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                <input
                  v-model="searchTerm"
                  type="text"
                  placeholder="Rechercher par nom, email..."
                  class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>

            <!-- Bulk Actions -->
            <div>
              <label class="text-sm font-medium text-gray-700 mb-2 block">Actions groupées</label>
              <div class="flex gap-2">
                <button
                  @click="markAllPresent"
                  :disabled="filteredInscriptions.length === 0"
                  class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm rounded-md transition-colors"
                >
                  Tous présents
                </button>
                <button
                  @click="markAllAbsent"
                  :disabled="filteredInscriptions.length === 0"
                  class="flex-1 px-3 py-2 bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm rounded-md transition-colors"
                >
                  Tous absents
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Event Info Card -->
      <div v-if="selectedEvent && !isLoadingEvents" class="bg-white rounded-lg shadow-lg mb-6">
        <div class="p-6">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-full">
              <Calendar class="h-8 w-8 text-blue-600" />
            </div>
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">{{ selectedEvent.titre }}</h3>
              <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                <div class="flex items-center gap-1">
                  <Clock class="h-4 w-4" />
                  {{ formatDate(selectedEvent.date_debut) }}
                </div>
                <div class="flex items-center gap-1">
                  <MapPin class="h-4 w-4" />
                  {{ selectedEvent.lieu }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-lg">
          <div class="p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ stats.total }}</div>
            <div class="text-sm text-gray-600">Total</div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg">
          <div class="p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ stats.present }}</div>
            <div class="text-sm text-gray-600">Présents</div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg">
          <div class="p-4 text-center">
            <div class="text-2xl font-bold text-red-500">{{ stats.absent }}</div>
            <div class="text-sm text-gray-600">Absents</div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg">
          <div class="p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ attendanceRate }}%</div>
            <div class="text-sm text-gray-600">Taux présence</div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg">
          <div class="p-4 text-center">
            <div class="text-2xl font-bold text-purple-500">{{ selectedInscriptions.length }}</div>
            <div class="text-sm text-gray-600">Sélectionnés</div>
          </div>
        </div>
      </div>

      <!-- Inscriptions Table -->
      <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <Users class="h-5 w-5" />
              <h3 class="text-xl font-semibold text-gray-900">Liste des Inscriptions</h3>
              <span
                v-if="!isLoadingInscriptions"
                class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full"
              >
                {{ filteredInscriptions.length }} résultat{{ filteredInscriptions.length !== 1 ? 's' : '' }}
              </span>
            </div>
            <div class="flex items-center gap-2">
              <button
                v-if="selectedInscriptions.length > 0"
                @click="bulkRemoveParticipants"
                class="flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition-colors"
              >
                <Trash2 class="h-4 w-4" />
                Supprimer ({{ selectedInscriptions.length }})
              </button>
              <button
                @click="toggleSelectAll"
                class="flex items-center gap-2 px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-md transition-colors"
              >
                <CheckSquare class="h-4 w-4" />
                {{ allSelected ? 'Tout désélectionner' : 'Tout sélectionner' }}
              </button>
            </div>
          </div>
        </div>
        <div class="p-6">
          <!-- Loading State -->
          <div v-if="isLoadingInscriptions" class="space-y-4">
            <div
              v-for="index in 5"
              :key="index"
              class="flex items-center space-x-4 p-4 border rounded-lg"
            >
              <div class="h-12 w-12 bg-gray-200 rounded-full animate-pulse"></div>
              <div class="flex-1 space-y-2">
                <div class="h-4 bg-gray-200 rounded animate-pulse w-48"></div>
                <div class="h-3 bg-gray-200 rounded animate-pulse w-32"></div>
              </div>
              <div class="space-y-2">
                <div class="h-6 bg-gray-200 rounded animate-pulse w-20"></div>
                <div class="h-4 bg-gray-200 rounded animate-pulse w-16"></div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else-if="filteredInscriptions.length === 0" class="text-center py-12">
            <Users class="h-12 w-12 text-gray-400 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune inscription trouvée</h3>
            <p class="text-gray-600">
              {{ selectedEvent ? `Aucune inscription pour "${selectedEvent.titre}"` : 'Aucune inscription ne correspond aux critères de recherche.' }}
            </p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <input
                      type="checkbox"
                      :checked="allSelected"
                      @change="toggleSelectAll"
                      class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Participant
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Contact
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Inscription
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Présence
                    <span class="text-xs text-gray-400 block font-normal">Double-clic pour modifier</span>
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr
                  v-for="inscription in filteredInscriptions"
                  :key="inscription.id"
                  :class="[
                    'hover:bg-gray-50 transition-colors',
                    selectedInscriptions.includes(inscription.id) ? 'bg-blue-50' : ''
                  ]"
                >
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input
                      type="checkbox"
                      :checked="selectedInscriptions.includes(inscription.id)"
                      @change="toggleInscriptionSelection(inscription.id)"
                      class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-blue-600">
                          {{ inscription.apprenant.user.name.charAt(0).toUpperCase() }}
                        </span>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ inscription.apprenant.user.name }}</div>
                        <div class="text-xs text-gray-500">ID: {{ inscription.id }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ inscription.apprenant.user.email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ formatDateShort(inscription.created_at) }}</div>
                    <div class="text-xs text-gray-500">{{ formatTime(inscription.created_at) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <!-- Editable Presence Status -->
                    <div v-if="editingPresence === inscription.id" class="flex items-center gap-2">
                      <select
                        v-model="tempPresenceValue"
                        @change="updatePresence(inscription.id, tempPresenceValue)"
                        @blur="cancelEdit"
                        @keyup.enter="updatePresence(inscription.id, tempPresenceValue)"
                        @keyup.escape="cancelEdit"
                        class="text-sm border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        ref="presenceSelect"
                      >
                        <option :value="null">En attente</option>
                        <option :value="1">Présent</option>
                        <option :value="0">Absent</option>
                      </select>
                      <button
                        @click="cancelEdit"
                        class="text-gray-400 hover:text-gray-600"
                      >
                        <X class="h-4 w-4" />
                      </button>
                    </div>
                    <!-- Display Presence Status -->
                    <div
                      v-else
                      @dblclick="startEditPresence(inscription.id, inscription.est_present)"
                      class="flex items-center cursor-pointer hover:bg-gray-100 rounded px-2 py-1 transition-colors"
                      :title="'Double-cliquez pour modifier'"
                    >
                      <component
                        :is="getPresenceIcon(inscription.est_present)"
                        class="h-4 w-4"
                        :class="getPresenceIconClass(inscription.est_present)"
                      />
                      <span class="ml-2 text-sm text-gray-900">
                        {{ getPresenceText(inscription.est_present) }}
                      </span>
                      <Edit3 class="h-3 w-3 ml-2 text-gray-400 opacity-0 group-hover:opacity-100" />
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                      <button
                        @click="quickTogglePresence(inscription.id, inscription.est_present)"
                        :class="[
                          'flex items-center gap-1 px-2 py-1 text-xs rounded transition-colors',
                          inscription.est_present === 1
                            ? 'bg-red-100 text-red-700 hover:bg-red-200'
                            : 'bg-green-100 text-green-700 hover:bg-green-200'
                        ]"
                      >
                        <component
                          :is="inscription.est_present === 1 ? XCircle : CheckCircle"
                          class="h-3 w-3"
                        />
                        {{ inscription.est_present === 1 ? 'Marquer absent' : 'Marquer présent' }}
                      </button>
                      <button
                        @click="removeParticipant(inscription.id)"
                        class="flex items-center gap-1 px-2 py-1 text-xs bg-red-100 text-red-700 hover:bg-red-200 rounded transition-colors"
                      >
                        <Trash2 class="h-3 w-3" />
                        Supprimer
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Confirmation Modal -->
      <div
        v-if="showConfirmModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click="showConfirmModal = false"
      >
        <div
          class="bg-white rounded-lg p-6 max-w-md w-full mx-4"
          @click.stop
        >
          <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-red-100 rounded-full">
              <AlertTriangle class="h-6 w-6 text-red-600" />
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Confirmer la suppression</h3>
          </div>
          <p class="text-gray-600 mb-6">
            {{ confirmAction.type === 'single'
              ? 'Êtes-vous sûr de vouloir supprimer ce participant ?'
              : `Êtes-vous sûr de vouloir supprimer ${confirmAction.count} participant(s) ?`
            }}
            Cette action est irréversible.
          </p>
          <div class="flex justify-end gap-3">
            <button
              @click="showConfirmModal = false"
              class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors"
            >
              Annuler
            </button>
            <button
              @click="confirmRemoval"
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors"
            >
              Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Add Inscription Modal -->
<div
  v-if="showAddModal"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
  @click="showAddModal = false"
>
  <div
    class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-0"
    @click.stop
  >
    <!-- Header -->
    <div class="flex items-center gap-3 border-b px-6 py-4">
      <div class="p-2 bg-green-100 rounded-full">
        <Plus class="h-5 w-5 text-green-600" />
      </div>
      <h3 class="text-lg font-bold text-gray-900">Ajouter une inscription</h3>
    </div>
    <!-- Body -->
    <div class="px-6 py-5 space-y-5">
      <!-- Event info (fixed) -->
      <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1">Événement</label>
        <div class="bg-gray-50 rounded-lg p-3 border flex flex-col gap-1">
          <span class="font-semibold text-blue-700 text-base">{{ selectedEvent?.titre }}</span>
          <span class="text-xs text-gray-500">{{ selectedEvent?.description }}</span>
        </div>
      </div>
      <!-- Apprenant select -->
      <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1">Sélectionner un apprenant</label>
        <select
          v-model="newInscription.participant_id"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
        >
          <option value="" disabled>Choisir un apprenant</option>
          <option v-for="apprenant in apprenants" :key="apprenant.id" :value="apprenant.id">
            {{ apprenant.user.name }} ({{ apprenant.user.email }})
          </option>
        </select>
      </div>
    </div>
    <!-- Footer -->
    <div class="flex justify-end gap-2 border-t px-6 py-4 bg-gray-50 rounded-b-2xl">
      <button
        @click="showAddModal = false"
        class="px-4 py-2 text-gray-600 hover:text-gray-900 rounded-md transition-colors text-sm font-medium"
      >
        Annuler
      </button>
      <button
        @click="addInscription"
        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors text-sm font-semibold flex items-center gap-2"
      >
        <Plus class="h-4 w-4" />
        Ajouter
      </button>
    </div>
  </div>
</div>
</template>

<script setup>
import { ref, computed, onMounted, watch, nextTick } from 'vue'
import {
  Users, Calendar, Clock, MapPin, Search, Download,
  CheckCircle, XCircle, AlertCircle, Trash2, Edit3, X,
  CheckSquare, AlertTriangle
} from 'lucide-vue-next'
import { useToast } from 'primevue/usetoast'

import { getInscriptionByEvent, updateInscriptionPresence, deleteInscription , creatInscription } from '@/modules/Evenement.module/service/inscription.service';
import { getEvents } from '@/modules/Evenement.module/service/event.service';
import { Plus } from 'lucide-vue-next'
import {apprenantNoInscripEvent} from '@/modules/Evenement.module/service/apprenant.service';

const toast = useToast()
const showAddModal = ref(false)
const apprenantSelect = ref(null)


const addInscription = async () => {
  try {
    const response = await creatInscription(newInscription.value)
console.log(response)
    toast.add({
      severity: 'success',
      summary: 'Succès',
      detail: 'Inscription ajoutée avec succès !',
      life: 3000
    })
    showAddModal.value = false
    // Optionally refresh inscriptions
    await fetchInscriptions()
  } catch (error) {
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Erreur lors de l\'ajout de l\'inscription'+error,
      life: 3000
    })
  }
}

const apprenants = ref([])

// Example fetch function (replace with your real API call)
const fetchApprenants = async () => {
    try {
        const response = await apprenantNoInscripEvent(selectedEventId.value)
        apprenants.value = response.data
        console.log(apprenants.value)
    } catch (error) {
        console.log(error)
    }

}


// Get event ID from URL
const getEventIdFromUrl = () => {
  const urlParams = new URLSearchParams(window.location.search)
  return urlParams.get('id') || '1'
}

// Reactive data
const inscriptions = ref([])
const events = ref([])
const selectedEventId = ref(getEventIdFromUrl())
const searchTerm = ref('')
const selectedInscriptions = ref([])

const newInscription = ref({
  participant_id: '',
  evenement_id: selectedEventId.value
})

// Editing state
const editingPresence = ref(null)
const tempPresenceValue = ref(null)
const presenceSelect = ref(null)

// Modal state
const showConfirmModal = ref(false)
const confirmAction = ref({ type: '', id: null, count: 0 })

// Loading states
const isLoadingInscriptions = ref(true)
const isLoadingEvents = ref(true)

// API functions
const fetchEvents = async () => {
  try {
    const response = await getEvents();
    events.value = response.data;
    console.log('Events fetched:', events.value);
    await fetchInscriptions();
  } catch (error) {
    console.error('Error fetching events:', error);
    return { data: [] };
  }
};

const fetchInscriptions = async () => {
  try {
    isLoadingInscriptions.value = true
    const response = await getInscriptionByEvent(selectedEventId.value)
    inscriptions.value = response.data
  } catch (error) {
    console.error('Error fetching inscriptions:', error)
    inscriptions.value = []
  } finally {
    isLoadingInscriptions.value = false
  }
}

// Utility functions
const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

const formatDateShort = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}

const formatTime = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleTimeString('fr-FR', {
    hour: '2-digit',
    minute: '2-digit',
  })
}

const getPresenceIcon = (isPresent) => {
  if (isPresent === null) return AlertCircle
  return isPresent ? CheckCircle : XCircle
}

const getPresenceIconClass = (isPresent) => {
  if (isPresent === null) return 'text-gray-400'
  return isPresent ? 'text-green-500' : 'text-red-500'
}

const getPresenceText = (isPresent) => {
  if (isPresent === null) return 'En attente'
  return isPresent ? 'Présent' : 'Absent'
}

// Presence editing functions
const startEditPresence = (inscriptionId, currentValue) => {
  editingPresence.value = inscriptionId
  tempPresenceValue.value = currentValue
  nextTick(() => {
    if (presenceSelect.value) {
      presenceSelect.value.focus()
    }
  })
}

const cancelEdit = () => {
  editingPresence.value = null
  tempPresenceValue.value = null
}

const updatePresence = async (inscriptionId, newValue) => {
  try {

      // Update local data
      const inscription = inscriptions.value.find(i => i.id === inscriptionId)
      const data = ref()
      if (inscription) {
          inscription.est_present = newValue
          data.value={
            id : inscriptionId,
            apprenant_id:inscription.participant_id,
            evenement_id:inscription.evenement_id,
            est_present: newValue
          }
          console.log(data.value);
          await updateInscriptionPresence(data.value,inscriptionId )
           toast.add({
            severity: 'success',
            summary: 'Succès',
            detail: 'inscription update succefuly !',
            life: 3000
            });
        }

    cancelEdit()
  } catch (error) {
    console.error('Error updating presence:', error)
    // You might want to show a toast notification here
  }
}

const quickTogglePresence = async (inscriptionId, currentValue) => {
  const newValue = currentValue === 1 ? 0 : 1
  await updatePresence(inscriptionId, newValue)
}

// Bulk actions
const markAllPresent = async () => {
  for (const inscription of filteredInscriptions.value) {
    if (inscription.est_present !== 1) {
      await updatePresence(inscription.id, 1)
    }
  }
}

const markAllAbsent = async () => {
  for (const inscription of filteredInscriptions.value) {
    if (inscription.est_present !== 0) {
      await updatePresence(inscription.id, 0)
    }
  }
}

// Selection functions
const toggleInscriptionSelection = (inscriptionId) => {
  const index = selectedInscriptions.value.indexOf(inscriptionId)
  if (index > -1) {
    selectedInscriptions.value.splice(index, 1)
  } else {
    selectedInscriptions.value.push(inscriptionId)
  }
}

const toggleSelectAll = () => {
  if (allSelected.value) {
    selectedInscriptions.value = []
  } else {
    selectedInscriptions.value = filteredInscriptions.value.map(i => i.id)
  }
}

// Removal functions
const removeParticipant = (inscriptionId) => {
  confirmAction.value = { type: 'single', id: inscriptionId, count: 1 }
  showConfirmModal.value = true
}

const bulkRemoveParticipants = () => {
  confirmAction.value = {
    type: 'bulk',
    ids: [...selectedInscriptions.value],
    count: selectedInscriptions.value.length
  }
  showConfirmModal.value = true
}

const confirmRemoval = async () => {
  try {
    if (confirmAction.value.type === 'single') {
      await deleteInscription(confirmAction.value.id)
      inscriptions.value = inscriptions.value.filter(i => i.id !== confirmAction.value.id)
    } else {
      // Bulk removal
      for (const id of confirmAction.value.ids) {
        await deleteInscription(id)
      }
      inscriptions.value = inscriptions.value.filter(i => !confirmAction.value.ids.includes(i.id))
      selectedInscriptions.value = []
    }

    showConfirmModal.value = false
    toast.add({
       severity: 'success',
          summary: 'Succès',
          detail: 'inscription delete succefuly !',
          life: 3000
    });
  } catch (error) {
    console.error('Error removing participant(s):', error)
  }
}

// Computed properties
const selectedEvent = computed(() => {
  return events.value.find(event => event.id.toString() === selectedEventId.value)
})

const filteredInscriptions = computed(() => {
  return inscriptions.value.filter((inscription) => {
    const matchesEvent = inscription.evenement_id.toString() === selectedEventId.value
    const matchesSearch =
      searchTerm.value === '' ||
      inscription.apprenant.user.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      inscription.apprenant.user.email.toLowerCase().includes(searchTerm.value.toLowerCase())
    return matchesEvent && matchesSearch
  })
})

const stats = computed(() => {
  const filtered = filteredInscriptions.value
  return {
    total: filtered.length,
    present: filtered.filter((i) => i.est_present === 1).length,
    absent: filtered.filter((i) => i.est_present === 0).length,
    pending: filtered.filter((i) => i.est_present === null).length,
  }
})

const attendanceRate = computed(() => {
  const total = stats.value.present + stats.value.absent
  if (total === 0) return 0
  return Math.round((stats.value.present / total) * 100)
})

const allSelected = computed(() => {
  return filteredInscriptions.value.length > 0 &&
         selectedInscriptions.value.length === filteredInscriptions.value.length
})

// Watchers
watch(selectedEventId, (newEventId) => {
  fetchInscriptions();
  selectedInscriptions.value = [] // Clear selections when changing events
  const url = new URL(window.location)
  url.searchParams.set('id', newEventId)
  window.history.pushState({}, '', url)
})
watch(showAddModal, (val) => {
  if (val) {
    nextTick(() => {
      apprenantSelect.value?.focus()
    })
  }
})
// Lifecycle
onMounted(async () => {
  isLoadingEvents.value = true
  isLoadingInscriptions.value = true
  await fetchEvents();
    await fetchApprenants()

  const eventExists = events.value.some(event => event.id.toString() === selectedEventId.value)
  if (!eventExists && events.value.length > 0) {
    selectedEventId.value = events.value[0].id.toString()
  }
  isLoadingEvents.value = false
  isLoadingInscriptions.value = false
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

.group:hover .group-hover\:opacity-100 {
  opacity: 1;
}
</style>
