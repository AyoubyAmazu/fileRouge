<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="p-3 bg-blue-600 rounded-full">
            <Calendar class="h-8 w-8 text-white" />
          </div>
          <h1 class="text-4xl font-bold text-gray-900">Ajouter des Participants</h1>
        </div>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Ajoutez plusieurs participants à l'événement en sélectionnant des apprenants ou en ajoutant des invités
        </p>
      </div>

      <!-- Event Info Card -->
      <div class="bg-white shadow-lg rounded-lg mb-8">
        <div class="bg-blue-600 text-white p-6 rounded-t-lg">
          <h2 class="text-xl font-semibold flex items-center gap-2">
            <Calendar class="h-5 w-5" />
            {{ eventData.title }}
          </h2>
          <p class="text-blue-100 mt-1">{{ eventData.description }}</p>
        </div>
        <div class="p-6">
          <div class="grid md:grid-cols-4 gap-4">
            <div class="flex items-center gap-2">
              <Calendar class="h-4 w-4 text-gray-500" />
              <span class="text-sm">{{ eventData.date }} à {{ eventData.time }}</span>
            </div>
            <div class="flex items-center gap-2">
              <MapPin class="h-4 w-4 text-gray-500" />
              <span class="text-sm">{{ eventData.location }}</span>
            </div>
            <div class="flex items-center gap-2">
              <Users class="h-4 w-4 text-gray-500" />
              <span class="text-sm">{{ eventData.currentParticipants }} participants</span>
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
              <p class="text-gray-600 mt-1">Choisissez le type de participants à ajouter</p>
            </div>
            <div class="p-6">
              <!-- Tab Navigation -->
              <div class="flex bg-gray-100 rounded-lg p-1 mb-6">
                <button
                  @click="activeTab = 'apprenant'"
                  :class="[
                    'flex-1 flex items-center justify-center gap-2 py-2 px-4 rounded-md transition-colors',
                    activeTab === 'apprenant'
                      ? 'bg-white text-blue-600 shadow-sm'
                      : 'text-gray-600 hover:text-gray-900'
                  ]"
                >
                  <User class="h-4 w-4" />
                  Apprenants
                </button>
                <!-- <button
                  @click="activeTab = 'guest'"
                  :class="[
                    'flex-1 flex items-center justify-center gap-2 py-2 px-4 rounded-md transition-colors',
                    activeTab === 'guest'
                      ? 'bg-white text-blue-600 shadow-sm'
                      : 'text-gray-600 hover:text-gray-900'
                  ]"
                >
                  <UserPlus class="h-4 w-4" />
                  Invités
                </button> -->
              </div>

              <!-- Apprenant Tab Content -->
              <div v-if="activeTab === 'apprenant'" class="space-y-6">
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
                    <div class="max-h-64 overflow-y-auto space-y-2 border rounded-lg p-2">
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

              <!-- Guest Tab Content -->
              <div v-if="activeTab === 'guest'" class="space-y-6">
                <!-- Guest List -->
                <div v-if="guestList.length > 0" class="space-y-4">
                  <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Invités ajoutés ({{ guestList.length }})</h3>
                    <button
                      @click="guestList = []"
                      class="text-sm text-red-600 hover:text-red-700"
                    >
                      Supprimer tous
                    </button>
                  </div>
                  <div class="space-y-2 max-h-32 overflow-y-auto">
                    <div
                      v-for="(guest, index) in guestList"
                      :key="index"
                      class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg"
                    >
                      <div>
                        <p class="font-medium">{{ guest.firstName }} {{ guest.lastName }}</p>
                        <p class="text-sm text-gray-600">{{ guest.email }}</p>
                      </div>
                      <button
                        @click="removeGuest(index)"
                        class="text-red-500 hover:text-red-700"
                      >
                        <X class="h-4 w-4" />
                      </button>
                    </div>
                  </div>
                  <div class="border-t pt-4"></div>
                </div>

                <!-- Add New Guest Form -->
                <div class="space-y-4">
                  <h3 class="text-lg font-medium text-gray-900">Ajouter un nouvel invité</h3>
                  
                  <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                      <label for="firstName" class="block text-sm font-medium text-gray-700">Prénom *</label>
                      <input
                        id="firstName"
                        v-model="currentGuest.firstName"
                        type="text"
                        placeholder="Entrez le prénom"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                      />
                    </div>
                    <div class="space-y-2">
                      <label for="lastName" class="block text-sm font-medium text-gray-700">Nom *</label>
                      <input
                        id="lastName"
                        v-model="currentGuest.lastName"
                        type="text"
                        placeholder="Entrez le nom"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                      />
                    </div>
                  </div>

                  <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <div class="relative">
                      <Mail class="absolute left-3 top-3 h-4 w-4 text-gray-400" />
                      <input
                        id="email"
                        v-model="currentGuest.email"
                        type="email"
                        placeholder="exemple@email.com"
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                      />
                    </div>
                  </div>

                  <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <div class="relative">
                      <Phone class="absolute left-3 top-3 h-4 w-4 text-gray-400" />
                      <input
                        id="phone"
                        v-model="currentGuest.phone"
                        type="tel"
                        placeholder="+33 1 23 45 67 89"
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                  </div>

                  <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                      <label for="organization" class="block text-sm font-medium text-gray-700">Organisation</label>
                      <input
                        id="organization"
                        v-model="currentGuest.organization"
                        type="text"
                        placeholder="Nom de l'entreprise/organisation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                    <div class="space-y-2">
                      <label for="position" class="block text-sm font-medium text-gray-700">Poste</label>
                      <input
                        id="position"
                        v-model="currentGuest.position"
                        type="text"
                        placeholder="Titre du poste"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                  </div>

                  <button
                    @click="addGuest"
                    :disabled="!isCurrentGuestValid"
                    class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center justify-center gap-2"
                  >
                    <Plus class="h-4 w-4" />
                    Ajouter cet invité à la liste
                  </button>
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
                {{ isSubmitting ? 'Ajout en cours...' : `Ajouter ${totalSelectedParticipants} participant(s)` }}
              </button>
            </div>
          </div>
        </div>

        <!-- Preview Section -->
        <div class="space-y-6">
          <!-- Selected Participants Summary -->
          <div class="bg-white shadow-lg rounded-lg">
            <div class="p-6 border-b">
              <h3 class="text-lg font-semibold">Participants Sélectionnés ({{ totalSelectedParticipants }})</h3>
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
                  </div>
                </div>
              </div>

              <!-- Selected Guests -->
              <div v-if="guestList.length > 0" class="mb-6">
                <h4 class="font-medium text-green-900 mb-3">Invités ({{ guestList.length }})</h4>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                  <div
                    v-for="(guest, index) in guestList"
                    :key="index"
                    class="flex items-center gap-3 p-2 bg-green-50 rounded-lg"
                  >
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-sm font-semibold">
                      {{ guest.firstName.charAt(0).toUpperCase() }}
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="font-medium text-sm truncate">{{ guest.firstName }} {{ guest.lastName }}</p>
                      <p class="text-xs text-gray-600 truncate">{{ guest.email }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Empty State -->
              <div v-if="totalSelectedParticipants === 0" class="text-center py-8 text-gray-500">
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
                <p class="text-sm text-green-700">{{ totalSelectedParticipants }} participant(s) ont été ajoutés à l'événement avec succès.</p>
              </div>
            </div>
          </div>

          <!-- Instructions -->
          <div class="bg-blue-50 border border-blue-200 rounded-lg">
            <div class="p-6">
              <h3 class="font-medium text-blue-900 mb-2">Instructions</h3>
              <ul class="text-sm text-blue-800 space-y-1">
                <li>• Sélectionnez plusieurs apprenants avec les cases à cocher</li>
                <li>• Ajoutez plusieurs invités un par un</li>
                <li>• Utilisez "Tout sélectionner" pour les apprenants</li>
                <li>• Vérifiez le résumé avant de confirmer</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Calendar, Users, UserPlus, Search, CheckCircle, User, Mail, Phone, MapPin, Plus, X } from 'lucide-vue-next'

