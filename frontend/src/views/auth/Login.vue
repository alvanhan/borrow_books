<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input v-model="user.email" type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input v-model="user.password" type="password" class="form-control" id="password" required>
                            </div>
                            <div v-if="error" class="alert alert-danger mt-3" role="alert">
                                {{ error }}
                            </div>
                            <button type="submit" class="btn btn-success">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { reactive, ref } from 'vue'
import axios from 'axios'

export default {
    data() {
        return {
            user: {
                email: '',
                password: '',
            },
            error: null,
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://localhost:8000/api/login', {
                    email: this.user.email,
                    password: this.user.password,
                });

                if (response.data.success) {
                    localStorage.setItem('authToken', response.data.data.token);
                    await this.$router.push({ name: 'dashboard' });
                    window.location.reload(true);
                } else {
                    this.error = response.data.message;
                }
            } catch (error) {
                this.error = error.response.data.data.error || 'An error occurred during login.';
                console.error(error);
            }
        },
    },
};
</script>
  
<style></style>
  