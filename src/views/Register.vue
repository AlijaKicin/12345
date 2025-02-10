<template>
  <div>
    <h1>Register</h1>
    <form @submit.prevent="register">
      <div>
        <label for="username">Username:</label>
        <input id="username" v-model="username" type="text" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input id="password" v-model="password" type="password" required />
      </div>
      <div>
        <label for="confirmPassword">Confirm Password:</label>
        <input id="confirmPassword" v-model="confirmPassword" type="password" required />
      </div>
      <button type="submit">Register</button>
    </form>
    <p v-if="error" style="color: red">{{ error }}</p>
  </div>
</template>

<script>
export default {
  name: 'UserRegister',
  data() {
    return {
      username: '',
      password: '',
      confirmPassword: '',
      error: null,
    }
  },
  methods: {
    async register() {
      if (this.password !== this.confirmPassword) {
        this.error = 'Passwords do not match!'
        return
      }
      try {
        console.log('Sending data:', {
          username: this.username,
          password: this.password,
        })
        const response = await fetch('http://localhost/budgetbuddy/BACKEND/register.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            username: this.username,
            password: this.password,
          }),
        })
        const result = await response.json()
        if (result.success) {
          this.$router.push('/login')
        } else {
          this.error = result.message
        }
      } catch (error) {
        console.error(error)
        this.error = 'An error occurred during registration.'
      }
    },
  },
}
</script>
