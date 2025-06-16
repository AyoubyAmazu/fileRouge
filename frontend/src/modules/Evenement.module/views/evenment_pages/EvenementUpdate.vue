<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
    <!-- Éléments décoratifs de fond -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-purple-600/20 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-green-400/20 to-blue-600/20 rounded-full blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-purple-400/10 to-pink-600/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Indicateur de chargement -->
    <div v-if="isLoading" class="relative z-10 flex flex-col items-center justify-center min-h-screen">
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
      <p class="text-gray-500 text-sm mt-2">Récupération des données en cours</p>
    </div>

    <div v-else class="relative z-10 py-8 px-4">
      <div class="container mx-auto max-w-7xl">
        <!-- En-tête amélioré -->
        <div class="mb-8">
          <div class="flex items-center gap-4 mb-6">
            <button
              @click="$router.go(-1)"
              class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-all duration-200 hover:bg-white/50 px-3 py-2 rounded-lg backdrop-blur-sm"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
              </svg>
              <span class="font-medium">Retour</span>
            </button>
          </div>

          <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-600 rounded-2xl mb-6 shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                <path d="m15 5 4 4"/>
              </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
              Modifier l'événement
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
              Mettez à jour les informations de votre événement et ajustez le programme selon vos besoins
            </p>
          </div>
        </div>

        <form @submit.prevent="handleUpdate">
          <!-- Section informations générales -->
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            <!-- Formulaire principal -->
            <div class="xl:col-span-2">
              <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8">
                <div class="flex items-center gap-4 mb-8">
                  <div class="h-16 w-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                      <circle cx="12" cy="12" r="10"/>
                      <path d="M12 16v-4"/>
                      <path d="M12 8h.01"/>
                    </svg>
                  </div>
                  <div>
                    <h2 class="text-2xl font-bold text-gray-900">Informations générales</h2>
                    <p class="text-gray-600">Modifiez les détails principaux de votre événement</p>
                  </div>
                </div>

                <div class="space-y-8">
                  <!-- Titre -->
                  <div>
                    <label for="titre" class="block text-sm font-semibold text-gray-700 mb-3">
                      Titre de l'événement *
                    </label>
                    <input
                      id="titre"
                      v-model="event.titre"
                      type="text"
                      required
                      placeholder="Ex: Conférence annuelle 2024"
                      class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-lg"
                    />
                  </div>

                  <!-- Description -->
                  <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                      Description
                    </label>
                    <textarea
                      id="description"
                      v-model="event.description"
                      rows="5"
                      placeholder="Décrivez votre événement, ses objectifs et ce que les participants peuvent attendre..."
                      class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 resize-none text-lg"
                    ></textarea>
                  </div>

                  <!-- Lieu -->
                  <div>
                    <label for="lieu" class="block text-sm font-semibold text-gray-700 mb-3">
                      Lieu *
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                          <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                          <circle cx="12" cy="10" r="3"/>
                        </svg>
                      </div>
                      <input
                        id="lieu"
                        v-model="event.lieu"
                        type="text"
                        required
                        placeholder="Ex: Centre de conférences, Paris"
                        class="w-full pl-16 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-lg"
                      />
                    </div>
                  </div>

                  <!-- Dates -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label for="date_debut" class="block text-sm font-semibold text-gray-700 mb-3">
                        Date de début *
                      </label>
                      <input
                        id="date_debut"
                        v-model="event.date_debut"
                        type="date"
                        required
                        class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-lg"
                      />
                    </div>

                    <div>
                      <label for="date_fin" class="block text-sm font-semibold text-gray-700 mb-3">
                        Date de fin *
                      </label>
                      <input
                        id="date_fin"
                        v-model="event.date_fin"
                        type="date"
                        :min="event.date_debut"
                        required
                        class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-lg"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Panneau d'informations -->
            <div class="xl:col-span-1">
              <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 border border-amber-100">
                <div class="text-center mb-6">
                  <div class="h-16 w-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                      <circle cx="12" cy="12" r="10"/>
                      <path d="M12 16v-4"/>
                      <path d="M12 8h.01"/>
                    </svg>
                  </div>
                  <h3 class="text-xl font-bold text-gray-900 mb-2">Modification en cours</h3>
                </div>

                <div class="space-y-4">
                  <div class="flex items-start gap-3">
                    <div class="h-6 w-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                        <path d="M20 6 9 17l-5-5"/>
                      </svg>
                    </div>
                    <div>
                      <h4 class="font-semibold text-gray-900 mb-1">Sauvegarde automatique</h4>
                      <p class="text-sm text-gray-600">Vos modifications sont sauvegardées en temps réel.</p>
                    </div>
                  </div>

                  <div class="flex items-start gap-3">
                    <div class="h-6 w-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                        <path d="M20 6 9 17l-5-5"/>
                      </svg>
                    </div>
                    <div>
                      <h4 class="font-semibold text-gray-900 mb-1">Historique des versions</h4>
                      <p class="text-sm text-gray-600">Possibilité de revenir aux versions précédentes.</p>
                    </div>
                  </div>

                  <div class="flex items-start gap-3">
                    <div class="h-6 w-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
                        <path d="M20 6 9 17l-5-5"/>
                      </svg>
                    </div>
                    <div>
                      <h4 class="font-semibold text-gray-900 mb-1">Validation en temps réel</h4>
                      <p class="text-sm text-gray-600">Les erreurs sont détectées instantanément.</p>
                    </div>
                  </div>
                </div>

                <div class="mt-6 p-4 bg-white/50 rounded-2xl border border-white/20">
                  <div class="flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600">
                      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="font-semibold text-gray-900 text-sm">Conseil</span>
                  </div>
                  <p class="text-sm text-gray-600">N'oubliez pas de vérifier les dates et horaires des jours après modification des dates principales.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Section programme détaillé -->
          <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8">
            <div class="flex items-center justify-between mb-8">
              <div class="flex items-center gap-4">
                <div class="h-16 w-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                    <line x1="16" x2="16" y1="2" y2="6"/>
                    <line x1="8" x2="8" y1="2" y2="6"/>
                    <line x1="3" x2="21" y1="10" y2="10"/>
                  </svg>
                </div>
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">Programme détaillé</h2>
                  <p class="text-gray-600 text-lg">Modifiez les jours et ajustez votre planning</p>
                </div>
              </div>

              <button
                type="button"
                @click="addJour"
                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-2xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14"/>
                  <path d="M12 5v14"/>
                </svg>
                <span>Ajouter un jour</span>
              </button>
            </div>

            <!-- Liste des jours -->
            <div v-if="event.evenement_jours.length === 0" class="text-center py-16 border-2 border-dashed border-gray-300 rounded-3xl bg-gradient-to-br from-gray-50 to-gray-100">
              <div class="h-24 w-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                  <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                  <line x1="16" x2="16" y1="2" y2="6"/>
                  <line x1="8" x2="8" y1="2" y2="6"/>
                  <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun jour planifié</h3>
              <p class="text-gray-500 mb-8 text-lg max-w-md mx-auto">Ajoutez des jours pour structurer le programme de votre événement</p>
              <button
                type="button"
                @click="addJour"
                class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
              >
                Ajouter le premier jour
              </button>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div
                v-for="(jour, index) in event.evenement_jours"
                :key="jour.id ?? index"
                class="bg-gradient-to-br from-white to-gray-50 border-2 border-gray-200 rounded-3xl p-8 relative hover:shadow-lg transition-all duration-200"
              >
                <!-- En-tête du jour -->
                <div class="flex items-center justify-between mb-8">
                  <div class="flex items-center gap-4">
                    <div class="h-14 w-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                      <span class="text-white font-bold text-xl">{{ index + 1 }}</span>
                    </div>
                    <div>
                      <h3 class="text-xl font-bold text-gray-900">Jour {{ index + 1 }}</h3>
                      <p class="text-gray-500">Configuration du programme</p>
                    </div>
                  </div>

                  <button
                    type="button"
                    @click="removeJour(index)"
                    class="p-3 text-red-600 hover:bg-red-50 rounded-2xl transition-colors group"
                    title="Supprimer ce jour"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                      <path d="M3 6h18"/>
                      <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                      <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    </svg>
                  </button>
                </div>

                <!-- Champs du jour -->
                <div class="space-y-6">
                  <!-- Date -->
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date *</label>
                    <input
                      v-model="jour.date"
                      type="date"
                      :min="event.date_debut"
                      :max="event.date_fin"
                      required
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                    />
                  </div>

                  <!-- Horaires -->
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-2">Début *</label>
                      <input
                        v-model="jour.heure_debut"
                        type="time"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                      />
                    </div>
                    <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-2">Fin *</label>
                      <input
                        v-model="jour.heure_fin"
                        type="time"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                      />
                    </div>
                  </div>

                  <!-- À apporter -->
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">À apporter</label>
                    <input
                      v-model="jour.apporter"
                      type="text"
                      placeholder="Ex: Ordinateur portable, documents..."
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                    />
                  </div>

                  <!-- Description -->
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea
                      v-model="jour.description"
                      rows="3"
                      placeholder="Décrivez le programme de cette journée..."
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 resize-none"
                    ></textarea>
                  </div>

                  <!-- Options -->
                  <div class="space-y-4">
                    <label class="flex items-center gap-4 cursor-pointer p-3 rounded-xl hover:bg-amber-50 transition-colors">
                      <input
                        v-model="jour.pause_cafe"
                        type="checkbox"
                        class="h-5 w-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                      />
                      <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-amber-100 rounded-lg flex items-center justify-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600">
                            <path d="M10 2v2a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2"/>
                            <path d="M22 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2"/>
                          </svg>
                        </div>
                        <div>
                          <div class="font-semibold text-gray-900">Pause café incluse</div>
                          <div class="text-sm text-gray-500">Prévoir une pause café pendant la journée</div>
                        </div>
                      </div>
                    </label>

                    <label class="flex items-center gap-4 cursor-pointer p-3 rounded-xl hover:bg-green-50 transition-colors">
                      <input
                        v-model="jour.pause_dejeuner"
                        type="checkbox"
                        class="h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                      />
                      <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                            <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                            <path d="M7 2v20"/>
                            <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                          </svg>
                        </div>
                        <div>
                          <div class="font-semibold text-gray-900">Déjeuner inclus</div>
                          <div class="text-sm text-gray-500">Prévoir un repas pour les participants</div>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mt-12 pt-8 border-t border-gray-200">
              <div class="flex items-center gap-3 text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"/>
                  <path d="M12 16v-4"/>
                  <path d="M12 8h.01"/>
                </svg>
                <span class="text-sm">{{ event.evenement_jours.length }} jour(s) configuré(s)</span>
              </div>

              <div class="flex gap-4">
                <button
                  type="button"
                  @click="$router.push({ name: 'evenementDetail', params: { id: $route.params.id } })"
                  class="border-2 border-gray-300 text-gray-700 hover:bg-gray-50 px-8 py-4 rounded-2xl font-semibold transition-all duration-200 flex items-center gap-3"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                  </svg>
                  <span>Annuler</span>
                </button>

                <button
                  type="submit"
                  :disabled="isSubmitting"
                  class="bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed text-white px-10 py-4 rounded-2xl font-semibold transition-all duration-200 flex items-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                >
                  <svg
                    v-if="isSubmitting"
                    class="animate-spin h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17,21 17,13 7,13 7,21"/>
                    <polyline points="7,3 7,8 15,8"/>
                  </svg>
                  <span class="text-lg">{{ isSubmitting ? 'Mise à jour...' : 'Mettre à jour l\'événement' }}</span>
                </button>
              </div>
            </div>
          </div>
        </form>

        <!-- Message de succès/erreur -->
        <div v-if="message" :class="[
          'mt-8 p-6 rounded-2xl border-2 backdrop-blur-sm',
          messageType === 'success'
            ? 'bg-green-50/80 border-green-200 text-green-800'
            : 'bg-red-50/80 border-red-200 text-red-800'
        ]">
          <div class="flex items-center gap-4">
            <div :class="[
              'h-12 w-12 rounded-2xl flex items-center justify-center',
              messageType === 'success' ? 'bg-green-100' : 'bg-red-100'
            ]">
              <svg v-if="messageType === 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                <path d="M20 6 9 17l-5-5"/>
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" x2="9" y1="9" y2="15"/>
                <line x1="9" x2="15" y1="9" y2="15"/>
              </svg>
            </div>
            <div>
              <div class="font-bold text-lg">{{ messageType === 'success' ? 'Succès !' : 'Erreur' }}</div>
              <div class="text-lg">{{ message }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getEventById, updateEvent } from '@/modules/Evenement.module/service/event.service.js'
