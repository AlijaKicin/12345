<template>
  <div class="budget-charts">
    <h1>Budget Analytics</h1>
    <p>Visual representation of your incomes and expenses.</p>

    <!-- Grafikoni -->
    <div class="chart-container">
      <!-- Pie chart za prihode i rashode -->
      <div class="chart">
        <h3>Income vs Expenses</h3>
        <!-- Dodajemo v-if kako bi spriječili renderiranje ako nema podataka -->
        <pie-chart v-if="hasData" :chart-data="incomeExpenseData" :options="chartOptions" />
        <p v-else>No data available for the pie chart.</p>
      </div>

      <!-- Bar chart za mjesečne prihode i rashode -->
      <div class="chart">
        <h3>Monthly Breakdown</h3>
        <!-- Dodajemo v-if kako bi spriječili renderiranje ako nema podataka -->
        <bar-chart v-if="hasData" :chart-data="monthlyData" :options="chartOptions" />
        <p v-else>No data available for the bar chart.</p>
      </div>
    </div>
  </div>
</template>

<script>
import { Pie as PieChart, Bar as BarChart } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement,
} from 'chart.js'

// Registriraj komponente Chart.js
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, BarElement)

export default {
  name: 'BudgetCharts',
  components: { PieChart, BarChart },
  data() {
    return {
      // Podaci za grafikone
      incomeExpenseData: {
        labels: ['Income', 'Expenses'],
        datasets: [
          {
            backgroundColor: ['#4CAF50', '#F44336'],
            data: [0, 0], // Početne vrijednosti
          },
        ],
      },
      monthlyData: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Income',
            backgroundColor: '#4CAF50',
            data: [0, 0, 0, 0, 0, 0, 0], // Početne vrijednosti
          },
          {
            label: 'Expenses',
            backgroundColor: '#F44336',
            data: [0, 0, 0, 0, 0, 0, 0], // Početne vrijednosti
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  },
  computed: {
    // Izračunaj ukupne prihode i rashode
    totalIncome() {
      if (!this.$store.state.budgetEntries) return 0 // Dodajemo provjeru za null/undefined
      return this.$store.state.budgetEntries
        .filter((entry) => entry.type === 'Income')
        .reduce((sum, entry) => sum + parseFloat(entry.amount), 0)
    },
    totalExpenses() {
      if (!this.$store.state.budgetEntries) return 0 // Dodajemo provjeru za null/undefined
      return this.$store.state.budgetEntries
        .filter((entry) => entry.type === 'Expense')
        .reduce((sum, entry) => sum + parseFloat(entry.amount), 0)
    },
    // Provjera ima li podataka za prikaz
    hasData() {
      return this.totalIncome > 0 || this.totalExpenses > 0
    },
  },
  watch: {
    // Ažuriraj grafikone kada se promijene podaci
    totalIncome() {
      this.updateCharts()
    },
    totalExpenses() {
      this.updateCharts()
    },
  },
  methods: {
    // Ažuriraj podatke za grafikone
    updateCharts() {
      this.incomeExpenseData.datasets[0].data = [this.totalIncome, this.totalExpenses]

      // Ovdje možeš dodati logiku za mjesečne podatke ako ih imaš
      this.monthlyData.datasets[0].data = [this.totalIncome, 0, 0, 0, 0, 0, 0] // Primjer
      this.monthlyData.datasets[1].data = [this.totalExpenses, 0, 0, 0, 0, 0, 0] // Primjer
    },
  },
  mounted() {
    this.updateCharts() // Ažuriraj grafikone prilikom učitavanja stranice
  },
}
</script>

<style scoped>
.budget-charts {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.chart-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.chart {
  flex: 1 1 45%;
  background: #f9f9f9;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.chart h3 {
  margin-bottom: 20px;
  color: #2a95bf;
}
</style>
