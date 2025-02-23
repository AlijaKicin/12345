<template>
  <div class="admin-container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin!</p>

    <!-- Tabela korisnika -->
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.korisnicko_ime }}</td>
          <td>{{ user.tip_korisnika_id === 1 ? 'Admin' : 'User' }}</td>
          <td>
            <button @click="deleteUser(user.id)">Delete</button>
            <button @click="blockUser(user.id)">Block</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Forma za dodavanje novog korisnika -->
    <div class="add-user-form">
      <h2>Add New User</h2>
      <input v-model="newUsername" placeholder="Username" />
      <input v-model="newPassword" type="password" placeholder="Password" />
      <select v-model="newUserRole">
        <option value="1">Admin</option>
        <option value="2">User</option>
      </select>
      <button @click="addUser">Add User</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AdminView',
  data() {
    return {
      users: [], // Lista korisnika
      newUsername: '', // Novi korisničko ime
      newPassword: '', // Nova lozinka
      newUserRole: 2, // Uloga novog korisnika (default: User)
    }
  },
  methods: {
    // Dohvati sve korisnike
    async fetchUsers() {
      try {
        const response = await axios.get('http://localhost/budgetbuddy/BACKEND/get_users.php')
        if (response.data.success) {
          this.users = response.data.data // Koristi response.data.data
        } else {
          console.error(response.data.message)
        }
      } catch (error) {
        console.error('Error fetching users:', error)
      }
    },
    // Obriši korisnika
    async deleteUser(userId) {
      try {
        const response = await axios.post('http://localhost/budgetbuddy/BACKEND/delete_user.php', {
          id: userId,
        })
        if (response.data.success) {
          this.fetchUsers() // Osvježi listu korisnika
        } else {
          console.error(response.data.message)
        }
      } catch (error) {
        console.error('Error deleting user:', error)
      }
    },
    // Blokiraj korisnika
    async blockUser(userId) {
      try {
        const response = await axios.post('http://localhost/budgetbuddy/BACKEND/block_user.php', {
          id: userId,
        })
        if (response.data.success) {
          this.fetchUsers() // Osvježi listu korisnika
        } else {
          console.error(response.data.message)
        }
      } catch (error) {
        console.error('Error blocking user:', error)
      }
    },
    // Dodaj novog korisnika
    async addUser() {
      try {
        const response = await axios.post('http://localhost/budgetbuddy/BACKEND/add_user.php', {
          username: this.newUsername,
          password: this.newPassword,
          role: this.newUserRole,
        })
        if (response.data.success) {
          this.fetchUsers() // Osvježi listu korisnika
          this.newUsername = ''
          this.newPassword = ''
        } else {
          console.error(response.data.message)
        }
      } catch (error) {
        console.error('Error adding user:', error)
      }
    },
  },
  mounted() {
    this.fetchUsers() // Dohvati korisnike prilikom učitavanja stranice
  },
}
</script>

<style scoped>
.admin-container {
  padding: 20px;
}

.user-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.user-table th,
.user-table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

.user-table th {
  background: #2a95bf;
  color: white;
}

.add-user-form {
  margin-top: 20px;
}

.add-user-form input,
.add-user-form select {
  margin: 5px;
  padding: 8px;
  border-radius: 4px;
}

.add-user-form button {
  padding: 8px 16px;
  background: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.add-user-form button:hover {
  background: #369f6b;
}
</style>
