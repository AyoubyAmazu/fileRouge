<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Tableau de Bord</h1>
            <p class="text-lg text-gray-600">Vue d'ensemble de votre plateforme d'apprentissage</p>
          </div>
          <!-- Year Filter -->
          <div class="flex items-center gap-4">
            <label for="yearFilter" class="text-sm font-medium text-gray-700">Filtrer par année:</label>
            <select
              id="yearFilter"
              v-model="selectedYear"
              @change="filterDataByYear"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="all">Toutes les années</option>
              <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
            </select>
          </div>
        </div>
      </div>
      <div v-if="isLoading" class="flex flex-col items-center justify-center min-h-[300px]">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mb-4"></div>
        <p class="text-indigo-700 font-medium">Chargement des données...</p>
        </div>
        <div v-else>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Members -->
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
              <Users class="h-8 w-8 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Membres</p>
              <p class="text-3xl font-bold text-gray-900">{{ stats.totalMembers }}</p>
              <p class="text-sm text-green-600 flex items-center">
                <TrendingUp class="h-4 w-4 mr-1" />
                Actifs
              </p>
            </div>
          </div>
        </div>

        <!-- Total Communities -->
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
              <Building class="h-8 w-8 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Communautés</p>
              <p class="text-3xl font-bold text-gray-900">{{ stats.totalCommunities }}</p>
              <p class="text-sm text-blue-600 flex items-center">
                <Building class="h-4 w-4 mr-1" />
                Actives
              </p>
            </div>
          </div>
        </div>

        <!-- Overall Attendance Rate -->
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
              <BarChart3 class="h-8 w-8 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Taux de Présence Global </p>
              <p class="text-3xl font-bold text-gray-900">{{ overallAttendanceRate }}%</p>
              <p class="text-sm text-gray-600 flex items-center">
                <BarChart3 class="h-4 w-4 mr-1" />
                {{ selectedYear === 'all' ? 'Toutes années' : selectedYear }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Events Inscription vs Presence Chart -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-xl font-semibold text-gray-900">Inscriptions vs Présences par Événement</h3>
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-1">
              <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
              <span class="text-sm text-gray-600">Inscriptions</span>
            </div>
            <div class="flex items-center gap-1">
              <div class="w-3 h-3 bg-green-500 rounded-full"></div>
              <span class="text-sm text-gray-600">Présences</span>
            </div>
            <div class="flex items-center gap-1">
              <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
              <span class="text-sm text-gray-600">Taux (%)</span>
            </div>
          </div>
        </div>
        <div class="h-80">
          <canvas ref="attendanceChart" class="w-full h-full"></canvas>
        </div>
      </div>

      <!-- Event Performance Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div
          v-for="event in filteredEventsData"
          :key="event.id"
          class="bg-white rounded-lg shadow-lg p-6"
        >
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-gray-900 truncate">{{ event.titre }}</h4>
            <span
              :class="[
                'px-2 py-1 text-xs font-semibold rounded-full',
                getAttendanceColor(event.attendanceRate)
              ]"
            >
              {{ event.attendanceRate }}%
            </span>
          </div>

          <div class="space-y-3">
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Inscriptions:</span>
              <span class="font-medium text-blue-600">{{ event.inscriptions }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Présences:</span>
              <span class="font-medium text-green-600">{{ event.presences }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Date:</span>
              <span class="text-sm text-gray-900">{{ formatDate(event.date_debut) }}</span>
            </div>
          </div>

          <!-- Progress Bar -->
          <div class="mt-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
              <span>Taux de présence</span>
              <span>{{ event.attendanceRate }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
              <div
                :class="[
                  'h-2 rounded-full transition-all duration-300',
                  getAttendanceBarColor(event.attendanceRate)
                ]"
                :style="{ width: `${event.attendanceRate}%` }"
              ></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Upcoming Events Table -->
      <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-900">Événements à Venir</h3>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" @onclick="router.push('/evenements/creation')">
              <Plus class="h-4 w-4" />
              Nouvel Événement
            </button>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Événement
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date & Heure
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Lieu
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Inscriptions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="event in filteredUpcomingEvents" :key="event.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                      <Calendar class="h-5 w-5 text-blue-600" />
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ event.titre }}</div>
                      <div class="text-sm text-gray-500">{{ event.description }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ formatDate(event.date_debut) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 flex items-center">
                    <MapPin class="h-4 w-4 mr-1 text-gray-400" />
                    {{ event.lieu }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ event.inscription }}
                  </div>

                </td>


              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick , watch} from 'vue'
