<template>
  <div class="budget-container">
    <!-- Sidebar Menu -->
    <div class="sidebar">
      <h2>Menu</h2>
      <ul>
        <li><i class="fas fa-home"></i> Home</li>
        <li><i class="fas fa-chart-line"></i> Analytics</li>
        <li><i class="fas fa-cog"></i> Settings</li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="budget-content">
      <h1>Budget Management</h1>
      <p>Track your incomes and expenses.</p>

      <!-- Form for Income -->
      <div class="form-section">
        <h2>Add Income</h2>
        <input v-model="incomeName" placeholder="Income Name" />
        <input v-model.number="incomeAmount" type="number" placeholder="Amount" />
        <button @click="addIncome">Add Income</button>
      </div>

      <!-- Form for Expenses -->
      <div class="form-section">
        <h2>Add Expense</h2>
        <input v-model="expenseName" placeholder="Expense Name" />
        <input v-model.number="expenseAmount" type="number" placeholder="Amount" />
        <button @click="addExpense">Add Expense</button>
      </div>

      <!-- Budget Table -->
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
              <button class="delete-btn" @click="deleteEntry(entry.id, index)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Summary -->
      <h3>Total Income: {{ totalIncome }}</h3>
      <h3>Total Expenses: {{ totalExpenses }}</h3>
      <h3 :class="balanceClass">Balance: {{ balance }}</h3>
    </div>

    <!-- AI Chat Assistant -->
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
export default {
  data() {
    return {
      incomeName: '',
      incomeAmount: '',
      expenseName: '',
      expenseAmount: '',
      budgetEntries: [],
      chatMessages: [], // Uklonjena početna poruka
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
      return this.balance > 0
        ? 'positive-balance'
        : this.balance < 0
          ? 'negative-balance'
          : 'neutral-balance'
    },
  },
  methods: {
    async addIncome() {
      if (this.incomeName && this.incomeAmount) {
        const budgetEntry = {
          korisnik_id: 1, // Zamijeni s pravim ID-om korisnika
          kategorija_id: 3, // ID kategorije za prihod (npr. "Plaća")
          iznos: this.incomeAmount,
          tip: 'prihod',
          opis: this.incomeName,
        }

        try {
          const response = await fetch('http://localhost/budgetbuddy/BACKEND/save_budget.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(budgetEntry),
          })
          const result = await response.json()
          if (result.success) {
            this.budgetEntries.push({
              id: result.id, // ID vraćen iz baze
              name: this.incomeName,
              amount: this.incomeAmount,
              type: 'Income',
            })
            this.incomeName = ''
            this.incomeAmount = ''
          } else {
            console.error(result.message)
          }
        } catch (error) {
          console.error('Error saving income:', error)
        }
      }
    },
    async addExpense() {
      if (this.expenseName && this.expenseAmount) {
        const budgetEntry = {
          korisnik_id: 1, // Zamijeni s pravim ID-om korisnika
          kategorija_id: 1, // ID kategorije za rashod (npr. "Hrana")
          iznos: this.expenseAmount,
          tip: 'rashod',
          opis: this.expenseName,
        }

        try {
          const response = await fetch('http://localhost/budgetbuddy/BACKEND/save_budget.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(budgetEntry),
          })
          const result = await response.json()
          if (result.success) {
            this.budgetEntries.push({
              id: result.id, // ID vraćen iz baze
              name: this.expenseName,
              amount: this.expenseAmount,
              type: 'Expense',
            })
            this.expenseName = ''
            this.expenseAmount = ''
          } else {
            console.error(result.message)
          }
        } catch (error) {
          console.error('Error saving expense:', error)
        }
      }
    },
    async deleteEntry(id, index) {
      try {
        const response = await fetch('http://localhost/budgetbuddy/BACKEND/delete_budget.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ id }),
        })
        const result = await response.json()
        if (result.success) {
          this.budgetEntries.splice(index, 1)
        } else {
          console.error(result.message)
        }
      } catch (error) {
        console.error('Error deleting entry:', error)
      }
    },
    async loadBudgetEntries() {
      try {
        const response = await fetch(
          'http://localhost/budgetbuddy/BACKEND/load_budget.php?korisnik_id=1',
        ) // Zamijeni s pravim ID-om korisnika
        const result = await response.json()
        if (result.success) {
          this.budgetEntries = result.data.map((entry) => ({
            id: entry.id,
            name: entry.opis,
            amount: entry.iznos,
            type: entry.tip === 'prihod' ? 'Income' : 'Expense',
          }))
        } else {
          console.error(result.message)
        }
      } catch (error) {
        console.error('Error loading budget entries:', error)
      }
    },
    async sendMessage() {
      if (!this.userMessage) return

      // Dodaj korisničku poruku u chat
      this.chatMessages.push({ text: this.userMessage, sender: 'user' })

      // Pripremi podatke o budžetu za AI
      const budgetData = {
        income: this.budgetEntries.filter((entry) => entry.type === 'Income'),
        expenses: this.budgetEntries.filter((entry) => entry.type === 'Expense'),
        totalIncome: this.totalIncome,
        totalExpenses: this.totalExpenses,
        balance: this.balance,
      }

      // Pošalji poruku AI-ju s podacima o budžetu
      try {
        const response = await puter.ai.chat(`
          Moj budžet je: ${JSON.stringify(budgetData)}.
          ${this.userMessage}.
          Daj mi kratak savjet, ali ako tražim detalje, objasni opširnije.
          također, budi malo šaljiv.
          odogovor maximalno 3 rečenice.
        `)

        this.chatMessages.push({ text: response, sender: 'ai' })
      } catch (error) {
        console.error('Puter.js error:', error)
        this.chatMessages.push({ text: 'Error contacting AI assistant.', sender: 'ai' })
      }

      // Očisti input polje
      this.userMessage = ''
    },
  },
  mounted() {
    this.loadBudgetEntries() // Učitaj podatke prilikom učitavanja stranice
  },
}
</script>

<style scoped>
.budget-container {
  display: flex;
  height: 100vh; /* Visina cijelog kontejnera */
}

.sidebar {
  width: 200px;
  background: #2a95bf;
  color: white;
  padding: 15px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Dodajemo sjenu */
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar li {
  padding: 15px;
  cursor: pointer;
  border-radius: 5px; /* Zaobljeni rubovi */
  transition: background 0.3s ease;
}

.sidebar li:hover {
  background: #1e7a9e; /* Hover efekat */
}

.budget-content {
  flex-grow: 1;
  padding: 20px;
  background: #f9f9f9; /* Svijetla pozadina */
  border-radius: 10px; /* Zaobljeni rubovi */
  margin: 10px;
  padding-right: 300px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sjena */
  overflow-y: auto; /* Omogući skrolovanje ako je sadržaj predugačak */
}

.budget-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: white;
  border-radius: 10px; /* Zaobljeni rubovi */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sjena */
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

/* AI Chat Styles */
.ai-chat {
  width: 250px;
  background: #f4f4f4;
  position: fixed;
  right: 20px;
  bottom: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  padding: 10px;
}

.chat-box {
  max-height: 200px;
  overflow-y: auto;
  margin-bottom: 10px;
}

.chat-box div {
  margin-bottom: 5px;
}

.chat-box .user {
  text-align: right;
  color: #295fa6;
}

.chat-box .ai {
  text-align: left;
  color: #2a95bf;
}

input {
  width: calc(100% - 20px);
  padding: 5px;
  margin-bottom: 5px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

button {
  width: 100%;
  padding: 5px;
  background: #295fa6;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #1e7a9e;
}

/* Balance colors */
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
