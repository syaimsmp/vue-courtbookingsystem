<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>


                    <div class="card-body">
                        <div>
                            <h1> Hi, {{ user_name }} </h1>
                            <small> Check out available booking here <b class="text-danger" >*(8pm-10pm only)</b> </small>
                            <button
                                type="button"
                                class="btn btn-warning"
                                @click="showModal"
                                v-if="$user.role_id == 3"
                                >
                                Register New  User
                            </button>

                           <Modal
                            v-show="modalIsVisible"
                            @close="closeModal"
                            >
                                <template v-slot:header>
                                    Register New User.
                                </template>

                                <template v-slot:body>
                                        <div class="row mb-3">
                                            <div v-if="errors.length != 0" class="alert alert-danger">
                                                <ul>
                                                    <li v-for="(error, idx) in errors" :key="idx">
                                                        {{ error }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" v-model="form.name" required autocomplete="name" autofocus>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control" v-model="form.email" required autocomplete="email">

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="role" class="col-md-4 col-form-label text-md-end">Role</label>

                                            <div class="form-group col-md-6">
                                                <select id="role" class="form-control" v-model="form.role_id">
                                                    <option value="1">User</option>
                                                    <option value="2">Admin</option>
                                                    <option value="3">Super Admin</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" v-model="form.password" required autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" v-model="form.password_confirmation" autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="button" class="btn btn-primary" @click="register">
                                                    Register
                                                </button>
                                            </div>
                                        </div>
                                </template>
                            </Modal>
                        </div>
                    </div>
                </div>
                <court-list></court-list>
            </div>
        </div>
    </div>
</template>

<script>
import CourtList from './CourtList.vue';
import Modal from '../Modal.vue';


    export default {
        components:{
            CourtList,
            Modal,
        },
        data(){
            return {
                user_name: this.$user.name,
                modalIsVisible: false,
                errors: [],
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role_id: '',
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            showModal() {
                this.modalIsVisible = true;
            },
            closeModal() {
                this.modalIsVisible = false;
            },
            async register() {
                this.errors = [];

                if (!this.form.name) {
                    this.errors.push('Name required.');
                }
                if (!this.form.email) {
                    this.errors.push('Email required.');
                }
                if(/\w+@\w+\.\w+$/.test(this.form.email) == false){
                    this.errors.push('Wrong email format');
                }
                if (!this.form.password) {
                    this.errors.push('Password required.');
                }
                if(this.form.password.length < 8){
                        this.errors.push('Password must be more than 8 characters.');
                    }
                if (this.form.password != this.form.password_confirmation) {
                    this.errors.push('Passwords does not match.');
                }

                // let that = this
                if(this.errors.length == 0){
                   await this.axios.post('/register', this.form)
                        .then(
                            res => {
                                console.log(res)
                                this.errors = []
                                this.closeModal()
                            })
                        .catch(err => {
                            console.log(err.response.data.errors)
                            let error_array = Object.entries(err.response.data.errors).flat(2);
                            this.errors = error_array
                        })
                        // .finally(()=> )
                }

            }
        },
    }
</script>
