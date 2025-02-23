<template>
  <div>
    <h1>Login Page</h1>
    <p>Welcome to the login page!</p>

    <!-- Obrazac za prijavu -->
    <form @submit.prevent="handleLogin">
      <div>
        <label for="username">Username:</label>
        <input type="text" id="username" v-model="username" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Login</button>
    </form>

    <!-- Prikazivanje greške ako prijava nije uspjela -->
    <p v-if="errorMessage" style="color: red">{{ errorMessage }}</p>

    <!-- Link za registraciju -->
    <p>Don't have an account? <router-link to="/register">Register here</router-link>.</p>
  </div>
</template>

<script>
import axios from 'axios' // Dodaj axios za slanje HTTP zahtjeva

export default {
  name: 'LoginPage',
  data() {
    return {
      username: '',
      password: '',
      errorMessage: '',
    }
  },
  methods: {
    async handleLogin() {
      try {
        // Pošaljite podatke na backend
        const response = await axios.post('http://localhost/budgetbuddy/BACKEND/login.php', {
          username: this.username,
          password: this.password,
        })

        if (response.data.success) {
          // Ako je prijava uspješna, spremi korisnika u local storage
          localStorage.setItem('currentUser', JSON.stringify(response.data.user))

          // Preusmjeri na odgovarajuću stranicu ovisno o ulozi korisnika
          if (response.data.user.tip_korisnika_id === 1) {
            this.$router.push('/admin') // Admin stranica
          } else {
            this.$router.push('/about') // Korisnička stranica
          }
        } else {
          // Ako prijava nije uspjela, prikaži grešku
          this.errorMessage = 'Invalid username or password.'
        }
      } catch (error) {
        console.error('Login error:', error)
        this.errorMessage = 'An error occurred. Please try again.'
      }
    },
  },
}
</script>

<style scoped>
h1 {
  color: #5c3c92;
}

form {
  margin-top: 20px;
}

input {
  margin: 10px 0;
  padding: 8px;
  border-radius: 4px;
}

button {
  padding: 10px 20px;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #369f6b;
}

p {
  font-size: 14px;
  color: #5c3c92;
}
</style>
