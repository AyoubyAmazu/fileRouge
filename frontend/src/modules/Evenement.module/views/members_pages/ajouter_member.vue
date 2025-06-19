<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 p-4">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="p-3 bg-indigo-600 rounded-full">
            <UserCheck class="h-8 w-8 text-white" />
          </div>
          <h1 class="text-4xl font-bold text-gray-900">Assigner aux Communautés</h1>
        </div>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Sélectionnez un apprenant et choisissez les communautés auxquelles l'assigner (maximum 2)
        </p>
      </div>

      <!-- Enhanced Loading State -->
      <div v-if="isLoading" class="flex flex-col items-center justify-center min-h-[400px]">
        <div class="relative">
          <!-- Animated circles -->
          <div class="w-20 h-20 border-4 border-indigo-200 rounded-full animate-pulse"></div>
          <div class="absolute top-0 left-0 w-20 h-20 border-4 border-indigo-600 rounded-full animate-spin border-t-transparent"></div>
        </div>
        <div class="mt-6 text-center">
          <h3 class="text-lg font-semibold text-indigo-900 mb-2">Chargement en cours...</h3>
          <p class="text-indigo-700">Récupération des apprenants et communautés</p>
          <div class="flex justify-center mt-4 space-x-1">
            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce"></div>
            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
          </div>
        </div>
      </div>

      <div v-else class="grid lg:grid-cols-3 gap-8">
        <!-- Selection Form -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Learner Selection -->
          <div class="bg-white shadow-lg rounded-lg">
            <div class="p-6 border-b">
              <h2 class="text-xl font-semibold flex items-center gap-2">
                <Search class="h-5 w-5" />
                Sélectionner un Apprenant
              </h2>
              <p class="text-gray-600 mt-1">Choisissez l'apprenant à assigner aux communautés</p>
            </div>
            <div class="p-6 space-y-4">
              <div class="space-y-2">
                <label for="search" class="block text-sm font-medium text-gray-700">Rechercher un apprenant</label>
                <div class="relative">
                  <Search class="absolute left-3 top-3 h-4 w-4 text-gray-400" />
                  <input
                    id="search"
                    v-model="searchTerm"
                    type="text"
                    placeholder="Tapez le nom ou l'email..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  />
                </div>
              </div>

              <div class="space-y-2" v-if="filteredApprenants.length > 0">
                <label class="block text-sm font-medium text-gray-700">Apprenants disponibles</label>
                <div class="max-h-64 overflow-y-auto space-y-2 border rounded-lg p-2">
                  <div
                    v-for="apprenant in filteredApprenants"
                    :key="apprenant.id"
                    :class="[
                      'flex items-center gap-3 p-3 rounded-lg cursor-pointer transition-colors',
                      selectedApprenant === apprenant.id
                        ? 'bg-indigo-100 border-2 border-indigo-300'
                        : 'bg-white hover:bg-gray-50 border'
                    ]"
                    @click="selectedApprenant = apprenant.id"
                  >
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                      {{ apprenant.user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">{{ apprenant.user.name }}</p>
                        <p class="text-sm text-gray-600">{{ apprenant.user.email }}</p>
                        <p class="text-xs text-gray-500">{{ apprenant.groupe.nom }} - {{ apprenant.groupe.annee_promotion }}</p>
                    </div>
                    <div class="text-right">
                      <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">{{ apprenant.groupe.nom }}</span>
                      <p class="text-xs text-gray-500 mt-1">{{ apprenant.groupe.annee_promotion }}</p>
                    </div>
                    <CheckCircle v-if="selectedApprenant === apprenant.id" class="h-5 w-5 text-indigo-600" />
                  </div>
                </div>
              </div>
              <div v-else class="p-6 text-center text-gray-500">
                    <p class="text-gray-500 text-center py-4">
                    Il n'y a aucun apprenant sans communauté.
                    </p>
             </div>
            </div>
          </div>

          <!-- Community Selection -->
          <div class="bg-white shadow-lg rounded-lg">
            <div class="p-6 border-b">
              <h2 class="text-xl font-semibold flex items-center gap-2">
                <Users class="h-5 w-5" />
                Sélectionner les Communautés
              </h2>
              <div class="flex items-center justify-between mt-1">
                <p class="text-gray-600">Choisissez les communautés auxquelles assigner l'apprenant</p>
                <span class="text-sm font-medium text-indigo-600">
                  {{ selectedCommunities.length }}/2 sélectionnées
                </span>
              </div>
              <!-- Max selection warning -->
              <div v-if="selectedCommunities.length >= 2" class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded-md">
                <p class="text-sm text-amber-800">
                  <span class="font-medium">Limite atteinte:</span> Vous avez sélectionné le maximum de 2 communautés.
                </p>
              </div>
            </div>
            <div class="p-6"  >
              <div class="grid gap-4">
                <div
                v-for="community in communities"
                :key="community.id"
                :class="[
                    'flex items-start space-x-3 p-4 border rounded-lg transition-colors',
                    selectedCommunities.length >= 2 && !selectedCommunities.includes(community.id)
                    ? 'opacity-50 cursor-not-allowed bg-gray-50'
                    : 'hover:bg-gray-50 cursor-pointer'
                ]"
                >
                  <input
                    :id="community.id"
                    v-model="selectedCommunities"
                    :value="community.id"
                    :disabled="selectedCommunities.length >= 2 && !selectedCommunities.includes(community.id)"
                    type="checkbox"
                    class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded disabled:opacity-50"
                    @change="handleCommunityChange"
                  />
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                      <label
                        :for="community.id"
                        :class="[
                          'font-medium cursor-pointer',
                          selectedCommunities.length >= 2 && !selectedCommunities.includes(community.id)
                            ? 'text-gray-400'
                            : 'text-gray-900'
                        ]"
                      >
                        {{ community.nom }}
                      </label>
                      <span :class="['px-2 py-1 text-xs rounded-full', community.color]">
                        {{ community.memberCount }} membres
                      </span>
                    </div>
                    <p :class="[
                      'text-sm',
                      selectedCommunities.length >= 2 && !selectedCommunities.includes(community.id)
                        ? 'text-gray-400'
                        : 'text-gray-600'
                    ]">
                      {{ community.description }}
                    </p>
                  </div>
                </div>
              </div>

              <div class="border-t my-6"></div>

              <button
                @click="handleSubmit"
                :disabled="!selectedApprenant || selectedCommunities.length === 0 || isSubmitting"
                class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-md transition-colors flex items-center justify-center gap-2"
              >
                <div v-if="isSubmitting" class="flex items-center gap-2">
                  <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                  <span>Assignment en cours...</span>
                </div>
                <div v-else class="flex items-center gap-2">
                  <UserCheck class="h-4 w-4" />
                  <span>Assigner aux Communautés ({{ selectedCommunities.length }})</span>
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Preview Section -->
        <div class="space-y-6">
          <!-- Selected Learner Preview -->
          <div v-if="selectedApprenantData" class="bg-white shadow-lg rounded-lg">
            <div class="p-6 border-b">
              <h3 class="text-lg font-semibold">Apprenant Sélectionné</h3>
            </div>
            <div class="p-6">
              <div class="flex items-center gap-4 mb-4">
                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-lg font-semibold">
                  {{ selectedApprenantData.user.name.charAt(0).toUpperCase() }}
                </div>
                <div>
                  <h3 class="font-semibold text-lg">{{ selectedApprenantData.user.name }}</h3>
                  <p class="text-gray-600">{{ selectedApprenantData.user.email }}</p>
                  <div class="flex gap-2 mt-2">
                    <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                      {{ selectedApprenantData.groupe.nom }}
                    </span>
                    <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                      Promotion {{ selectedApprenantData.groupe.annee_promotion }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Selected Communities Preview -->
          <div v-if="selectedCommunities.length > 0" class="bg-white shadow-lg rounded-lg">
            <div class="p-6 border-b">
              <h3 class="text-lg font-semibold">Communautés Sélectionnées ({{ selectedCommunities.length }}/2)</h3>
            </div>
            <div class="p-6">
              <div class="space-y-3">
                <div
                  v-for="communityId in selectedCommunities"
                  :key="communityId"
                  class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
                >
                  <div>
                    <p class="font-medium">{{ getCommunityById(communityId)?.nom }}</p>
                    <p class="text-sm text-gray-600">{{ getCommunityById(communityId)?.memberCount }} membres</p>
                  </div>
                  <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Sélectionnée</span>
                </div>
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
                <h3 class="text-lg font-medium text-green-900 mb-2">Assignment réussie !</h3>
                <p class="text-sm text-green-700">L'apprenant a été assigné aux communautés sélectionnées.</p>
              </div>
            </div>
          </div>

          <!-- Instructions -->
          <div class="bg-blue-50 border border-blue-200 rounded-lg">
            <div class="p-6">
              <h3 class="font-medium text-blue-900 mb-2">Instructions</h3>
              <ul class="text-sm text-blue-800 space-y-1">
                <li>1. Recherchez et sélectionnez un apprenant</li>
                <li>2. Cochez jusqu'à 2 communautés souhaitées</li>
                <li>3. Cliquez sur "Assigner aux Communautés"</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { Users, UserCheck, Search, CheckCircle } from 'lucide-vue-next'
import { useToast } from 'primevue/usetoast'
import {getCommunautes , countMemberOfCommunaute , apprenantsWithNoCommunaute , addMemberToCommunaute  } from '@/modules/Evenement.module/service/communauteMembers.service'

const toast = useToast()

const communities = ref([])
const apprenants = ref([])
const isLoading = ref(true)
const selectedApprenant = ref("")
const selectedCommunities = ref([])
const searchTerm = ref("")
const isSubmitting = ref(false)
const submitSuccess = ref(false)

const colorClasses = [
  "bg-blue-100 text-blue-800",
  "bg-purple-100 text-purple-800",
  "bg-green-100 text-green-800",
  "bg-orange-100 text-orange-800",
  "bg-red-100 text-red-800",
  "bg-pink-100 text-pink-800",
  "bg-yellow-100 text-yellow-800"
]

const fitchCommunities = async () => {
  try {
    const response = await getCommunautes()
    communities.value = response.data
    for (const community of communities.value) {
      community.memberCount = await countMemberbyCommunaute(community.id)
    }
    communities.value = response.data.map((c, idx) => ({
      ...c,
      color: colorClasses[idx % colorClasses.length]
    }))
  } catch (error) {
    console.error("Erreur lors de la récupération des communautés :", error)
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Impossible de charger les communautés',
      life: 3000
    })
  }
}

