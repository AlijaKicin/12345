<template>
  <div class="guest-budget-container">
    <h1>Budget Table (Guest View)</h1>
    <p>
      You are viewing this page as a guest. Please <router-link to="/login">login</router-link> to
      access all features.
    </p>

    <!-- Budget Table -->
    <table class="budget-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Amount</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(entry, index) in budgetEntries" :key="index">
          <td>{{ entry.name }}</td>
          <td>{{ entry.amount }}</td>
          <td>{{ entry.type }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Summary -->
    <h3>Total Income: {{ totalIncome }}</h3>
    <h3>Total Expenses: {{ totalExpenses }}</h3>
    <h3 :class="balanceClass">Balance: {{ balance }}</h3>
  </div>
</template>

<script>
export default {
  name: 'GuestBudget',
  data() {
    return {
      budgetEntries: [
        { id: 1, name: 'Salary', amount: 2000, type: 'Income' },
        { id: 2, name: 'Food', amount: 100, type: 'Expense' },
        { id: 3, name: 'Rent', amount: 500, type: 'Expense' },
      ], // Primjer podataka za goste
    }
  },
  computed: {
    totalIncome() {
      return this.budgetEntries
        .filter((entry) => entry.type === 'Income')
        .reduce((sum, entry) => sum + entry.amount, 0)
    },
    totalExpenses() {
      return this.budgetEntries
        .filter((entry) => entry.type === 'Expense')
        .reduce((sum, entry) => sum + entry.amount, 0)
    },
    balance() {
      return this.totalIncome - this.totalExpenses
    },
    balanceClass() {
      return this.balance > 0
        ? 'positive-balance'
        : this.balance < 0
          ? 'negative-balance'
          : 'neutral-balance'
    },
  },
}
</script>

<style scoped>
.guest-budget-container {
  padding: 20px;
}

.budget-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.budget-table th,
.budget-table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

.budget-table th {
  background: #2a95bf;
  color: white;
}

.positive-balance {
  color: green;
  font-weight: bold;
}

.negative-balance {
  color: red;
  font-weight: bold;
}

.neutral-balance {
  color: gray;
  font-weight: bold;
}
</style>