import {
  Users, Building, Calendar, BarChart3, TrendingUp, MapPin,
  Plus, Eye, Edit, Trash2
} from 'lucide-vue-next'
import { useRouter } from 'vue-router'
import { getCommunauteNumber } from '@/modules/Evenement.module/service/communaute.service'
import { getCounteMembers } from '@/modules/Evenement.module/service/communauteMembers.service'
import { getEvents , getEventsYears } from '@/modules/Evenement.module/service/event.service'
import {countTotalInscription , countTotalPresence , countInscriptionByEvent , countPresenceByEvent } from  '@/modules/Evenement.module/service/inscription.service'
// Mock data
const stats = ref({
  totalMembers: 0,
  totalCommunities: 0,
  totalInscriptions:0,
  totalPresences: 0
})
const isLoading = ref(true)
const now = new Date()
const router = useRouter()

const getTotalCommunities = async () => {
  try {
    const response = await getCommunauteNumber()
    stats.value.totalCommunities = response.data.count
  } catch (error) {
    console.error('Error fetching total communities:', error)
  }
}

const totalMembers = async()=>
{
    try {
        const response = await getCounteMembers()
        stats.value.totalMembers = response.data.count
        console.log("totalmember",stats.value.totalMembers)
    } catch (error) {
        console.error('Error fetching total members:', error)
    }
}

const totalInscriptions = async () => {
  try {
    const response = await countTotalInscription()
    console.log('Total inscriptions fetched successfully:', response.data.count)
    stats.value.totalInscriptions = response.data.count
  } catch (error) {
    console.error('Error fetching total inscriptions:', error)
  }
}

const totalPresences = async () => {
  try {
    const response = await countTotalPresence()
    console.log('Total presences fetched successfully:',response.data.count)
    stats.value.totalPresences = response.data.count
      } catch (error) {
    console.error('Error fetching total presences:', error)
  }
}

const totalInscriptionByEvent = async (eventId) => {
  try {
    const response = await countInscriptionByEvent(eventId)
    return response.data.count
  } catch (error) {
    console.error('Error fetching total inscriptions by event:', error)
    return 0
  }
}

const totalPresenceByEvent = async (eventId)=> {
    try {
        const response = await countPresenceByEvent(eventId)
        return response.data.count
    }catch (error) {
        console.error('Error fetching total presences by event:', error)
        return 0
    }
}

const getEventsData = async () => {
  try {
    const response = await getEvents()
    eventsData.value = response.data
    for(const events of eventsData.value) {
      // Calculate attendance rate for each event
      events.inscription = await totalInscriptionByEvent(events.id)
      events.presence = await totalPresenceByEvent(events.id)
      events.attendanceRate = Math.round((events.presence / events.inscription) * 100) || 0
    }
    upcomingEvents.value = eventsData.value.filter(event => new Date(event.date_debut) > now)
    eventsData.value = eventsData.value.filter(event => new Date(event.date_debut) <= now)

  } catch (error) {
    console.error('Error fetching events data:', error)
  }
}

const eventsYears = async () => {
  try {
    const response = await getEventsYears()
    console.log('Available years:', response.data)
    availableYears.value = response.data
  } catch (error) {
    console.error('Error fetching events years:', error)
  }
}

const selectedYear = ref('all')
const availableYears = ref([])
// Events data with inscription vs presence for each event
const eventsData = ref([])

const upcomingEvents = ref([])

// Chart reference
const attendanceChart = ref(null)

// Computed properties
const filteredEventsData = computed(() => {
  if (selectedYear.value === 'all') {
    return eventsData.value
  }
  return eventsData.value.filter(event => {
    const eventYear = new Date(event.date_debut).getFullYear()
    return eventYear === parseInt(selectedYear.value)
  })
})


const filteredUpcomingEvents = computed(() => {
  if (selectedYear.value === 'all') {
    return upcomingEvents.value
  }
  return upcomingEvents.value.filter(event => {
    const eventYear = new Date(event.date_debut).getFullYear()
    return eventYear === parseInt(selectedYear.value)
  })
})

const overallAttendanceRate = computed(  () => {

    const totalPresences = stats.value.totalPresences || 0
    const totalInscriptions = stats.value.totalInscriptions

  return Math.round((totalPresences / totalInscriptions) * 100)
})

// Methods
const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

const getAttendanceColor = (rate) => {
  if (rate >= 90) return 'bg-green-100 text-green-800'
  if (rate >= 75) return 'bg-yellow-100 text-yellow-800'
  return 'bg-red-100 text-red-800'
}

