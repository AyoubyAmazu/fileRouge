<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6">
    <div class="max-w-7xl mx-auto space-y-6">
      <!-- Header -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div class="space-y-2">
            <div class="flex items-center gap-3">
              <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                Membres des Communautés
              </h1>
            </div>
            <p class="text-slate-600 ml-12">
              Gérez les membres et leurs affiliations aux communautés (max. 2 par membre)
            </p>
          </div>

          <div class="flex items-center gap-3">
            <button
              @click="exportMembers"
              class="inline-flex items-center gap-2 border border-slate-300 hover:border-slate-400 text-slate-700 font-semibold py-2 px-4 rounded-lg transition-all duration-200"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Exporter
            </button>
            <div class="text-sm text-slate-500 bg-slate-100 px-3 py-2 rounded-lg">
              {{ filteredMembers.length }} membre{{ filteredMembers.length !== 1 ? 's' : '' }}
            </div>
          </div>
        </div>
      </div>

      <!-- Community Limit Info -->
      <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-amber-100 rounded-lg">
            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <h3 class="font-medium text-amber-800">Limite de communautés</h3>
            <p class="text-sm text-amber-700">Chaque membre peut appartenir à un maximum de 2 communautés.</p>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Search -->
          <div class="relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
              type="text"
              v-model="filters.search"
              placeholder="Rechercher par nom ou email..."
              class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
            />
          </div>

          <!-- Group Filter -->
          <select
            v-model="filters.groupe"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
          >
            <option value="">Tous les groupes</option>
            <option v-for="groupe in uniqueGroups" :key="groupe" :value="groupe">
              {{ groupe }}
            </option>
          </select>

          <!-- Year Filter -->
          <select
            v-model="filters.annee"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
          >
            <option value="">Toutes les années</option>
            <option v-for="annee in uniqueYears" :key="annee" :value="annee">
              {{ annee }}
            </option>
          </select>

          <!-- Community Filter -->
          <select
            v-model="filters.communaute"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
          >
            <option value="">Toutes les communautés</option>
            <option v-for="comm in allCommunautes" :key="comm.id" :value="comm.nom">
              {{ comm.nom }}
            </option>
          </select>
        </div>

        <!-- Clear Filters -->
        <div v-if="hasActiveFilters" class="mt-4 flex justify-end">
          <button
            @click="clearFilters"
            class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 text-sm"
          >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Effacer les filtres
          </button>
        </div>
      </div>

      <!-- Members Table -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 overflow-hidden">
        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center py-12">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-3 text-slate-600">Chargement des membres...</span>
        </div>

        <!-- Empty State -->
        <div v-else-if="filteredMembers.length === 0" class="text-center py-12">
          <div class="p-4 bg-slate-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
            <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-slate-600 mb-2">Aucun membre trouvé</h3>
          <p class="text-slate-500">
            {{ hasActiveFilters
              ? 'Essayez de modifier vos filtres pour voir plus de résultats.'
              : 'Aucun membre n\'est encore enregistré.'
            }}
          </p>
        </div>

        <!-- Table -->
        <div v-else class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Membre</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Groupe</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Année</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                  Communautés
                  <span class="text-xs font-normal text-slate-400 ml-1">(max. 2)</span>
                </th>
                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
              <tr
                v-for="(member, index) in paginatedMembers"
                :key="member.id"
                class="hover:bg-slate-50 transition-colors duration-200"
              >
                <!-- Index -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                  {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                </td>

                <!-- Member Info -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                      {{ getInitials(member.apprenant?.user?.name || '') }}
                    </div>
                    <div>
                      <div class="text-sm font-medium text-slate-900">
                        {{ member.apprenant?.user?.name || '—' }}
                      </div>
                      <div class="text-sm text-slate-500">
                        {{ member.apprenant?.user?.email || '—' }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Group -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ member.apprenant?.groupe?.nom || '—' }}
                  </span>
                </td>

                <!-- Year -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    {{ member.apprenant?.groupe?.annee_promotion || '—' }}
                  </span>
                </td>

                <!-- Communities -->
                <td class="px-6 py-4">
                  <!-- Edit Mode -->
                  <div v-if="editingId === member.id" class="space-y-3">
                    <!-- Current Communities -->
                    <div class="flex flex-wrap gap-2">
                      <span
                        v-for="commId in selectedCommunautes[member.id]"
                        :key="commId"
                        class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs"
                      >
                        {{ getCommunityName(commId) }}
                        <button
                          @click="removeCommunityFromMember(member.id, commId)"
                          class="hover:bg-blue-200 rounded-full p-0.5 transition-colors duration-200"
                        >
                          <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                        </button>
                      </span>

                      <!-- Empty slots indicator -->
                      <span
                        v-for="n in (2 - selectedCommunautes[member.id].length)"
                        :key="`empty-${n}`"
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs border-2 border-dashed border-slate-300 text-slate-400"
                      >
                        Slot libre
                      </span>
                    </div>

                    <!-- Community Counter -->
                    <div class="text-xs text-slate-500">
                      {{ selectedCommunautes[member.id].length }}/2 communautés
                      <span v-if="selectedCommunautes[member.id].length === 2" class="text-amber-600 font-medium">
                        (Limite atteinte)
                      </span>
                    </div>

                    <!-- Add Community Dropdown -->
                    <div v-if="selectedCommunautes[member.id].length < 2">
                      <select
                        @change="addCommunityToMember(member.id, $event.target.value)"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      >
                        <option value="">Ajouter une communauté...</option>
                        <option
                          v-for="comm in availableCommunitiesForMember(member.id)"
                          :key="comm.id"
                          :value="comm.id"
                        >
                          {{ comm.nom }}
                        </option>
                      </select>
                    </div>

                    <!-- Limit Warning -->
                    <div v-else class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-200">
                      ⚠️ Limite de 2 communautés atteinte
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 mt-3">
                      <button
                        @click="saveCommunauteChange(member)"
                        :disabled="savingMember === member.id"
                        class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg transition-colors duration-200 disabled:opacity-50 flex items-center gap-1"
                      >
                        <svg v-if="savingMember === member.id" class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <svg v-else class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Sauvegarder
                      </button>
                      <button
                        @click="cancelEdit"
                        class="px-3 py-1 bg-slate-600 hover:bg-slate-700 text-white text-xs rounded-lg transition-colors duration-200 flex items-center gap-1"
                      >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                      </button>
                    </div>
                  </div>

                  <!-- Display Mode -->
                  <div v-else class="space-y-2">
                    <div class="flex flex-wrap gap-1">
                      <span
                        v-for="comm in member.communaute"
                        :key="comm.id"
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                      >
                        {{ comm.nom }}
                      </span>

                      <!-- Empty slots -->
                      <span
                        v-for="n in (2 - (member.communaute?.length || 0))"
                        :key="`display-empty-${n}`"
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs border border-dashed border-slate-300 text-slate-400"
                      >
                        Disponible
                      </span>
                    </div>

                    <!-- Community count indicator -->
                    <div class="text-xs">
                      <span :class="[
                        'px-2 py-0.5 rounded-full text-xs font-medium',
                        (member.communaute?.length || 0) === 2
                          ? 'bg-green-100 text-green-800'
                          : (member.communaute?.length || 0) === 1
                            ? 'bg-yellow-100 text-yellow-800'
                            : 'bg-slate-100 text-slate-600'
                      ]">
                        {{ member.communaute?.length || 0 }}/2 communautés
                      </span>
                    </div>
                  </div>
                </td>

                <!-- Actions -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button
                    v-if="editingId !== member.id"
                    @click="editMember(member.id)"
                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 hover:bg-blue-50 px-2 py-1 rounded-lg transition-all duration-200"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="bg-slate-50 px-6 py-4 border-t border-slate-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-slate-700">
              Affichage de {{ (currentPage - 1) * itemsPerPage + 1 }} à {{ Math.min(currentPage * itemsPerPage, filteredMembers.length) }} sur {{ filteredMembers.length }} résultats
            </div>
            <div class="flex items-center gap-2">
              <button
                @click="currentPage = Math.max(1, currentPage - 1)"
                :disabled="currentPage === 1"
                class="px-3 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
              >
                Précédent
              </button>

              <div class="flex gap-1">
                <button
                  v-for="page in visiblePages"
                  :key="page"
                  @click="currentPage = page"
                  :class="[
                    'px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                    page === currentPage
                      ? 'bg-blue-600 text-white'
                      : 'text-slate-700 hover:bg-slate-50 border border-slate-300'
                  ]"
                >
                  {{ page }}
                </button>
              </div>

              <button
                @click="currentPage = Math.min(totalPages, currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="px-3 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
              >
                Suivant
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// Mock data - updated to respect 2 community limit
const mockMembers = [
  {
    id: 1,
    apprenant: {
      user: { name: "Alice Martin", email: "alice.martin@example.com" },
      groupe: { nom: "Groupe A", annee_promotion: "2024" }
    },
    communaute: [
      { id: 1, nom: "Développeurs Full Stack" },
      { id: 2, nom: "Designers UI/UX" }
    ]
  },
  {
    id: 2,
    apprenant: {
      user: { name: "Bob Dupont", email: "bob.dupont@example.com" },
      groupe: { nom: "Groupe B", annee_promotion: "2023" }
    },
    communaute: [
      { id: 1, nom: "Développeurs Full Stack" }
    ]
  },
  {
    id: 3,
    apprenant: {
      user: { name: "Claire Rousseau", email: "claire.rousseau@example.com" },
      groupe: { nom: "Groupe A", annee_promotion: "2024" }
    },
    communaute: [
      { id: 3, nom: "Data Scientists" },
      { id: 4, nom: "DevOps Engineers" }
    ]
  },
  {
    id: 4,
    apprenant: {
      user: { name: "David Chen", email: "david.chen@example.com" },
      groupe: { nom: "Groupe C", annee_promotion: "2023" }
    },
    communaute: []
  },
  {
    id: 5,
    apprenant: {
      user: { name: "Emma Wilson", email: "emma.wilson@example.com" },
      groupe: { nom: "Groupe B", annee_promotion: "2025" }
    },
    communaute: [
      { id: 2, nom: "Designers UI/UX" }
    ]
  }
]

