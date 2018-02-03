<template>
    <div class="container">
        <div class="row">
            <nav>
                <router-link to="/">All Behaviors</router-link>
                <router-link to="/new-behavior">New Behavior</router-link>
                <router-link to="/signup">Signup</router-link>
                <router-link to="/signin">Signin</router-link>
                <a @click.prevent="logOutUser">Logout</a>
            </nav>
        </div>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>    

    export default {
        data(){
            return {}
        },
        methods: {
            logOutUser(){
                localStorage.removeItem('token');
                this.$router.push('/signin')

            }
        }

    }

</script>

<style scoped> 
    nav{
        padding: 10px
    }
    nav a{
        padding: 0 10px;
    }
</style>