const countMemberbyCommunaute = async (id) => {
  try {
    const response = await countMemberOfCommunaute(id)
    return response.data.count
  } catch (error) {
    console.error("Erreur lors du comptage des membres de la communauté :", error)
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Impossible de compter les membres de la communauté',
      life: 3000
    })
    return 0
  }
}

const apprenantsNoCommunuate = async () => {
  try {
    const response = await apprenantsWithNoCommunaute()
    apprenants.value = response.data.data
  } catch (error) {
    console.error("Erreur lors de la récupération des apprenants sans communauté :", error)
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Impossible de charger les apprenants sans communauté',
      life: 3000
    })
    return []
  }
}
const addCommunuates = async (data)=>{
    try {
        await addMemberToCommunaute(data)
        toast.add({
        severity: 'success',
        summary: 'Succès',
        detail: 'Communautés ajoutées avec succès',
        life: 3000
        })
    } catch (error) {
        console.error("Erreur lors de l'ajout des communautés :", error)
        toast.add({
        severity: 'error',
        summary: 'Erreur',
        detail: 'Impossible d\'ajouter les communautés',
        life: 3000
        })
        return null
    }
}


const filteredApprenants = computed(() => {
  return apprenants.value.filter(
    (apprenant) =>
      apprenant.user.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      apprenant.user.email.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      apprenant.groupe.nom.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
})

const selectedApprenantData = computed(() => {
  return apprenants.value.find((a) => a.id === selectedApprenant.value)
})

// Methods
const getCommunityById = (id) => {
  return communities.value.find((c) => c.id === id)
}



const handleSubmit = async () => {
  if (!selectedApprenant.value || selectedCommunities.value.length === 0) return

  if (selectedCommunities.value.length > 2) {
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Vous ne pouvez pas assigner plus de 2 communautés',
      life: 3000
    })
    return
  }

  isSubmitting.value = true
  const data =ref({
    id_apprenant: selectedApprenant.value,
    communautes: Array.from(selectedCommunities.value)
  });
  console.log("Data to submit:", data.value)
    await addCommunuates(data.value)
    isSubmitting.value = false
    submitSuccess.value = true

    // Reset state after submission
    selectedApprenant.value = ""
    selectedCommunities.value = []
    searchTerm.value = ""
    isLoading.value = true
    // Optionally, refetch data or reset views
    await fitchCommunities()
    await apprenantsNoCommunuate()
    isLoading.value = false
    setTimeout(() => {
        submitSuccess.value = false
    }, 3000)
}

onMounted(async () => {
  await fitchCommunities()
  await apprenantsNoCommunuate()
  isLoading.value = false
})
</script>
