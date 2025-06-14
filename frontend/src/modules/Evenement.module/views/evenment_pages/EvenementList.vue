<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <Toast />
    <div class="container mx-auto max-w-7xl">
      <!-- En-tête avec statistiques -->
      <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des Événements</h1>
            <p class="text-gray-600">Organisez et gérez vos événements facilement</p>
          </div>
          <button 
            @click="ajouterEvent()" 
            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14"/>
              <path d="m12 5 7 7-7 7"/>
            </svg>
            <span class="font-medium">Nouvel événement</span>
          </button>
        </div>
      </div>

      <!-- Indicateur de chargement -->
      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl shadow-sm mb-6">
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
        <p class="text-gray-700 text-lg font-medium mt-4">Chargement des événements...</p>
        <p class="text-gray-500 text-sm mt-2">Récupération des données en cours</p>
      </div>

      <!-- Message d'erreur -->
      <div v-if="hasError" class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" x2="9" y1="9" y2="15"/>
                <line x1="9" x2="15" y1="9" y2="15"/>
              </svg>
            </div>
          </div>
          <div class="ml-4 flex-1">
            <h3 class="text-red-800 font-semibold text-lg">Erreur de chargement</h3>
            <p class="text-red-700 mt-1">Impossible de charger les événements. Vérifiez votre connexion et réessayez.</p>
            <button 
              @click="loadData" 
              class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium"
            >
              Réessayer
            </button>
          </div>
        </div>
      </div>

      <!-- Contenu principal -->
      <div v-else-if="!isLoading">
        <!-- Barre de recherche et filtres -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
          <!-- Barre de recherche -->
          <div class="relative mb-6">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.3-4.3"/>
              </svg>
            </div>
            <input 
              type="text" 
              v-model="searchQuery" 
              placeholder="Rechercher des événements par titre, description ou lieu..." 
              class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 placeholder-gray-500"
            />
            <button 
              v-if="searchQuery" 
              @click="searchQuery = ''" 
              class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
              </svg>
            </button>
          </div>

          <!-- Filtres -->
          <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
              <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Année :
              </label>
              <select 
                v-model="selectedYear" 
                class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Toutes les années</option>
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <label class="text-sm font-medium text-gray-700">Statut :</label>
              <select 
                v-model="selectedStatus" 
                class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Tous les statuts</option>
                <option value="upcoming">À venir</option>
                <option value="ongoing">En cours</option>
                <option value="completed">Terminés</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <label class="text-sm font-medium text-gray-700">Trier par :</label>
              <select 
                v-model="sortBy" 
                class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="date_asc">Date (Plus proche)</option>
                <option value="date_desc">Date (Plus éloignée)</option>
                <option value="title_asc">Titre (A-Z)</option>
                <option value="title_desc">Titre (Z-A)</option>
                <option value="created_desc">Récemment créé</option>
              </select>
            </div>
            
            <!-- Bouton de réinitialisation des filtres -->
            <button 
              v-if="hasActiveFilters"
              @click="resetFilters" 
              class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Réinitialiser
            </button>
          </div>

          <!-- Filtres actifs -->
          <div v-if="hasActiveFilters" class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
            <div v-if="searchQuery" class="bg-purple-100 px-3 py-1 rounded-full text-sm flex items-center text-purple-800">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.3-4.3"/>
              </svg>
              Recherche: "{{ searchQuery }}"
              <button @click="searchQuery = ''" class="ml-2 text-purple-600 hover:text-purple-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"/>
                  <path d="m6 6 12 12"/>
                </svg>
              </button>
            </div>
            
            <div v-if="selectedYear" class="bg-blue-100 px-3 py-1 rounded-full text-sm flex items-center text-blue-800">
              Année: {{ selectedYear }}
              <button @click="selectedYear = ''" class="ml-2 text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"/>
                  <path d="m6 6 12 12"/>
                </svg>
              </button>
            </div>

            <div v-if="selectedStatus" class="bg-green-100 px-3 py-1 rounded-full text-sm flex items-center text-green-800">
              Statut: {{ getStatusLabel(selectedStatus) }}
              <button @click="selectedStatus = ''" class="ml-2 text-green-600 hover:text-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"/>
                  <path d="m6 6 12 12"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Liste des événements -->
        <div class="grid gap-6">
          <div 
            v-for="event in paginatedEvents" 
            :key="event.id" 
            class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 hover:border-gray-200"
          >
            <div class="p-6">
              <div class="flex items-start justify-between">
                <!-- Informations de l'événement -->
                <div class="flex-1">
                  <div class="flex items-center gap-4 mb-3">
                    <div class="flex-shrink-0 h-14 w-14 flex items-center justify-center rounded-xl" :class="getEventStatusBg(event)">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                      </svg>
                    </div>
                    <div class="flex-1">
                      <div class="flex items-center gap-3 mb-1">
                        <h3 class="text-xl font-semibold text-gray-900">{{ event.titre }}</h3>
                        <span :class="getEventStatusClasses(event)">
                          {{ getEventStatus(event) }}
                        </span>
                      </div>
                      <p class="text-sm text-gray-500">ID: #{{ event.id }}</p>
                    </div>
                  </div>
                  
                  <p class="text-gray-600 mb-4 leading-relaxed">{{ event.description }}</p>
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <!-- Date -->
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                      <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                          <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                          <line x1="16" x2="16" y1="2" y2="6"/>
                          <line x1="8" x2="8" y1="2" y2="6"/>
                          <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                      </div>
                      <div>
                        <div class="font-medium text-gray-900">{{ formatEventDate(event) }}</div>
                        <div class="text-gray-500">{{ getEventDuration(event) }}</div>
                      </div>
                    </div>
                    
                    <!-- Lieu -->
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                      <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                          <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                          <circle cx="12" cy="10" r="3"/>
                        </svg>
                      </div>
                      <div>
                        <div class="font-medium text-gray-900">{{ event.lieu }}</div>
                        <div class="text-gray-500">Lieu de l'événement</div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col gap-2 ml-4">
                  <button 
                    @click="showDetails(event)" 
                    class="p-3 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors group"
                    title="Voir les détails"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                      <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                  <button 
                    @click="showDeleteConfirmation(event)" 
                    class="p-3 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors group"
                    title="Supprimer"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                      <path d="M3 6h18"/>
                      <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                      <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                      <line x1="10" x2="10" y1="11" y2="17"/>
                      <line x1="14" x2="14" y1="11" y2="17"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- État vide -->
        <div v-if="paginatedEvents.length === 0 && !isLoading" class="text-center py-16 bg-white rounded-2xl shadow-sm">
          <div class="h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
              <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
              <line x1="16" x2="16" y1="2" y2="6"/>
              <line x1="8" x2="8" y1="2" y2="6"/>
              <line x1="3" x2="21" y1="10" y2="10"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun événement trouvé</h3>
          <p class="text-gray-500 mb-6">
            {{ getEmptyStateMessage() }}
          </p>
          <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button 
              @click="ajouterEvent()" 
              class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors"
            >
              Créer un événement
            </button>
            <button 
              v-if="hasActiveFilters"
              @click="resetFilters" 
              class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-xl font-medium transition-colors"
            >
              Réinitialiser les filtres
            </button>
          </div>
        </div>

        <!-- Pagination améliorée -->
        <div v-if="!isLoading && paginatedEvents.length > 0" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-sm text-gray-700">
              Affichage de <span class="font-semibold text-gray-900">{{ startItem }}</span> à <span class="font-semibold text-gray-900">{{ endItem }}</span> sur <span class="font-semibold text-gray-900">{{ totalFilteredItems }}</span> événements
              <span v-if="hasActiveFilters" class="text-blue-600 ml-1">(filtrés)</span>
            </div>
            
            <div class="flex items-center gap-6">
              <!-- Sélecteur d'éléments par page -->
              <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Afficher:</label>
                <select 
                  v-model="pageSize" 
                  class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                  <option :value="4">4</option>
                  <option :value="8">8</option>
                  <option :value="12">12</option>
                  <option :value="20">20</option>
                </select>
              </div>
              
              <!-- Navigation des pages -->
              <div class="flex items-center gap-2">
                <button 
                  @click="goToPage(currentPage - 1)"
                  :disabled="currentPage === 1"
                  class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                  </svg>
                </button>
                
                <div class="flex items-center gap-1">
                  <button 
                    v-for="page in visiblePages" 
                    :key="page"
                    v-if="page !== '...'"
                    @click="goToPage(page)"
                    :class="[
                      'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                      currentPage === page
                        ? 'bg-blue-600 text-white'
                        : 'text-gray-700 hover:bg-gray-100'
                    ]"
                  >
                    {{ page }}
                  </button>
                  <span v-else class="px-2 text-gray-500">...</span>
                </div>
                
                <button 
                  @click="goToPage(currentPage + 1)"
                  :disabled="currentPage === totalPages"
                  class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal de confirmation de suppression -->
      <div 
        v-if="showDeleteModal" 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
        @click="closeDeleteModal"
      >
        <div 
          class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-100"
          @click.stop
        >
          <!-- En-tête de la modal -->
          <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-4">
              <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                  <path d="M3 6h18"/>
                  <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                  <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                  <line x1="10" x2="10" y1="11" y2="17"/>
                  <line x1="14" x2="14" y1="11" y2="17"/>
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Confirmer la suppression</h3>
                <p class="text-sm text-gray-500">Cette action est irréversible</p>
              </div>
            </div>
          </div>

          <!-- Contenu de la modal -->
          <div class="p-6">
            <div class="mb-4">
              <p class="text-gray-700 mb-3">
                Êtes-vous sûr de vouloir supprimer l'événement suivant ?
              </p>
              
              <!-- Aperçu de l'événement à supprimer -->
              <div v-if="eventToDelete" class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <div class="flex items-center gap-3 mb-2">
                  <div class="h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                      <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                      <line x1="16" x2="16" y1="2" y2="6"/>
                      <line x1="8" x2="8" y1="2" y2="6"/>
                      <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-900">{{ eventToDelete.titre }}</h4>
                    <p class="text-sm text-gray-500">ID: #{{ eventToDelete.id }}</p>
                  </div>
                </div>
                
                <div class="text-sm text-gray-600 space-y-1">
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                      <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                      <line x1="16" x2="16" y1="2" y2="6"/>
                      <line x1="8" x2="8" y1="2" y2="6"/>
                      <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                    <span>{{ formatEventDate(eventToDelete) }}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                      <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                      <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>{{ eventToDelete.lieu }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Avertissement -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
              <div class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 mt-0.5 flex-shrink-0">
                  <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                  <path d="M12 9v4"/>
                  <path d="M12 17h.01"/>
                </svg>
                <div class="text-sm">
                  <p class="font-medium text-red-800">Attention !</p>
                  <p class="text-red-700 mt-1">
                    Cette action supprimera définitivement l'événement et toutes les données associées. 
                    Cette opération ne peut pas être annulée.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions de la modal -->
          <div class="flex gap-3 p-6 pt-0">
            <button 
              @click="closeDeleteModal"
              class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-colors"
              :disabled="isDeleting"
            >
              Annuler
            </button>
            <button 
              @click="confirmDelete"
              :disabled="isDeleting"
              class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <svg 
                v-if="isDeleting" 
                class="animate-spin h-4 w-4" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24"
              >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ isDeleting ? 'Suppression...' : 'Supprimer définitivement' }}</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { ref, onMounted, computed, watch } from 'vue'
