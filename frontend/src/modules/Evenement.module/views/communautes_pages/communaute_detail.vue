<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6">
    <div class="max-w-7xl mx-auto space-y-6">
      <!-- Header Card -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
          <div class="space-y-3">
            <div class="flex items-center gap-3">
              <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                {{ communaute.nom }}
              </h1>
            </div>
            <p class="text-base text-slate-600 max-w-3xl leading-relaxed">
              {{ communaute.description }}
            </p>
          </div>
          <button
            @click="goToUpdate"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
          >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Modifier la Communauté
          </button>
        </div>
      </div>

      <!-- Members Section -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0">
        <!-- Header -->
        <div class="p-6 pb-4">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
              <h2 class="text-xl font-semibold text-slate-800 mb-1">Membres de la Communauté</h2>
              <p class="text-slate-600">
                {{ filteredMembers.length }} membre{{ filteredMembers.length !== 1 ? 's' : '' }}
                <span v-if="hasActiveFilters" class="text-slate-500">
                  ({{ members.length }} au total)
                </span>
              </p>
            </div>

            <button
              v-if="hasActiveFilters"
              @click="clearFilters"
              class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 border border-slate-200 hover:border-slate-300 px-4 py-2 rounded-lg transition-all duration-200"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Effacer les filtres
            </button>
          </div>

          <!-- Filters -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Filter -->
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

            <!-- Results Counter -->
            <div class="flex items-center gap-2 text-sm text-slate-500 px-4 py-3">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
              </svg>
              <span>
                {{ filteredMembers.length }} résultat{{ filteredMembers.length !== 1 ? 's' : '' }}
              </span>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="px-6 pb-6">
          <!-- Loading State -->
          <div v-if="loading" class="flex items-center justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-slate-600">Chargement...</span>
          </div>

          <!-- Empty State -->
          <div v-else-if="filteredMembers.length === 0" class="text-center py-12">
            <div class="p-4 bg-slate-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
              <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-600 mb-2">Aucun membre trouvé</h3>
            <p class="text-slate-500">
              {{ hasActiveFilters
                ? 'Essayez de modifier vos filtres pour voir plus de résultats.'
                : 'Cette communauté n\'a pas encore de membres.'
              }}
            </p>
          </div>

          <!-- Members List -->
          <div v-else class="space-y-3">
            <div
              v-for="(member, index) in filteredMembers"
              :key="member.id"
              class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 bg-white hover:shadow-md transition-all duration-200 hover:border-slate-300 group"
            >
              <!-- Avatar and Info -->
              <div class="flex items-center gap-3 flex-1 min-w-0">
                <div class="relative">
                  <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    {{ getInitials(member.apprenant?.user?.name || '') }}
                  </div>
                  <div class="absolute -top-1 -right-1 bg-slate-100 text-slate-600 text-xs font-medium px-2 py-1 rounded-full border border-slate-200">
                    #{{ index + 1 }}
                  </div>
                </div>

                <div class="flex-1 min-w-0">
                  <h4 class="font-semibold text-slate-800 truncate mb-1">
                    {{ member.apprenant?.user?.name || '—' }}
                  </h4>
                  <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">{{ member.apprenant?.user?.email || '—' }}</span>
                  </div>
                </div>
              </div>

              <!-- Group and Year Info -->
              <div class="flex items-center gap-6 text-sm">
                <div class="text-center">
                  <div class="flex items-center gap-1 text-slate-600 mb-1">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium">{{ member.apprenant?.groupe?.nom || '—' }}</span>
                  </div>
                  <span class="text-xs text-slate-400">Groupe</span>
                </div>

                <div class="h-8 w-px bg-slate-200"></div>

                <div class="text-center">
                  <div class="flex items-center gap-1 text-slate-600 mb-1">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0h8m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-10V9a2 2 0 00-2-2H10a2 2 0 00-2 2v2m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2h-2" />
                    </svg>
                    <span class="font-medium">{{ member.apprenant?.groupe?.annee_promotion || '—' }}</span>
                  </div>
                  <span class="text-xs text-slate-400">Année</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { getCommunauteById } from '@/modules/Evenement.module/service/communaute.service'
import { membersByCommunaute } from '@/modules/Evenement.module/service/communauteMembers.service'

const route = useRoute()
const router = useRouter()
const toast = useToast()

const id = route.params.id
const communaute = ref({})
const members = ref([])
const loading = ref(true)

// Enhanced filters with search functionality
const filters = ref({
  search: '',
  groupe: '',
  annee: ''
})

// Get unique groups for filter dropdown
const uniqueGroups = computed(() => {
  const groups = members.value
    .map(m => m.apprenant?.groupe?.nom)
    .filter(Boolean)
  return [...new Set(groups)].sort()
})

// Get unique years for filter dropdown (sorted newest first)
const uniqueYears = computed(() => {
  const years = members.value
    .map(m => m.apprenant?.groupe?.annee_promotion)
    .filter(Boolean)
  return [...new Set(years)].sort((a, b) => b.localeCompare(a))
})

// Enhanced filtering logic
const filteredMembers = computed(() => {
  return members.value.filter(member => {
    // Search filter (name or email)
    const searchTerm = filters.value.search.toLowerCase()
    const nameMatch = member.apprenant?.user?.name?.toLowerCase().includes(searchTerm)
    const emailMatch = member.apprenant?.user?.email?.toLowerCase().includes(searchTerm)
    const searchMatch = !filters.value.search || nameMatch || emailMatch

    // Group filter
    const groupMatch = !filters.value.groupe || member.apprenant?.groupe?.nom === filters.value.groupe

    // Year filter
    const yearMatch = !filters.value.annee || member.apprenant?.groupe?.annee_promotion === filters.value.annee

    return searchMatch && groupMatch && yearMatch
  })
})

// Check if any filters are active
const hasActiveFilters = computed(() => {
  return filters.value.search || filters.value.groupe || filters.value.annee
})

// Clear all filters
const clearFilters = () => {
  filters.value = { search: '', groupe: '', annee: '' }
}

// Get initials for avatar
const getInitials = (name) => {
  if (!name) return '?'
  return name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

// Fetch community details
const fetchDetails = async () => {
  try {
    const response = await getCommunauteById(id)
    communaute.value = response.data
  } catch (error) {
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: "Impossible d'afficher les détails de la communauté.",
      life: 3000,
    })
  }
}

// Fetch community members
const fetchMembers = async () => {
  try {
    const response = await membersByCommunaute(id)
    members.value = response.data
    console.log('Members fetched:', members.value)
  } catch (error) {
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: "Impossible de charger les membres.",
      life: 3000,
    })
  }
}

// Navigate to update page
const goToUpdate = () => {
  router.push({ name: 'communauteUpdate', params: { id } })
}

// Initialize component
onMounted(async () => {
  await Promise.all([fetchDetails(), fetchMembers()])
  loading.value = false
})
</script>

<style scoped>
/* Custom scrollbar for better aesthetics */
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

/* Smooth transitions for all interactive elements */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Focus styles for accessibility */
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

/* Hover effects for member cards */
.group:hover .font-semibold {
  color: #1e40af;
}
</style>