const mockCommunautes = [
  { id: 1, nom: "Développeurs Full Stack" },
  { id: 2, nom: "Designers UI/UX" },
  { id: 3, nom: "Data Scientists" },
  { id: 4, nom: "DevOps Engineers" },
  { id: 5, nom: "Product Managers" }
]

// Constants
const MAX_COMMUNITIES_PER_MEMBER = 2

// Reactive state
const members = ref([...mockMembers])
const allCommunautes = ref([...mockCommunautes])
const selectedCommunautes = ref({})
const loading = ref(false)
const editingId = ref(null)
const savingMember = ref(null)
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Filters
const filters = ref({
  search: '',
  groupe: '',
  annee: '',
  communaute: ''
})

// Initialize selected communities
const initializeSelectedCommunautes = () => {
  members.value.forEach((member) => {
    selectedCommunautes.value[member.id] = member.communaute?.map(c => c.id) || []
  })
}

// Computed properties
const uniqueGroups = computed(() => {
  const groups = members.value
    .map(m => m.apprenant?.groupe?.nom)
    .filter(Boolean)
  return [...new Set(groups)].sort()
})

const uniqueYears = computed(() => {
  const years = members.value
    .map(m => m.apprenant?.groupe?.annee_promotion)
    .filter(Boolean)
  return [...new Set(years)].sort((a, b) => b.localeCompare(a))
})

