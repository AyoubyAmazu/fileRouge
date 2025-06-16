<template>
  <div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="container mx-auto">
      <!-- En-tête avec boutons d'action -->
      <div class="mb-6 bg-white rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Communautés</h1>
            <p class="text-gray-600 mt-2">Gérez vos communautés et leurs membres</p>
          </div>

          <!-- Boutons d'action -->
          <div class="flex flex-col sm:flex-row gap-3">
            <button
              @click="ajouterCommunaute()"
              class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors font-medium"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
              Créer une communauté
            </button>

            <button
              @click="ajouterMembre()"
              class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors font-medium"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                <line x1="22" x2="22" y1="11" y2="13"/>
                <line x1="21" x2="23" y1="12" y2="12"/>
              </svg>
              Ajouter un membre
            </button>
          </div>
        </div>
      </div>

      <!-- Indicateur de chargement -->
      <div v-if="isLoading" class="flex flex-col items-center justify-center py-12 bg-white rounded-lg shadow mb-6">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
        <p class="text-gray-600 text-lg font-medium">Chargement des communautés...</p>
        <p class="text-gray-500 text-sm mt-2">Récupération des données en cours</p>
      </div>

      <!-- Contenu principal (masqué pendant le chargement) -->
      <div v-else>
        <!-- Barre de recherche et filtres -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow">
          <!-- Champ de recherche -->
          <div class="relative mb-4">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <!-- Icône de recherche -->
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Rechercher des communautés..."
              class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            />
            <button
              v-if="searchQuery"
              @click="searchQuery = ''"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
            >
              <!-- Icône X -->
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
          </div>

          <!-- Bouton de basculement des filtres -->
          <div class="flex justify-between items-center mb-2">
            <button
              @click="showFilters = !showFilters"
              class="flex items-center text-sm text-gray-600 hover:text-gray-900"
            >
              <!-- Icône de filtre -->
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
              {{ showFilters ? 'Masquer les filtres' : 'Afficher les filtres' }}
            </button>

            <div v-if="isFiltering" class="flex items-center">
              <span class="text-sm text-gray-600 mr-2">Filtres appliqués</span>
              <button
                @click="resetFilters"
                class="text-sm text-blue-600 hover:text-blue-800"
              >
                Tout réinitialiser
              </button>
            </div>
          </div>

          <!-- Options de filtrage -->
          <div v-if="showFilters" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-3 border-t border-gray-200">
            <!-- Filtre d'année -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Année de création
                <span v-if="filters.year !== 'all'" class="text-xs text-blue-600">({{ getFilteredCountByYear() }} résultats)</span>
              </label>
              <select
                v-model="filters.year"
                @change="currentPage = 1"
                class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
              >
                <option value="all">Toutes les années ({{ communities.length }})</option>
                <option v-for="year in availableYears" :key="year" :value="year.toString()">
                  {{ year }} ({{ getCommunitiesCountByYear(year) }})
                </option>
              </select>
            </div>

            <!-- Filtre par mois -->
            <div v-if="filters.year !== 'all'">
              <label class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
              <select
                v-model="filters.month"
                @change="currentPage = 1"
                class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
              >
                <option value="all">Tous les mois</option>
                <option v-for="month in availableMonths" :key="month.value" :value="month.value">
                  {{ month.label }}
                </option>
              </select>
            </div>

            <!-- Filtre par nombre de membres -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Membres</label>
              <select
                v-model="filters.members"
                @change="currentPage = 1"
                class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
              >
                <option value="all">Tous</option>
                <option value="1">1 membre</option>
                <option value="2-5">2-5 membres</option>
                <option value="6-10">6-10 membres</option>
                <option value="11+">11+ membres</option>
              </select>
            </div>

            <!-- Trier par -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
              <select
                v-model="sortOption"
                class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
              >
                <option value="nameAsc">Nom (A-Z)</option>
                <option value="nameDesc">Nom (Z-A)</option>
                <option value="membersAsc">Membres (Croissant)</option>
                <option value="membersDesc">Membres (Décroissant)</option>
                <option value="dateAsc">Date (Ancienne d'abord)</option>
                <option value="dateDesc">Date (Récente d'abord)</option>
                <option value="idAsc">ID (Croissant)</option>
                <option value="idDesc">ID (Décroissant)</option>
              </select>
            </div>
          </div>

          <!-- Affichage des filtres actifs -->
          <div v-if="isFiltering && !showFilters" class="flex flex-wrap gap-2 mt-3 pt-3 border-t border-gray-200">
            <div v-if="filters.year !== 'all'" class="bg-blue-100 px-2 py-1 rounded-full text-xs flex items-center text-blue-800">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
              Année: {{ filters.year }} ({{ getFilteredCountByYear() }})
              <button @click="filters.year = 'all'; filters.month = 'all'; currentPage = 1" class="ml-1 text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
              </button>
            </div>
            <div v-if="filters.month !== 'all'" class="bg-green-100 px-2 py-1 rounded-full text-xs flex items-center text-green-800">
              Mois: {{ getMonthLabel(filters.month) }}
              <button @click="filters.month = 'all'; currentPage = 1" class="ml-1 text-green-600 hover:text-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
              </button>
            </div>
            <div v-if="filters.members !== 'all'" class="bg-purple-100 px-2 py-1 rounded-full text-xs flex items-center text-purple-800">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              Membres: {{ getMembersFilterLabel() }}
              <button @click="filters.members = 'all'; currentPage = 1" class="ml-1 text-purple-600 hover:text-purple-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Tableau des communautés -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" @click="toggleMembersSort()">
                  <div class="flex items-center">
                    Membres
                    <svg v-if="sortOption.includes('members')" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1" :class="sortOption === 'membersDesc' ? 'rotate-180' : ''">
                      <path d="m7 15 5 5 5-5"/>
                      <path d="m7 9 5-5 5 5"/>
                    </svg>
                  </div>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" @click="toggleDateSort()">
                  <div class="flex items-center">
                    Date de création
                    <svg v-if="sortOption.includes('date')" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1" :class="sortOption === 'dateDesc' ? 'rotate-180' : ''">
                      <path d="m7 15 5 5 5-5"/>
                      <path d="m7 9 5-5 5 5"/>
                    </svg>
                  </div>
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="community in paginatedCommunities" :key="community.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  #{{ community.id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full" :class="getCommunityIconBg(community.id)">
                      <span class="text-white text-sm font-bold">{{ getCommunityInitials(community.nom) }}</span>
                    </div>
                    <div class="ml-3 text-sm font-medium text-gray-900">{{ community.nom }}</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-500 max-w-xs truncate">{{ community.description }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm" :class="isMembersFiltered(community) ? 'text-purple-600 bg-purple-50 font-medium' : 'text-gray-900'">
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-gray-400">
                      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                      <circle cx="9" cy="7" r="4"/>
                      <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                      <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span class="font-medium">{{ community.members }}</span>
                    <span class="ml-1 text-xs text-gray-500">{{ community.members === 1 ? 'membre' : 'membres' }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm" :class="isDateFiltered(community) ? 'text-blue-600 bg-blue-50 font-medium' : 'text-gray-900'">
                  <div class="flex flex-col">
                    <span>{{ formatDate(community.created_at) }}</span>
                    <span class="text-xs text-gray-400">{{ formatTime(community.created_at) }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex justify-center gap-3">
                    <button
                      @click="viewCommunity(community)"
                      class="p-1.5 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors"
                      title="Voir"
                    >
                      <!-- Icône œil -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <button
                      @click="editCommunity(community)"
                      class="p-1.5 rounded-full bg-amber-100 text-amber-600 hover:bg-amber-200 transition-colors"
                      title="Modifier"
                    >
                      <!-- Icône modifier -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                    </button>
                    <button
                      @click="deleteCommunity(community)"
                      class="p-1.5 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition-colors"
                      title="Supprimer"
                    >
                      <!-- Icône corbeille -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- État vide -->
        <div v-if="paginatedCommunities.length === 0 && !isLoading" class="text-center py-10 bg-white rounded-lg shadow mt-4">
          <!-- Icône boîte de réception -->
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          <p class="mt-2 text-gray-500">Aucune communauté trouvée correspondant à vos critères.</p>
          <div class="mt-4 space-y-2">
            <p class="text-sm text-gray-400">Critères actuels :</p>
            <div class="flex flex-wrap justify-center gap-2">
              <span v-if="searchQuery" class="px-2 py-1 bg-gray-100 rounded text-xs">Recherche: "{{ searchQuery }}"</span>
              <span v-if="filters.year !== 'all'" class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Année: {{ filters.year }}</span>
              <span v-if="filters.month !== 'all'" class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Mois: {{ getMonthLabel(filters.month) }}</span>
              <span v-if="filters.members !== 'all'" class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs">Membres: {{ getMembersFilterLabel() }}</span>
            </div>
          </div>
          <button
            @click="resetFilters"
            class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
          >
            Réinitialiser les filtres
          </button>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && paginatedCommunities.length > 0" class="flex flex-col sm:flex-row justify-between items-center mt-6 bg-white p-4 rounded-lg shadow gap-4">
          <div class="text-sm text-gray-700">
            Affichage de <span class="font-medium">{{ startItem }}</span> à <span class="font-medium">{{ endItem }}</span> sur <span class="font-medium">{{ totalFilteredItems }}</span> communautés
            <span v-if="filters.year !== 'all'" class="text-blue-600">
              (filtrées par année {{ filters.year }})
            </span>
          </div>

          <div class="flex items-center gap-4">
            <!-- Sélecteur d'éléments par page -->
            <div class="flex items-center gap-2">
              <label class="text-sm text-gray-700">Afficher:</label>
              <select
                v-model="itemsPerPage"
                class="px-2 py-1 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
              >
                <option :value="5">5</option>
                <option :value="10">10</option>
                <option :value="20">20</option>
                <option :value="50">50</option>
              </select>
            </div>

            <!-- Navigation des pages -->
            <div class="flex items-center gap-2">
              <button
                @click="goToPage(1)"
                :disabled="currentPage === 1"
                class="px-3 py-1 border rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Premier
              </button>
              <button
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="px-3 py-1 border rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <!-- Icône flèche gauche -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline"><path d="m15 18-6-6 6-6"/></svg>
              </button>

              <!-- Numéros de page -->
              <div class="flex items-center gap-1">
                <span v-for="page in visiblePages" :key="page" class="px-3 py-1">
                  <button
                    v-if="page !== '...'"
                    @click="goToPage(page)"
                    :class="[
                      'px-3 py-1 rounded-md text-sm font-medium',
                      currentPage === page
                        ? 'bg-gray-800 text-white'
                        : 'bg-white text-gray-700 hover:bg-gray-50 border'
                    ]"
                  >
                    {{ page }}
                  </button>
                  <span v-else class="text-gray-500">...</span>
                </span>
              </div>

              <button
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 border rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <!-- Icône flèche droite -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline"><path d="m9 18 6-6-6-6"/></svg>
              </button>
              <button
                @click="goToPage(totalPages)"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 border rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Dernier
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Message d'erreur (optionnel) -->
      <div v-if="hasError" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 mr-2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" x2="9" y1="9" y2="15"/>
            <line x1="9" x2="15" y1="9" y2="15"/>
          </svg>
          <div>
            <h3 class="text-red-800 font-medium">Erreur de chargement</h3>
            <p class="text-red-600 text-sm mt-1">Impossible de charger les communautés. Veuillez réessayer.</p>
          </div>
        </div>
        <button
          @click="communautesList"
          class="mt-3 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm"
        >
          Réessayer
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { getCommunaute,deleteCommunaute } from '../../service/communaute.service'
import { countMemberOfCommunaute } from '../../service/communauteMembers.service'
import { useToast } from 'primevue/usetoast';
const toast = useToast();

// État de chargement et d'erreur
const isLoading = ref(false)
const hasError = ref(false)
const router = useRouter();

// Données des communautés
const communities = ref([])

const communautesList = async () => {
  isLoading.value = true
  hasError.value = false

  try {
    // Récupération des communautés
    const res = await getCommunaute()
    communities.value = res.data
    // Récupération du nombre de membres pour chaque communauté
    for (const community of communities.value) {
      try {
        const members = await countMemberOfCommunaute(community.id)
        community.members = members.data.count
      } catch (memberError) {
        console.warn(`Erreur lors de la récupération des membres pour la communauté ${community.id}:`, memberError)
        community.members = 0 // Valeur par défaut en cas d'erreur
      }
    }
    console.log('Communautés récupérées:', communities.value)
  } catch (error) {
    console.error('Erreur lors de la récupération des communautés:', error)
    hasError.value = true
  } finally {
    isLoading.value = false
  }
}

const supprimeCommunaute = async (community) =>{
    try{
    const  response = await deleteCommunaute(community)
    toast.add({ severity: 'success', summary: 'Succès', detail: response.data.message , life: 3000 });    console.log('Communauté supprimée:', response.data)
    }catch (error) {
      console.error('Erreur lors de la suppression de la communauté:', error)
    }


}
onMounted(() => {
  communautesList()
})

// Recherche, filtres et pagination
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(5)
const showFilters = ref(false)
const sortOption = ref('dateDesc')

// Options de filtrage
const filters = ref({
  year: 'all',
  month: 'all',
  members: 'all'
})

// Couleurs pour les icônes
const iconColors = [
  'bg-purple-600', 'bg-blue-600', 'bg-green-600', 'bg-red-600',
  'bg-yellow-600', 'bg-pink-600', 'bg-indigo-600', 'bg-teal-600'
]

// Mois en français
const monthNames = [
  { value: '01', label: 'Janvier' },
  { value: '02', label: 'Février' },
  { value: '03', label: 'Mars' },
  { value: '04', label: 'Avril' },
  { value: '05', label: 'Mai' },
  { value: '06', label: 'Juin' },
  { value: '07', label: 'Juillet' },
  { value: '08', label: 'Août' },
  { value: '09', label: 'Septembre' },
  { value: '10', label: 'Octobre' },
  { value: '11', label: 'Novembre' },
  { value: '12', label: 'Décembre' }
]

// Fonctions utilitaires
const getCommunityYear = (community) => {
  return new Date(community.created_at).getFullYear().toString()
}

const getCommunityMonth = (community) => {
  return String(new Date(community.created_at).getMonth() + 1).padStart(2, '0')
}

const getCommunityInitials = (nom) => {
  return nom.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}

const getCommunityIconBg = (id) => {
  return iconColors[id % iconColors.length]
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatTime = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleTimeString('fr-FR', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getMonthLabel = (monthValue) => {
  const month = monthNames.find(m => m.value === monthValue)
  return month ? month.label : monthValue
}

const getMembersFilterLabel = () => {
  switch (filters.value.members) {
    case '1': return '1 membre'
    case '2-5': return '2-5 membres'
    case '6-10': return '6-10 membres'
    case '11+': return '11+ membres'
    default: return 'Tous'
  }
}

const isDateFiltered = (community) => {
  const year = getCommunityYear(community)
  const month = getCommunityMonth(community)
  return (filters.value.year !== 'all' && year === filters.value.year) ||
         (filters.value.month !== 'all' && month === filters.value.month)
}

const isMembersFiltered = (community) => {
  return filters.value.members !== 'all' && matchesMembersFilter(community)
}

const matchesMembersFilter = (community) => {
  switch (filters.value.members) {
    case '1': return community.members === 1
    case '2-5': return community.members >= 2 && community.members <= 5
    case '6-10': return community.members >= 6 && community.members <= 10
    case '11+': return community.members >= 11
    default: return true
  }
}

const getCommunitiesCountByYear = (year) => {
  return communities.value.filter(community =>
    getCommunityYear(community) === year.toString()
  ).length
}

const getFilteredCountByYear = () => {
  if (filters.value.year === 'all') return 0
  return filteredCommunities.value.length
}

// Obtenir les années uniques des communautés
const availableYears = computed(() => {
  const years = communities.value.map(community =>
    new Date(community.created_at).getFullYear()
  )
  return [...new Set(years)].sort((a, b) => b - a)
})

// Obtenir les mois disponibles pour l'année sélectionnée
const availableMonths = computed(() => {
  if (filters.value.year === 'all') return []

  const monthsInYear = communities.value
    .filter(community => getCommunityYear(community) === filters.value.year)
    .map(community => getCommunityMonth(community))

  const uniqueMonths = [...new Set(monthsInYear)]

  return monthNames.filter(month => uniqueMonths.includes(month.value))
    .sort((a, b) => parseInt(a.value) - parseInt(b.value))
})

// Vérifier si des filtres sont appliqués
const isFiltering = computed(() => {
  return filters.value.year !== 'all' ||
         filters.value.month !== 'all' ||
         filters.value.members !== 'all'
})

// Fonctions de tri
const toggleDateSort = () => {
  if (sortOption.value === 'dateAsc') {
    sortOption.value = 'dateDesc'
  } else {
    sortOption.value = 'dateAsc'
  }
}

const toggleMembersSort = () => {
  if (sortOption.value === 'membersAsc') {
    sortOption.value = 'membersDesc'
  } else {
    sortOption.value = 'membersAsc'
  }
}

// Réinitialiser tous les filtres
const resetFilters = () => {
  filters.value.year = 'all'
  filters.value.month = 'all'
  filters.value.members = 'all'
  searchQuery.value = ''
  sortOption.value = 'dateDesc'
  currentPage.value = 1
}

// Appliquer les filtres et la recherche
const filteredCommunities = computed(() => {
  return communities.value.filter(community => {
    // Filtre de recherche
    const matchesSearch = searchQuery.value === '' ||
      community.nom.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      community.description.toLowerCase().includes(searchQuery.value.toLowerCase())

    // Filtre d'année
    const communityYear = getCommunityYear(community)
    const matchesYear = filters.value.year === 'all' || communityYear === filters.value.year

    // Filtre de mois
    const communityMonth = getCommunityMonth(community)
    const matchesMonth = filters.value.month === 'all' || communityMonth === filters.value.month

    // Filtre de membres
    const matchesMembers = matchesMembersFilter(community)

    return matchesSearch && matchesYear && matchesMonth && matchesMembers
  })
})

// Trier les communautés filtrées
const filteredAndSortedCommunities = computed(() => {
  const communities = [...filteredCommunities.value]

  switch (sortOption.value) {
    case 'nameAsc':
      return communities.sort((a, b) => a.nom.localeCompare(b.nom))
    case 'nameDesc':
      return communities.sort((a, b) => b.nom.localeCompare(a.nom))
    case 'membersAsc':
      return communities.sort((a, b) => a.members - b.members)
    case 'membersDesc':
      return communities.sort((a, b) => b.members - a.members)
    case 'dateAsc':
      return communities.sort((a, b) => new Date(a.created_at) - new Date(b.created_at))
    case 'dateDesc':
      return communities.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    case 'idAsc':
      return communities.sort((a, b) => a.id - b.id)
    case 'idDesc':
      return communities.sort((a, b) => b.id - a.id)
    default:
      return communities
  }
})

// Calculs de pagination
const totalFilteredItems = computed(() => filteredAndSortedCommunities.value.length)
const totalPages = computed(() => Math.ceil(totalFilteredItems.value / itemsPerPage.value))
const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endItem = computed(() => Math.min(currentPage.value * itemsPerPage.value, totalFilteredItems.value))

// Communautés paginées
const paginatedCommunities = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredAndSortedCommunities.value.slice(start, end)
})

// Numéros de page visibles pour la pagination
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
const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}

// Surveiller les changements de filtres et réinitialiser à la première page
watch([searchQuery, filters, sortOption, itemsPerPage], () => {
  currentPage.value = 1
}, { deep: true })

// Réinitialiser le filtre de mois quand l'année change
watch(() => filters.value.year, () => {
  filters.value.month = 'all'
})

// Méthode d'ajout de communauté
const ajouterCommunaute = () => {
  router.push({ name: 'communauteCreation' })
}

// Méthode d'ajout de membre
const ajouterMembre = () => {
  // Vous pouvez rediriger vers une page d'ajout de membre
  // ou ouvrir une modal
  alert('Redirection vers la page d\'ajout de membre')
  // Exemple de redirection :
  // router.push({ name: 'ajouterMembre' })
}

// Méthodes d'action
const viewCommunity = (community) => {
    router.push({ name: 'communauteDetail', params: { id: community.id } })
}

const editCommunity = (community) => {
    router.push({ name: 'communauteUpdate', params: { id: community.id } })
}

const deleteCommunity = async (community) => {
  if (confirm(`Êtes-vous sûr de vouloir supprimer ${community.nom} ?`)) {
   await supprimeCommunaute(community.id)
    communities.value = communities.value.filter(c => c.id !== community.id)
  }
}
</script>

<style scoped>
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
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
</style>
