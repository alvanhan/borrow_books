<template>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>REGISTER</h4>
                        <hr>
                        <form @submit.prevent="register">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" v-model="user.name" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div v-if="validation && validation.name" class="mt-2 alert alert-danger">
                                        {{ validation.name[0] }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" v-model="user.email" class="form-control"
                                            placeholder="Email Address">
                                    </div>
                                    <div v-if="validation && validation.email" class="mt-2 alert alert-danger">
                                        {{ validation.email[0] }}
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" v-model="user.password" class="form-control"
                                            placeholder="Password">
                                    </div>
                                    <div v-if="validation && validation.password" class="mt-2 alert alert-danger">
                                        {{ validation.password[0] }}
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3 btn-block">REGISTER</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
    setup() {
        const router = useRouter()
        const user = reactive({
            name: '',
            email: '',
            password: '',
        })
        const validation = ref([])
        function register() {
            let name = user.name
            let email = user.email
            let password = user.password
            axios.post('http://localhost:8000/api/register', {
                name,
                email,
                password,
            })
                .then(() => {
                    return router.push({
                        name: 'login'
                    })
                }).catch(error => {
                    validation.value = error.response.data.data || 'An error occurred during registration.';
                })

        }
        return {
            user,
            validation,
            register
        }

    }

}
</script>
  