const hasActiveFilters = computed(() => {
  return filters.value.search || filters.value.groupe || filters.value.annee || filters.value.communaute
})

const filteredMembers = computed(() => {
  return members.value.filter(member => {
    // Search filter
    const searchTerm = filters.value.search.toLowerCase()
    const nameMatch = member.apprenant?.user?.name?.toLowerCase().includes(searchTerm)
    const emailMatch = member.apprenant?.user?.email?.toLowerCase().includes(searchTerm)
    const searchMatch = !filters.value.search || nameMatch || emailMatch

    // Group filter
    const groupMatch = !filters.value.groupe || member.apprenant?.groupe?.nom === filters.value.groupe

    // Year filter
    const yearMatch = !filters.value.annee || member.apprenant?.groupe?.annee_promotion === filters.value.annee

    // Community filter
    const communityMatch = !filters.value.communaute ||
      member.communaute?.some(c => c.nom === filters.value.communaute)

    return searchMatch && groupMatch && yearMatch && communityMatch
  })
})

const totalPages = computed(() => {
  return Math.ceil(filteredMembers.value.length / itemsPerPage.value)
})

const paginatedMembers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredMembers.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  const total = totalPages.value
  const current = currentPage.value

  if (total <= 7) {
    for (let i = 1; i <= total; i++) {
      pages.push(i)
    }
  } else {
    if (current <= 4) {
      for (let i = 1; i <= 5; i++) {
        pages.push(i)
      }
      pages.push('...', total)
    } else if (current >= total - 3) {
      pages.push(1, '...')
      for (let i = total - 4; i <= total; i++) {
        pages.push(i)
      }
    } else {
      pages.push(1, '...')
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i)
      }
      pages.push('...', total)
    }
  }

  return pages.filter(page => page !== '...' || pages.indexOf(page) === pages.lastIndexOf(page))
})