import { useToast } from 'primevue/usetoast'

const route = useRoute()
const router = useRouter()
const toast = useToast()

const isLoading = ref(true)
const isSubmitting = ref(false)
const message = ref('')
const messageType = ref('success')

const event = ref({
  titre: '',
  date_debut: '',
  date_fin: '',
  lieu: '',
  description: '',
  evenement_jours: []
})

const fetchEvent = async () => {
  isLoading.value = true
  try {
    const res = await getEventById(route.params.id)

    event.value = {
      titre: res.data.titre || '',
      date_debut: res.data.date_debut || '',
      date_fin: res.data.date_fin || '',
      lieu: res.data.lieu || '',
      description: res.data.description || '',
      evenement_jours: Array.isArray(res.data.evenement_jours)
        ? res.data.evenement_jours.map(jour => ({
            id: jour.id ?? null,
            evenement_id: route.params.id || null,
            date: jour.date || '',
            heure_debut: jour.heure_debut || '',
            heure_fin: jour.heure_fin || '',
            pause_dejeuner: !!jour.pause_dejeuner,
            pause_cafe: !!jour.pause_cafe,
            apporter: jour.apporter || '',
            description: jour.description || ''
          }))
        : []
    }
  } catch (error) {
    console.error('Error fetching event:', error)
    message.value = 'Erreur lors du chargement de l\'événement'
    messageType.value = 'error'
  } finally {
    isLoading.value = false
  }
}

const addJour = () => {
  event.value.evenement_jours.push({
    date: event.value.date_debut || '',
    id: null,
    evenement_id: route.params.id || null,
    heure_debut: '09:00',
    heure_fin: '17:00',
    pause_dejeuner: false,
    pause_cafe: false,
    apporter: '',
    description: ''
  })
}

const removeJour = (idx) => {
  event.value.evenement_jours.splice(idx, 1)
}

const handleUpdate = async () => {
  isSubmitting.value = true
  message.value = ''

  try {
    await updateEvent(route.params.id, event.value)
    message.value = 'Événement mis à jour avec succès !'
    messageType.value = 'success'

    toast.add({
      severity: 'success',
      summary: 'Succès',
      detail: 'Événement mis à jour avec succès',
      life: 3000
    })

    setTimeout(() => {
      router.push({ name: 'evenementDetail', params: { id: route.params.id } })
    }, 1500)

  } catch (error) {
    console.error('Error updating event:', error)
    message.value = 'Erreur lors de la mise à jour de l\'événement'
    messageType.value = 'error'

    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Erreur lors de la mise à jour',
      life: 3000
    })
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  fetchEvent()
})
</script>

<style scoped>
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>
