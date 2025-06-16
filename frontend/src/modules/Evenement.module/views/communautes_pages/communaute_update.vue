<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6">
    <div class="max-w-7xl mx-auto space-y-6">
      <!-- Header -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div class="space-y-2">
            <div class="flex items-center gap-3">
              <button
                @click="goBack"
                class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200"
              >
                <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                Modifier la Communauté
              </h1>
            </div>
            <p class="text-slate-600 ml-12">
              Modifiez les informations de la communauté et gérez ses membres
            </p>
          </div>
          <div class="flex gap-3">
            <button
              @click="goBack"
              class="inline-flex items-center gap-2 border border-slate-300 hover:border-slate-400 text-slate-700 font-semibold py-3 px-6 rounded-lg transition-all duration-200"
            >
              Annuler
            </button>
            <button
              @click="saveCommunity"
              :disabled="saving || !isFormValid"
              class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-400 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg disabled:cursor-not-allowed"
            >
              <svg v-if="saving" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              {{ saving ? 'Enregistrement...' : 'Enregistrer' }}
            </button>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-12">
        <div class="flex items-center justify-center">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-3 text-slate-600">Chargement des données...</span>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Community Details Form -->
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
            <div class="flex items-center gap-3 mb-6">
              <div class="p-2 bg-green-100 rounded-lg">
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <h2 class="text-xl font-semibold text-slate-800">Informations de la Communauté</h2>
            </div>

            <form @submit.prevent="saveCommunity" class="space-y-6">
              <!-- Community Name -->
              <div>
                <label for="nom" class="block text-sm font-medium text-slate-700 mb-2">
                  Nom de la communauté *
                </label>
                <input
                  id="nom"
                  type="text"
                  v-model="form.nom"
                  :class="[
                    'w-full px-4 py-3 border rounded-lg transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
                    errors.nom ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white'
                  ]"
                  placeholder="Entrez le nom de la communauté"
                />
                <p v-if="errors.nom" class="mt-1 text-sm text-red-600">{{ errors.nom }}</p>
              </div>

              <!-- Community Description -->
              <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                  Description *
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  rows="6"
                  :class="[
                    'w-full px-4 py-3 border rounded-lg transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none',
                    errors.description ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white'
                  ]"
                  placeholder="Décrivez votre communauté, ses objectifs et ses activités..."
                ></textarea>
                <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                <p class="mt-1 text-sm text-slate-500">
                  {{ form.description.length }}/500 caractères
                </p>
              </div>
            </form>
          </div>
        </div>

        <!-- Community Stats -->
        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Statistiques</h3>
            <div class="space-y-4">
              <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center gap-2">
                  <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  <span class="text-slate-700">Total Membres</span>
                </div>
                <span class="font-bold text-blue-600">{{ members.length }}</span>
              </div>

              <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-2">
                  <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                  </svg>
                  <span class="text-slate-700">Groupes</span>
                </div>
                <span class="font-bold text-green-600">{{ uniqueGroups.length }}</span>
              </div>

              <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                <div class="flex items-center gap-2">
                  <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0h8m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-10V9a2 2 0 00-2-2H10a2 2 0 00-2 2v2m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2h-2" />
                  </svg>
                  <span class="text-slate-700">Années</span>
                </div>
                <span class="font-bold text-purple-600">{{ uniqueYears.length }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Members Management -->
      <div v-if="!loading" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0">
        <div class="p-6 pb-4">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="p-2 bg-red-100 rounded-lg">
                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
              <div>
                <h2 class="text-xl font-semibold text-slate-800">Gestion des Membres</h2>
                <p class="text-slate-600">Supprimez les membres de la communauté</p>
              </div>
            </div>

            <div class="text-sm text-slate-500">
              {{ members.length }} membre{{ members.length !== 1 ? 's' : '' }}
            </div>
          </div>

          <!-- Search Filter -->
          <div class="relative mb-6">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Rechercher un membre..."
              class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
            />
          </div>
        </div>

        <div class="px-6 pb-6">
          <!-- Empty State -->
          <div v-if="filteredMembers.length === 0" class="text-center py-12">
            <div class="p-4 bg-slate-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
              <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-600 mb-2">
              {{ searchQuery ? 'Aucun membre trouvé' : 'Aucun membre' }}
            </h3>
            <p class="text-slate-500">
              {{ searchQuery
                ? 'Essayez de modifier votre recherche.'
                : 'Cette communauté n\'a pas encore de membres.'
              }}
            </p>
          </div>

          <!-- Members List -->
          <div v-else class="space-y-3">
            <div
              v-for="(member, index) in filteredMembers"
              :key="member.id"
              class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 bg-white hover:shadow-md transition-all duration-200 group"
            >
              <!-- Avatar and Info -->
              <div class="flex items-center gap-3 flex-1 min-w-0">
                <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                  {{ getInitials(member.apprenant?.user?.name || '') }}
                </div>

                <div class="flex-1 min-w-0">
                  <h4 class="font-semibold text-slate-800 truncate mb-1">
                    {{ member.apprenant?.user?.name || '—' }}
                  </h4>
                  <div class="flex items-center gap-4 text-sm text-slate-500">
                    <div class="flex items-center gap-1">
                      <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                      <span class="truncate">{{ member.apprenant?.user?.email || '—' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <span>{{ member.apprenant?.groupe?.nom || '—' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0h8m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-10V9a2 2 0 00-2-2H10a2 2 0 00-2 2v2m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2h-2" />
                      </svg>
                      <span>{{ member.apprenant?.groupe?.annee_promotion || '—' }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Remove Button -->
              <button
                @click="confirmRemoveMember(member)"
                :disabled="removingMembers.includes(member.id)"
                class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg v-if="removingMembers.includes(member.id)" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span class="hidden sm:inline">Supprimer</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="p-2 bg-red-100 rounded-lg">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-800">Confirmer la suppression</h3>
        </div>

        <p class="text-slate-600 mb-6">
          Êtes-vous sûr de vouloir supprimer <strong>{{ memberToRemove?.apprenant?.user?.name }}</strong> de cette communauté ? Cette action est irréversible.
        </p>

        <div class="flex gap-3 justify-end">
          <button
            @click="cancelRemoveMember"
            class="px-4 py-2 border border-slate-300 hover:border-slate-400 text-slate-700 rounded-lg transition-colors duration-200"
          >
            Annuler
          </button>
          <button
            @click="removeMember"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200"
          >
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// Mock data for demonstration
const mockCommunity = {
  id: 1,
  nom: "Développeurs Full Stack",
  description: "Une communauté dédiée aux développeurs full stack passionnés par les technologies modernes. Nous partageons nos connaissances, organisons des événements et collaborons sur des projets innovants."
}

const mockMembers = [
  {
    id: 1,
    apprenant: {
      user: { name: "Alice Martin", email: "alice.martin@example.com" },
      groupe: { nom: "Groupe A", annee_promotion: "2024" }
    }
  },
  {
    id: 2,
    apprenant: {
      user: { name: "Bob Dupont", email: "bob.dupont@example.com" },
      groupe: { nom: "Groupe B", annee_promotion: "2023" }
    }
  },
  {
    id: 3,
    apprenant: {
      user: { name: "Claire Rousseau", email: "claire.rousseau@example.com" },
      groupe: { nom: "Groupe A", annee_promotion: "2024" }
    }
  },
  {
    id: 4,
    apprenant: {
      user: { name: "David Chen", email: "david.chen@example.com" },
      groupe: { nom: "Groupe C", annee_promotion: "2023" }
    }
  },
  {
    id: 5,
    apprenant: {
      user: { name: "Emma Wilson", email: "emma.wilson@example.com" },
      groupe: { nom: "Groupe B", annee_promotion: "2025" }
    }
  },
  {
    id: 6,
    apprenant: {
      user: { name: "François Dubois", email: "francois.dubois@example.com" },
      groupe: { nom: "Groupe A", annee_promotion: "2024" }
    }
  },
  {
    id: 7,
    apprenant: {
      user: { name: "Sophie Laurent", email: "sophie.laurent@example.com" },
      groupe: { nom: "Groupe C", annee_promotion: "2025" }
    }
  }
]

// Reactive state
const loading = ref(false)
const saving = ref(false)
const searchQuery = ref('')
const removingMembers = ref([])
const showConfirmModal = ref(false)
const memberToRemove = ref(null)

// Form data
const form = ref({
  nom: mockCommunity.nom,
  description: mockCommunity.description
})

// Form validation errors
const errors = ref({
  nom: '',
  description: ''
})

// Members data
const members = ref([...mockMembers])

// Computed properties
const isFormValid = computed(() => {
  return form.value.nom.trim().length > 0 &&
         form.value.description.trim().length > 0 &&
         form.value.description.length <= 500
})

const filteredMembers = computed(() => {
  if (!searchQuery.value) return members.value

  const query = searchQuery.value.toLowerCase()
  return members.value.filter(member => {
    const name = member.apprenant?.user?.name?.toLowerCase() || ''
    const email = member.apprenant?.user?.email?.toLowerCase() || ''
    const groupe = member.apprenant?.groupe?.nom?.toLowerCase() || ''

    return name.includes(query) || email.includes(query) || groupe.includes(query)
  })
})

const uniqueGroups = computed(() => {
  const groups = members.value
    .map(m => m.apprenant?.groupe?.nom)
    .filter(Boolean)
  return [...new Set(groups)]
})

const uniqueYears = computed(() => {
  const years = members.value
    .map(m => m.apprenant?.groupe?.annee_promotion)
    .filter(Boolean)
  return [...new Set(years)]
})

// Methods
const validateForm = () => {
  errors.value = { nom: '', description: '' }

  if (!form.value.nom.trim()) {
    errors.value.nom = 'Le nom de la communauté est requis'
  }

  if (!form.value.description.trim()) {
    errors.value.description = 'La description est requise'
  } else if (form.value.description.length > 500) {
    errors.value.description = 'La description ne peut pas dépasser 500 caractères'
  }

  return !errors.value.nom && !errors.value.description
}

const saveCommunity = async () => {
  if (!validateForm()) return

  saving.value = true

  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000))

    console.log('Community updated:', {
      nom: form.value.nom.trim(),
      description: form.value.description.trim()
    })

    alert('✅ La communauté a été mise à jour avec succès!')
  } catch (error) {
    alert('❌ Erreur lors de la mise à jour de la communauté.')
  } finally {
    saving.value = false
  }
}

const confirmRemoveMember = (member) => {
  memberToRemove.value = member
  showConfirmModal.value = true
}

const cancelRemoveMember = () => {
  memberToRemove.value = null
  showConfirmModal.value = false
}

const removeMember = async () => {
  if (!memberToRemove.value) return

  const memberId = memberToRemove.value.id
  removingMembers.value.push(memberId)

  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 800))

    // Remove member from local array
    members.value = members.value.filter(m => m.id !== memberId)

    alert('✅ Le membre a été supprimé de la communauté.')
  } catch (error) {
    alert('❌ Erreur lors de la suppression du membre.')
  } finally {
    removingMembers.value = removingMembers.value.filter(id => id !== memberId)
    showConfirmModal.value = false
    memberToRemove.value = null
  }
}

const getInitials = (name) => {
  if (!name) return '?'
  return name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

const goBack = () => {
  console.log('🔙 Going back to community details')
  alert('Navigation vers les détails de la communauté')
}

// Initialize component
onMounted(() => {
  console.log('🚀 Community update page loaded')
})
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Smooth transitions */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Focus styles */
input:focus,
textarea:focus,
button:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
}

/* Placeholder styling */
input::placeholder,
textarea::placeholder {
  color: #94a3b8;
}

/* Modal backdrop blur */
.fixed.inset-0 {
  backdrop-filter: blur(4px);
}

/* Hover effects for member cards */
.group:hover .font-semibold {
  color: #1e40af;
}

/* Loading animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Form validation error shake */
.border-red-300 {
  animation: shake 0.3s ease-in-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-2px); }
  75% { transform: translateX(2px); }
}
</style>