// Methods
const getInitials = (name) => {
  if (!name) return '?'
  return name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

const getCommunityName = (commId) => {
  const community = allCommunautes.value.find(c => c.id === commId)
  return community ? community.nom : 'Communauté inconnue'
}

const availableCommunitiesForMember = (memberId) => {
  const memberCommunities = selectedCommunautes.value[memberId] || []
  return allCommunautes.value.filter(c => !memberCommunities.includes(c.id))
}

const editMember = (memberId) => {
  editingId.value = memberId
  // Reset selected communities to current state
  const member = members.value.find(m => m.id === memberId)
  selectedCommunautes.value[memberId] = member.communaute?.map(c => c.id) || []
}

const cancelEdit = () => {
  editingId.value = null
}

const addCommunityToMember = (memberId, communityId) => {
  if (communityId && selectedCommunautes.value[memberId].length < MAX_COMMUNITIES_PER_MEMBER) {
    const commId = parseInt(communityId)
    if (!selectedCommunautes.value[memberId].includes(commId)) {
      selectedCommunautes.value[memberId].push(commId)
    }
  } else if (selectedCommunautes.value[memberId].length >= MAX_COMMUNITIES_PER_MEMBER) {
    alert(`⚠️ Un membre ne peut appartenir qu'à un maximum de ${MAX_COMMUNITIES_PER_MEMBER} communautés.`)
  }
}

const removeCommunityFromMember = (memberId, communityId) => {
  selectedCommunautes.value[memberId] = selectedCommunautes.value[memberId].filter(id => id !== communityId)
}

const saveCommunauteChange = async (member) => {
  const selected = selectedCommunautes.value[member.id]

  // Validate community limit
  if (selected.length > MAX_COMMUNITIES_PER_MEMBER) {
    alert(`❌ Erreur: Un membre ne peut appartenir qu'à un maximum de ${MAX_COMMUNITIES_PER_MEMBER} communautés.`)
    return
  }

  savingMember.value = member.id

  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000))

    // Update member's communities
    member.communaute = allCommunautes.value.filter(c => selected.includes(c.id))

    console.log('Updated member communities:', {
      memberId: member.id,
      communities: selected,
      count: selected.length
    })

    alert(`✅ Communautés mises à jour avec succès! (${selected.length}/${MAX_COMMUNITIES_PER_MEMBER})`)
  } catch (error) {
    alert('❌ Erreur lors de la mise à jour des communautés.')
  } finally {
    savingMember.value = null
    editingId.value = null
  }
}

const clearFilters = () => {
  filters.value = {
    search: '',
    groupe: '',
    annee: '',
    communaute: ''
  }
  currentPage.value = 1
}

const exportMembers = () => {
  console.log('Exporting members...', filteredMembers.value)
  alert('📊 Export des membres en cours...')
}

// Initialize component
onMounted(() => {
  initializeSelectedCommunautes()
  console.log('🚀 Community members page loaded with 2-community limit')
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
select:focus,
button:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
}

/* Placeholder styling */
input::placeholder {
  color: #94a3b8;
}

/* Table hover effects */
tbody tr:hover {
  background-color: #f8fafc;
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

/* Button hover effects */
button:hover {
  transform: translateY(-1px);
}

button:active {
  transform: translateY(0);
}

/* Badge styles */
.inline-flex {
  display: inline-flex;
  align-items: center;
}

/* Dashed border animation */
.border-dashed {
  border-style: dashed;
  animation: dash 2s linear infinite;
}

@keyframes dash {
  to {
    stroke-dashoffset: -20;
  }
}
</style>