import { getEvents, getEventsYears, deleteEvent } from '@/modules/Evenement.module/service/event.service.js'
import { useToast } from 'primevue/usetoast'
import Toast from 'primevue/toast'

// État de chargement et d'erreur
const isLoading = ref(false)
const hasError = ref(false)

const toast = useToast()
const router = useRouter()
const events = ref([])
const selectedYear = ref('')
const selectedStatus = ref('')
const searchQuery = ref('')
const sortBy = ref('date_asc')
const years = ref([])
const currentPage = ref(1)
const pageSize = ref(8)

// Variables pour la modal de suppression
const showDeleteModal = ref(false)
const eventToDelete = ref(null)
const isDeleting = ref(false)

// Fonctions utilitaires pour l'affichage
const formatEventDate = (event) => {
  const startDate = new Date(event.date_debut)
  const endDate = new Date(event.date_fin)
  
  if (event.date_debut === event.date_fin) {
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

const getEventDuration = (event) => {
  const startDate = new Date(event.date_debut)
  const endDate = new Date(event.date_fin)
  const diffTime = Math.abs(endDate - startDate)
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1
  
  if (diffDays === 1) {
    return "1 jour"
  } else {
    return `${diffDays} jours`
  }
}

const getEventStatus = (event) => {
  const today = new Date()
  const startDate = new Date(event.date_debut)
  const endDate = new Date(event.date_fin)
  
  today.setHours(0, 0, 0, 0)
  startDate.setHours(0, 0, 0, 0)
  endDate.setHours(23, 59, 59, 999)
  
  if (today < startDate) {
    return 'À venir'
  } else if (today >= startDate && today <= endDate) {
    return 'En cours'
  } else {
    return 'Terminé'
  }
}

const getEventStatusClasses = (event) => {
  const status = getEventStatus(event)
  const classes = {
    'À venir': 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800',
    'En cours': 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800',
    'Terminé': 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800'
  }
  return classes[status] || classes['À venir']
}

const getEventStatusBg = (event) => {
  const status = getEventStatus(event)
  const classes = {
    'À venir': 'bg-blue-600',
    'En cours': 'bg-green-600',
    'Terminé': 'bg-gray-600'
  }
  return classes[status] || 'bg-blue-600'
}

const getStatusLabel = (status) => {
  const labels = {
    'upcoming': 'À venir',
    'ongoing': 'En cours',
    'completed': 'Terminés'
  }
  return labels[status] || status
}

const getEmptyStateMessage = () => {
  if (searchQuery.value) {
    return `Aucun événement ne correspond à votre recherche "${searchQuery.value}"`
  }
  if (selectedYear.value) {
    return `Aucun événement trouvé pour l'année ${selectedYear.value}`
  }
  if (selectedStatus.value) {
    return `Aucun événement ${getStatusLabel(selectedStatus.value).toLowerCase()}`
  }
  return 'Commencez par créer votre premier événement'
}

// Fonctions pour la modal de suppression
const showDeleteConfirmation = (event) => {
  eventToDelete.value = event
  showDeleteModal.value = true
}

const resetDeleteModal = () => {
  showDeleteModal.value = false
  eventToDelete.value = null
  isDeleting.value = false
}

const closeDeleteModal = () => {
  if (!isDeleting.value) {
    resetDeleteModal()
  }
}

const confirmDelete = async () => {
  if (!eventToDelete.value || isDeleting.value) return
  
  isDeleting.value = true
  
  try {
    const res = await deleteEvent(eventToDelete.value.id)
    toast.add({ 
      severity: 'success', 
      summary: 'Succès', 
      detail: res.data.message || 'Événement supprimé avec succès', 
      life: 3000 
    })
    
    // Recharger la liste des événements
    await EventsList(selectedYear.value)
    
    // Fermer la modal après succès
    showDeleteModal.value = false
    eventToDelete.value = null
    
  } catch (error) {
    toast.add({ 
      severity: 'error', 
      summary: 'Erreur', 
      detail: error.response?.data?.message || 'Erreur lors de la suppression', 
      life: 3000 
    })
    console.error('Error deleting event:', error)
  } finally {
    isDeleting.value = false
  }
}

// Filtres actifs
const hasActiveFilters = computed(() => {
  return searchQuery.value || selectedYear.value || selectedStatus.value
})

const resetFilters = () => {
  searchQuery.value = ''
  selectedYear.value = ''
  selectedStatus.value = ''
  sortBy.value = 'date_asc'
  currentPage.value = 1
}

// Fonction de suppression avec gestion d'erreur
const eventDerstroy = async (id) => {
  try {
    const res = await deleteEvent(id)
    toast.add({ 
      severity: 'success', 
      summary: 'Succès', 
      detail: res.data.message || 'Événement supprimé avec succès', 
      life: 3000 
    })
    await EventsList(selectedYear.value)
  } catch (error) {
    toast.add({ 
      severity: 'error', 
      summary: 'Erreur', 
      detail: error.response?.data?.message || 'Erreur lors de la suppression', 
      life: 3000 
    })
    console.error('Error deleting event:', error)
  }
}

// Chargement des événements avec état de loading
const EventsList = async (year = null) => {
  isLoading.value = true
  hasError.value = false
  
  try {
    const res = await getEvents(year)
    events.value = res.data
    console.log("Events List:", res.data)
  } catch (error) {
    console.error('Error fetching events:', error)
    hasError.value = true
    toast.add({ 
      severity: 'error', 
      summary: 'Erreur', 
      detail: 'Impossible de charger les événements', 
      life: 3000 
    })
  } finally {
    isLoading.value = false
  }
}

// Chargement des années avec gestion d'erreur
const EventsYears = async () => {
  try {
    const res = await getEventsYears()
    years.value = res.data
    console.log("Events Years:", res.data)
  } catch (error) {
    console.error('Error fetching events years:', error)
    toast.add({ 
      severity: 'warn', 
      summary: 'Attention', 
      detail: 'Impossible de charger les filtres par année', 
      life: 3000 
    })
  }
}

// Fonction pour recharger toutes les données
const loadData = async () => {
  await Promise.all([
    EventsList(selectedYear.value),
    EventsYears()
  ])
}

// Computed properties pour le filtrage et tri
const filteredEvents = computed(() => {
  let filtered = events.value

  // Filtre par recherche
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(event => 
      event.titre.toLowerCase().includes(query) ||
      event.description.toLowerCase().includes(query) ||
      event.lieu.toLowerCase().includes(query)
    )
  }

  // Filtre par année
  if (selectedYear.value) {
    filtered = filtered.filter(event => 
      String(event.date_debut).startsWith(selectedYear.value)
    )
  }

  // Filtre par statut
  if (selectedStatus.value) {
    filtered = filtered.filter(event => {
      const status = getEventStatus(event)
      return (
        (selectedStatus.value === 'upcoming' && status === 'À venir') ||
        (selectedStatus.value === 'ongoing' && status === 'En cours') ||
        (selectedStatus.value === 'completed' && status === 'Terminé')
      )
    })
  }

  // Tri
  return filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'date_asc':
        return new Date(a.date_debut) - new Date(b.date_debut)
      case 'date_desc':
        return new Date(b.date_debut) - new Date(a.date_debut)
      case 'title_asc':
        return a.titre.localeCompare(b.titre)
      case 'title_desc':
        return b.titre.localeCompare(a.titre)
      case 'created_desc':
        return new Date(b.created_at || 0) - new Date(a.created_at || 0)
      default:
        return 0
    }
  })
})

