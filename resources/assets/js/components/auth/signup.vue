<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sign Up
                    </div>
                    <p class="text-danger" v-if="serverError" v-for="(error, key) in serverError" :key="key">{{ error[0] }}</p>

                    <form class="panel-body" v-on:submit.prevent="submitForm">
                        
                        <div class="form-group" :class="{'has-error': errors.has('name') }">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" v-model="name" v-validate:name="'required'">
                            <p class="text-danger" v-if="errors.has('name')">{{ errors.first('name') }}</p>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('email') }">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" v-model="email" v-validate:email="'required|email'">
                            <p class="text-danger" v-if="errors.has('email')">{{ errors.first('email') }}</p>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('password') }">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" v-model="password" v-validate:password="'required'">
                            <p class="text-danger" v-if="errors.has('password')">{{ errors.first('password') }}</p>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" @click.prevent="signUp" :disabled="errors.any() || !isComplete">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                name: '',
                email: '',
                password: '',
                serverError: ''
            }
        },
        methods: {
            signUp(){
                const { name, email, password } = this;

                axios.post(`${window.BASE_URL}/api/user`, { name, email, password }, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest'}
                    })
                    .then((response) => {
                        if( response.status === 201 ){
                            this.$router.push('/signin')
                        }
                    })
                    .catch((error) => {
                        this.serverError = error.response.data;
                    });
            }
        },
        computed: {
            isComplete () {
                return this.name && this.email && this.password;
            }
        },

    }
</script>