<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6">
    <div class="max-w-4xl mx-auto space-y-6">
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
              <div class="p-2 bg-green-100 rounded-lg">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                Créer une Communauté
              </h1>
            </div>
            <p class="text-slate-600 ml-12">
              Créez une nouvelle communauté pour rassembler les apprenants autour d'intérêts communs
            </p>
          </div>

          <div class="flex items-center gap-2">
            <span v-if="hasUnsavedChanges" class="text-sm text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200 flex items-center gap-1">
              <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Brouillon non sauvegardé
            </span>
          </div>
        </div>
      </div>

      <!-- Success Message -->
      <div v-if="showSuccessMessage" class="bg-green-50 border border-green-200 rounded-2xl p-6">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-green-800">Communauté créée avec succès !</h3>
            <p class="text-green-700">{{ successMessage }}</p>
          </div>
          <button
            @click="showSuccessMessage = false"
            class="ml-auto p-1 hover:bg-green-200 rounded-lg transition-colors duration-200"
          >
            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Error Message -->
      <div v-if="showErrorMessage" class="bg-red-50 border border-red-200 rounded-2xl p-6">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-red-100 rounded-lg">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-red-800">Erreur lors de la création</h3>
            <p class="text-red-700">{{ errorMessage }}</p>
          </div>
          <button
            @click="showErrorMessage = false"
            class="ml-auto p-1 hover:bg-red-200 rounded-lg transition-colors duration-200"
          >
            <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
            <div class="flex items-center gap-3 mb-6">
              <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <h2 class="text-xl font-semibold text-slate-800">Informations de la Communauté</h2>
            </div>

            <form @submit.prevent="submitForm" class="space-y-6">
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
                  maxlength="100"
                />
                <p v-if="errors.nom" class="mt-1 text-sm text-red-600 flex items-center gap-1">
                  <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ errors.nom }}
                </p>
                <p class="mt-1 text-xs text-slate-500">
                  {{ form.nom.length }}/100 caractères
                </p>
              </div>

              <!-- Community Description -->
              <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                  Description *
                </label>
                <div class="relative">
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="8"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none',
                      errors.description ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white'
                    ]"
                    placeholder="Décrivez votre communauté, ses objectifs, ses activités et ce qui la rend unique..."
                    maxlength="1000"
                  ></textarea>
                  <div class="absolute bottom-3 right-3 text-xs text-slate-400 bg-white px-2 py-1 rounded">
                    {{ form.description.length }}/1000
                  </div>
                </div>
                <p v-if="errors.description" class="mt-1 text-sm text-red-600 flex items-center gap-1">
                  <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ errors.description }}
                </p>
                <p class="mt-1 text-xs text-slate-500">
                  Une description claire aide les membres à comprendre l'objectif de votre communauté
                </p>
              </div>
            </form>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Preview -->
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
              <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              Aperçu
            </h3>
            <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
              <div class="flex items-center gap-3 mb-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                  <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
                <div>
                  <h4 class="font-medium text-slate-800">
                    {{ form.nom || 'Nom de la communauté' }}
                  </h4>
                  <p class="text-xs text-slate-500">
                    Communauté
                  </p>
                </div>
              </div>
              <p class="text-sm text-slate-600">
                {{ form.description || 'Description de la communauté...' }}
              </p>
            </div>
          </div>

          <!-- Form Progress -->
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
              <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              Progression
            </h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600">Nom de la communauté</span>
                <span :class="[
                  'px-2 py-1 rounded-full text-xs font-medium',
                  form.nom.trim().length >= 3 ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600'
                ]">
                  {{ form.nom.trim().length >= 3 ? '✓ Complété' : 'En attente' }}
                </span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600">Description</span>
                <span :class="[
                  'px-2 py-1 rounded-full text-xs font-medium',
                  form.description.trim().length >= 10 ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600'
                ]">
                  {{ form.description.trim().length >= 10 ? '✓ Complété' : 'En attente' }}
                </span>
              </div>
              <div class="pt-2 border-t border-slate-200">
                <div class="flex items-center justify-between text-sm font-medium">
                  <span class="text-slate-700">Formulaire</span>
                  <span :class="[
                    'px-2 py-1 rounded-full text-xs font-medium',
                    isFormValid ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800'
                  ]">
                    {{ isFormValid ? '✓ Prêt' : 'Incomplet' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Guidelines -->
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
              <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Conseils
            </h3>
            <div class="space-y-3 text-sm text-slate-600">
              <div class="flex items-start gap-2">
                <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Choisissez un nom clair et descriptif</span>
              </div>
              <div class="flex items-start gap-2">
                <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Décrivez clairement les objectifs</span>
              </div>
              <div class="flex items-start gap-2">
                <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Minimum 10 caractères pour la description</span>
              </div>
              <div class="flex items-start gap-2">
                <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Chaque membre peut rejoindre max. 2 communautés</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border-0 p-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
          <div class="flex gap-3">
            <button
              type="button"
              @click="goBack"
              class="px-6 py-3 border border-slate-300 hover:border-slate-400 text-slate-700 font-medium rounded-lg transition-all duration-200"
            >
              Annuler
            </button>

            <button
              type="button"
              @click="resetForm"
              class="px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-lg transition-all duration-200"
            >
              Réinitialiser
            </button>
          </div>

          <div class="flex gap-3">
            <button
              type="button"
              @click="submitForm"
              :disabled="saving || !isFormValid"
              class="px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-400 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg disabled:cursor-not-allowed"
            >
              <svg v-if="saving" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              {{ saving ? 'Création en cours...' : 'Créer la communauté' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { createCommunaute } from '../../service/communaute.service'

// Reactive state
const saving = ref(false)
const showSuccessMessage = ref(false)
const showErrorMessage = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

// Form data
const form = ref({
  nom: '',
  description: ''
})

// Original form for comparison
const originalForm = ref({
  nom: '',
  description: ''
})

// Form validation errors
const errors = ref({
  nom: '',
  description: ''
})

// Computed properties
const isFormValid = computed(() => {
  return form.value.nom.trim().length >= 3 &&
         form.value.description.trim().length >= 10 &&
         form.value.description.length <= 1000 &&
         form.value.nom.length <= 100
})

const hasUnsavedChanges = computed(() => {
  return JSON.stringify(form.value) !== JSON.stringify(originalForm.value)
})

// Watch for form changes to clear errors
watch(form, () => {
  if (Object.keys(errors.value).length > 0) {
    validateForm()
  }
}, { deep: true })

// Methods
const validateForm = () => {
  errors.value = { nom: '', description: '' }

  if (!form.value.nom.trim()) {
    errors.value.nom = 'Le nom de la communauté est requis'
  } else if (form.value.nom.length < 3) {
    errors.value.nom = 'Le nom doit contenir au moins 3 caractères'
  } else if (form.value.nom.length > 100) {
    errors.value.nom = 'Le nom ne peut pas dépasser 100 caractères'
  }

  if (!form.value.description.trim()) {
    errors.value.description = 'La description est requise'
  } else if (form.value.description.length < 10) {
    errors.value.description = 'La description doit contenir au moins 10 caractères'
  } else if (form.value.description.length > 1000) {
    errors.value.description = 'La description ne peut pas dépasser 1000 caractères'
  }

  return !errors.value.nom && !errors.value.description
}

const create = async (communaute) => {
  try {
    const response = await createCommunaute(communaute)
    console.log('Communauté créée avec succès:', response.data[0].nom)

    successMessage.value = `Communauté "${response.data[0].nom}" créée avec succès !`
    showSuccessMessage.value = true
    showErrorMessage.value = false

    // Reset form
    form.value = {
      nom: '',
      description: ''
    }
    originalForm.value = { ...form.value }

    // Hide success message after 5 seconds
    setTimeout(() => {
      showSuccessMessage.value = false
    }, 5000)

  } catch (error) {
    console.error('Erreur lors de la création:', error)
    errorMessage.value = `Erreur lors de la création de la communauté : ${error.message || 'Erreur inconnue'}`
    showErrorMessage.value = true
    showSuccessMessage.value = false
  }
}

const submitForm = async () => {
  if (!validateForm()) return

  saving.value = true

  const communaute = {
    nom: form.value.nom.trim(),
    description: form.value.description.trim()
  }

  await create(communaute)
  saving.value = false
}

const resetForm = () => {
  if (hasUnsavedChanges.value) {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ? Toutes les modifications seront perdues.')) {
      form.value = {
        nom: '',
        description: ''
      }
      originalForm.value = { ...form.value }
      errors.value = { nom: '', description: '' }
      showSuccessMessage.value = false
      showErrorMessage.value = false
    }
  }
}

const goBack = () => {
  if (hasUnsavedChanges.value) {
    if (confirm('Vous avez des modifications non sauvegardées. Voulez-vous vraiment quitter ?')) {
      console.log('🔙 Retour à la liste des communautés')
      // Add your navigation logic here
    }
  } else {
    console.log('🔙 Retour à la liste des communautés')
    // Add your navigation logic here
  }
}
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

/* Form validation error shake */
.border-red-300 {
  animation: shake 0.3s ease-in-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-2px); }
  75% { transform: translateX(2px); }
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

/* Character counter positioning */
textarea + div {
  pointer-events: none;
}
</style>
