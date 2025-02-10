<template>
  <div class="budget">
    <h1>Budget Management</h1>
    <p>Track your incomes and expenses.</p>

    <!-- Forma za unos prihoda -->
    <div class="form-section">
      <h2>Add Income</h2>
      <input v-model="incomeName" placeholder="Income Name" />
      <input v-model.number="incomeAmount" type="number" placeholder="Amount" />
      <button @click="addIncome">Add Income</button>
    </div>

    <!-- Forma za unos rashoda -->
    <div class="form-section">
      <h2>Add Expense</h2>
      <input v-model="expenseName" placeholder="Expense Name" />
      <input v-model.number="expenseAmount" type="number" placeholder="Amount" />
      <button @click="addExpense">Add Expense</button>
    </div>

    <!-- Tablica prihoda i rashoda -->
    <table class="budget-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Amount</th>
          <th>Type</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(entry, index) in budgetEntries" :key="index">
          <td>{{ entry.name }}</td>
          <td>{{ entry.amount }}</td>
          <td>{{ entry.type }}</td>
          <td>
            <button class="delete-btn" @click="deleteEntry(index)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Vizualni prikaz -->
    <h3>Total Income: {{ totalIncome }}</h3>
    <h3>Total Expenses: {{ totalExpenses }}</h3>
    <h3 :class="balanceClass">Balance: {{ balance }}</h3>

    <!-- AI Asistent -->
    <div class="ai-chat">
      <h2>AI Assistant</h2>
      <div class="chat-box">
        <div v-for="(msg, index) in chatMessages" :key="index" :class="msg.sender">
          {{ msg.text }}
        </div>
      </div>
      <input v-model="userMessage" placeholder="Ask AI for advice..." />
      <button @click="sendMessage">Send</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      incomeName: '',
      incomeAmount: '',
      expenseName: '',
      expenseAmount: '',
      budgetEntries: [],
      chatMessages: [],
      userMessage: '',
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
      if (this.balance > 0) return 'positive-balance'
      if (this.balance < 0) return 'negative-balance'
      return 'neutral-balance'
    },
  },
  methods: {
    addIncome() {
      if (this.incomeName && this.incomeAmount) {
        this.budgetEntries.push({
          name: this.incomeName,
          amount: this.incomeAmount,
          type: 'Income',
        })
        this.incomeName = ''
        this.incomeAmount = ''
      }
    },
    addExpense() {
      if (this.expenseName && this.expenseAmount) {
        this.budgetEntries.push({
          name: this.expenseName,
          amount: this.expenseAmount,
          type: 'Expense',
        })
        this.expenseName = ''
        this.expenseAmount = ''
      }
    },
    deleteEntry(index) {
      this.budgetEntries.splice(index, 1)
    },
    async sendMessage() {
      if (!this.userMessage) return
      this.chatMessages.push({ text: this.userMessage, sender: 'user' })

      try {
        const response = await axios.post('http://localhost/budgetbuddy/BACKEND/chat.php', {
          message: this.userMessage,
        })
        console.log('AI Response:', response.data) // LOGIRANJE
        this.chatMessages.push({ text: response.data.reply, sender: 'ai' })
      } catch (error) {
        console.error('Axios error:', error.response ? error.response.data : error.message) // LOGIRANJE GREŠKE
        this.chatMessages.push({ text: 'Error contacting AI assistant.', sender: 'ai' })
      }

      this.userMessage = ''
    },
  },
}
</script>

<style scoped>
.budget-table {
  width: 100%;
  margin-top: 20px;
  border-collapse: collapse;
}

.budget-table th,
.budget-table td {
  padding: 8px;
  text-align: center;
  width: auto;
  white-space: nowrap;
}

.budget-table th {
  background-color: #295fa6;
  color: white;
}
</style>