const getAttendanceBarColor = (rate) => {
  if (rate >= 90) return 'bg-green-500'
  if (rate >= 75) return 'bg-yellow-500'
  return 'bg-red-500'
}

const filterDataByYear = () => {
  // Trigger chart redraw when year changes
  nextTick(() => {
    if (attendanceChart.value) {
      createAttendanceChart()
    }
  })
}

const createAttendanceChart = () => {
  const canvas = attendanceChart.value
  const ctx = canvas.getContext('2d')

  // Set canvas size
  canvas.width = canvas.offsetWidth
  canvas.height = canvas.offsetHeight

  const chartWidth = canvas.width
  const chartHeight = canvas.height
  const padding = 60

  // Clear canvas
  ctx.clearRect(0, 0, chartWidth, chartHeight)

  const data = filteredEventsData.value
  if (data.length === 0) return

  // Chart area
  const chartArea = {
    left: padding,
    top: padding,
    right: chartWidth - padding,
    bottom: chartHeight - padding,
    width: chartWidth - (padding * 2),
    height: chartHeight - (padding * 2)
  }

  // Find max values
  const maxInscriptions = Math.max(...data.map(d => d.inscription))
  const maxPresences = Math.max(...data.map(d => d.presence))
  const maxValue = Math.max(maxInscriptions,maxPresences)

  // Bar width
  const barWidth = chartArea.width / (data.length * 3) // 3 bars per event (inscriptions, presences, gap)
  const groupWidth = barWidth * 2.5

  // Draw grid lines
  ctx.strokeStyle = '#e5e7eb'
  ctx.lineWidth = 1

  for (let i = 0; i <= 5; i++) {
    const y = chartArea.top + (i * chartArea.height / 5)
    ctx.beginPath()
    ctx.moveTo(chartArea.left, y)
    ctx.lineTo(chartArea.right, y)
    ctx.stroke()
  }

  // Draw bars
  data.forEach((event, index) => {
    const x = chartArea.left + (index * groupWidth) + (groupWidth / 4)

    // Inscriptions bar (blue)
    const inscriptionsHeight = (event.inscription / maxValue) * chartArea.height
    ctx.fillStyle = '#3b82f6'
    ctx.fillRect(x, chartArea.bottom - inscriptionsHeight, barWidth * 0.8, inscriptionsHeight)

    // Presences bar (green)
    const presencesHeight = (event.presence / maxValue) * chartArea.height
    ctx.fillStyle = '#10b981'
    ctx.fillRect(x + barWidth, chartArea.bottom - presencesHeight, barWidth * 0.8, presencesHeight)

    // Event labels
    ctx.fillStyle = '#6b7280'
    ctx.font = '10px sans-serif'
    ctx.textAlign = 'center'
    const labelX = x + barWidth
    ctx.save()
    ctx.translate(labelX, chartArea.bottom + 15)
    ctx.rotate(-Math.PI / 4)
    ctx.fillText(event.titre.substring(0, 15) + '...', 0, 0)
    ctx.restore()

    // Values on bars
    ctx.fillStyle = '#ffffff'
    ctx.font = 'bold 10px sans-serif'
    ctx.textAlign = 'center'

    // Inscriptions value
    if (inscriptionsHeight > 20) {
      ctx.fillText(event.inscription, x + barWidth * 0.4, chartArea.bottom - inscriptionsHeight + 15)
    }

    // Presences value
    if (presencesHeight > 20) {
      ctx.fillText(event.presence, x + barWidth * 1.4, chartArea.bottom - presencesHeight + 15)
    }
  })

  // Y-axis labels
  ctx.fillStyle = '#6b7280'
  ctx.font = '12px sans-serif'
  ctx.textAlign = 'right'

  for (let i = 0; i <= 5; i++) {
    const value = Math.round((maxValue / 5) * (5 - i))
    const y = chartArea.top + (i * chartArea.height / 5)
    ctx.fillText(value.toString(), chartArea.left - 10, y + 4)
  }
}

onMounted(async () => {
      isLoading.value = true
    await nextTick()
    await getTotalCommunities()
    await totalMembers()
    await totalInscriptions()
    await totalPresences()
    await getEventsData()
    await eventsYears()
    if (attendanceChart.value) {
        createAttendanceChart()
    }
      isLoading.value = false

})

watch(selectedYear, (newYear) => {
    console.log('Year changed to:', newYear)
    totalMembers(newYear)
    totalInscriptions(newYear)
    totalPresences(newYear)
    getTotalCommunities(newYear)
})
</script>