const totalFilteredItems = computed(() => filteredEvents.value.length)
const totalPages = computed(() => Math.ceil(totalFilteredItems.value / pageSize.value) || 1)
const startItem = computed(() => (currentPage.value - 1) * pageSize.value + 1)
const endItem = computed(() => Math.min(currentPage.value * pageSize.value, totalFilteredItems.value))

const paginatedEvents = computed(() => {
  const start = (currentPage.value - 1) * pageSize.value
  return filteredEvents.value.slice(start, start + pageSize.value)
})

// Pagination visible
const visiblePages = computed(() => {
  const pages = []
  const total = totalPages.value
  const current = currentPage.value

  if (total <= 7) {
    for (let i = 1; i <= total; i++) {
      pages.push(i)
    }
  } else {
    pages.push(1)
    
    if (current > 4) {
      pages.push('...')
    }
    
    const start = Math.max(2, current - 1)
    const end = Math.min(total - 1, current + 1)
    
    for (let i = start; i <= end; i++) {
      if (!pages.includes(i)) {
        pages.push(i)
      }
    }
    
    if (current < total - 3) {
      pages.push('...')
    }
    
    if (!pages.includes(total)) {
      pages.push(total)
    }
  }

  return pages
})

// Fonctions de navigation
function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}

function ajouterEvent() {
  router.push({ name: 'evenementCreation' })
}

function showDetails(event) {
  router.push({ name: 'evenementDetail', params: { id: event.id } })
}

// Initialisation
onMounted(() => {
  loadData()
})
</script>

<style scoped>
/* Animation d'entrée pour la modal */
.modal-enter-active, .modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
  opacity: 0;
  transform: scale(0.9);
}

/* Empêcher le scroll du body quand la modal est ouverte */
.modal-open {
  overflow: hidden;
}

/* Animation pour le spinner */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Transitions fluides */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>
