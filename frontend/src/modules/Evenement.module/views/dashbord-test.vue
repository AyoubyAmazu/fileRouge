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
              <p class="text-sm font-medium text-gray-600">Taux de Présence Global</p>
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
            <h4 class="text-lg font-semibold text-gray-900 truncate">{{ event.title }}</h4>
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
              <span class="text-sm text-gray-900">{{ formatDate(event.date) }}</span>
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
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
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
                  Participants
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Statut
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
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
                      <div class="text-sm font-medium text-gray-900">{{ event.title }}</div>
                      <div class="text-sm text-gray-500">{{ event.description }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ formatDate(event.date) }}</div>
                  <div class="text-sm text-gray-500">{{ event.time }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 flex items-center">
                    <MapPin class="h-4 w-4 mr-1 text-gray-400" />
                    {{ event.location }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ event.registrations }}/{{ event.maxParticipants }}
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                    <div 
                      class="bg-blue-600 h-2 rounded-full" 
                      :style="{ width: `${(event.registrations / event.maxParticipants) * 100}%` }"
                    ></div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span 
                    :class="[
                      'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                      event.status === 'Ouvert' ? 'bg-green-100 text-green-800' :
                      event.status === 'Complet' ? 'bg-red-100 text-red-800' :
                      'bg-yellow-100 text-yellow-800'
                    ]"
                  >
                    {{ event.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex items-center gap-2">
                    <button class="text-blue-600 hover:text-blue-900">
                      <Eye class="h-4 w-4" />
                    </button>
                    <button class="text-gray-600 hover:text-gray-900">
                      <Edit class="h-4 w-4" />
                    </button>
                    <button class="text-red-600 hover:text-red-900">
                      <Trash2 class="h-4 w-4" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import { 
  Users, Building, Calendar, BarChart3, TrendingUp, MapPin, 
  Plus, Eye, Edit, Trash2 
} from 'lucide-vue-next'

// Mock data
const stats = ref({
  totalMembers: 1247,
  totalCommunities: 15
})

const selectedYear = ref('all')
const availableYears = ref([2023, 2024, 2025])

// Events data with inscription vs presence for each event
const eventsData = ref([
  {
    id: 1,
    title: "Conférence Tech 2024",
    date: "2024-03-15",
    inscriptions: 120,
    presences: 95,
    attendanceRate: 79
  },
  {
    id: 2,
    title: "Workshop Design",
    date: "2024-04-20",
    inscriptions: 50,
    presences: 48,
    attendanceRate: 96
  },
  {
    id: 3,
    title: "Hackathon IA",
    date: "2024-05-10",
    inscriptions: 80,
    presences: 65,
    attendanceRate: 81
  },
  {
    id: 4,
    title: "Séminaire Business",
    date: "2024-06-05",
    inscriptions: 100,
    presences: 70,
    attendanceRate: 70
  },
  {
    id: 5,
    title: "Formation Cyber",
    date: "2024-07-12",
    inscriptions: 60,
    presences: 55,
    attendanceRate: 92
  },
  {
    id: 6,
    title: "Conférence 2023",
    date: "2023-09-15",
    inscriptions: 90,
    presences: 72,
    attendanceRate: 80
  },
  {
    id: 7,
    title: "Workshop 2023",
    date: "2023-11-20",
    inscriptions: 45,
    presences: 38,
    attendanceRate: 84
  },
  {
    id: 8,
    title: "Future Event 2025",
    date: "2025-02-10",
    inscriptions: 75,
    presences: 68,
    attendanceRate: 91
  }
])

const upcomingEvents = ref([
  {
    id: 1,
    title: "Conférence Tech 2025",
    description: "Technologies émergentes",
    date: "2025-07-15",
    time: "14:00",
    location: "Centre de Conférences Paris",
    registrations: 85,
    maxParticipants: 100,
    status: "Ouvert"
  },
  {
    id: 2,
    title: "Workshop Design Thinking",
    description: "Méthodologie créative",
    date: "2025-07-18",
    time: "09:00",
    location: "Salle Innovation",
    registrations: 25,
    maxParticipants: 25,
    status: "Complet"
  },
  {
    id: 3,
    title: "Hackathon IA",
    description: "48h de développement",
    date: "2025-07-22",
    time: "18:00",
    location: "Campus Numérique",
    registrations: 45,
    maxParticipants: 60,
    status: "Ouvert"
  },
  {
    id: 4,
    title: "Séminaire Entrepreneuriat",
    description: "Création d'entreprise",
    date: "2025-07-25",
    time: "10:00",
    location: "Amphithéâtre A",
    registrations: 12,
    maxParticipants: 80,
    status: "Bientôt"
  }
])

// Chart reference
const attendanceChart = ref(null)

// Computed properties
const filteredEventsData = computed(() => {
  if (selectedYear.value === 'all') {
    return eventsData.value
  }
  return eventsData.value.filter(event => {
    const eventYear = new Date(event.date).getFullYear()
    return eventYear === parseInt(selectedYear.value)
  })
})

const filteredUpcomingEvents = computed(() => {
  if (selectedYear.value === 'all') {
    return upcomingEvents.value
  }
  return upcomingEvents.value.filter(event => {
    const eventYear = new Date(event.date).getFullYear()
    return eventYear === parseInt(selectedYear.value)
  })
})

const overallAttendanceRate = computed(() => {
  const filtered = filteredEventsData.value
  if (filtered.length === 0) return 0
  
  const totalInscriptions = filtered.reduce((sum, event) => sum + event.inscriptions, 0)
  const totalPresences = filtered.reduce((sum, event) => sum + event.presences, 0)
  
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
  const maxInscriptions = Math.max(...data.map(d => d.inscriptions))
  const maxPresences = Math.max(...data.map(d => d.presences))
  const maxValue = Math.max(maxInscriptions, maxPresences)
  
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
    const inscriptionsHeight = (event.inscriptions / maxValue) * chartArea.height
    ctx.fillStyle = '#3b82f6'
    ctx.fillRect(x, chartArea.bottom - inscriptionsHeight, barWidth * 0.8, inscriptionsHeight)
    
    // Presences bar (green)
    const presencesHeight = (event.presences / maxValue) * chartArea.height
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
    ctx.fillText(event.title.substring(0, 15) + '...', 0, 0)
    ctx.restore()
    
    // Values on bars
    ctx.fillStyle = '#ffffff'
    ctx.font = 'bold 10px sans-serif'
    ctx.textAlign = 'center'
    
    // Inscriptions value
    if (inscriptionsHeight > 20) {
      ctx.fillText(event.inscriptions, x + barWidth * 0.4, chartArea.bottom - inscriptionsHeight + 15)
    }
    
    // Presences value
    if (presencesHeight > 20) {
      ctx.fillText(event.presences, x + barWidth * 1.4, chartArea.bottom - presencesHeight + 15)
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
  await nextTick()
  if (attendanceChart.value) {
    createAttendanceChart()
  }
})
</script>