// Mock event data
const eventData = {
  id: 1,
  title: "Conférence Tech 2025",
  description: "Une conférence sur les dernières technologies",
  date: "2025-07-15",
  time: "14:00",
  location: "Centre de Conférences Paris",
  maxParticipants: 100,
  currentParticipants: 100,
}

// Mock apprenants data
const apprenants = [
  {
    id: 1,
    user: {
      name: "Marie Dubois",
      email: "marie.dubois@email.com",
    },
    groupe: {
      nom: "Groupe A",
      annee_promotion: "2024",
    },
  },
  {
    id: 2,
    user: {
      name: "Pierre Martin",
      email: "pierre.martin@email.com",
    },
    groupe: {
      nom: "Groupe B",
      annee_promotion: "2024",
    },
  },
  {
    id: 3,
    user: {
      name: "Sophie Bernard",
      email: "sophie.bernard@email.com",
    },
    groupe: {
      nom: "Groupe A",
      annee_promotion: "2023",
    },
  },
  {
    id: 4,
    user: {
      name: "Lucas Petit",
      email: "lucas.petit@email.com",
    },
    groupe: {
      nom: "Groupe C",
      annee_promotion: "2024",
    },
  },
]

// Reactive state
const activeTab = ref('apprenant')
const selectedApprenants = ref([])
const searchTerm = ref('')
const isSubmitting = ref(false)
const submitSuccess = ref(false)

// Guest management
const guestList = ref([])
const currentGuest = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  organization: '',
  position: '',
})

// Computed properties
const filteredApprenants = computed(() => {
  return apprenants.filter(
    (apprenant) =>
      apprenant.user.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      apprenant.user.email.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      apprenant.groupe.nom.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

const selectedApprenantsData = computed(() => {
  return apprenants.filter((a) => selectedApprenants.value.includes(a.id.toString()))
})

const isCurrentGuestValid = computed(() => {
  return currentGuest.value.firstName && currentGuest.value.lastName && currentGuest.value.email
})

const totalSelectedParticipants = computed(() => {
  return selectedApprenants.value.length + guestList.value.length
})

const isFormValid = computed(() => {
  return totalSelectedParticipants.value > 0
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

const addGuest = () => {
  if (!isCurrentGuestValid.value) return
  
  guestList.value.push({ ...currentGuest.value })
  currentGuest.value = {
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    organization: '',
    position: '',
  }
}

const removeGuest = (index) => {
  guestList.value.splice(index, 1)
}

const handleSubmit = async () => {
  if (!isFormValid.value) return

  isSubmitting.value = true

  // Simulate API call
  await new Promise((resolve) => setTimeout(resolve, 2000))

  isSubmitting.value = false
  submitSuccess.value = true

  // Reset form after success
  setTimeout(() => {
    submitSuccess.value = false
    selectedApprenants.value = []
    guestList.value = []
    searchTerm.value = ''
    currentGuest.value = {
      firstName: '',
      lastName: '',
      email: '',
      phone: '',
      organization: '',
      position: '',
    }
  }, 3000)
}
</script>