<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sign In
                    </div>
                    <form class="panel-body" v-on:submit.prevent="submitForm">

                        <p class="text-danger" v-if="this.$route.query.notLoggedin">
                            You must be logged in to do that
                        </p>

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
                        
                        <button type="submit" class="btn btn-primary" @click.prevent="signIn" :disabled="errors.any() || !isComplete">Sign in</button>
                        <p class="text-danger" v-if="serverError" v-for="(error, key) in serverError" :key="key" >{{ error }}</p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';

    Vue.use(VeeValidate); 

    export default {
        data(){
            return {
                email: '',
                password: '',
                serverError: {}
            }
        },
         computed: {
            isComplete () {
                return this.email && this.password;
            }
        },
        methods: {
            signIn(){
                const { email, password } = this;

                axios.post(`${window.BASE_URL}/api/user/signin`, { email, password }, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest'}
                    })
                    .then((response) => {
                        const token = response.data.token;
                        const bas64url = token.split('.')[1];
                        const base64 = bas64url.replace('-', '+').replace('_', '/');

                        if( response.status === 200 ){
                            console.log(response)
                            localStorage.setItem('token', token);
                            this.$router.push('/');
                        }
                    })
                    .catch((error) => {
                       this.serverError = error.response.data;
                    });
            }
        }
    }
</script>
