
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue';
import VueRouter from 'vue-router'
import momenet from 'moment';

import App from './components/app.vue'
import AllBehaviors from './components/behaviors.vue';
import BehaviorForm from './components/behavior-form.vue';
import SignUp from './components/auth/signup.vue';
import SignIn from './components/auth/signin.vue';

Vue.filter('timeToDate', function( value ) {
    if ( value ) {
        return momenet( String(value) ).format( 'MMMM Do YYYY, h:mm:ss a' );
    }
});

Vue.use(VueRouter);

const routes = [
    {
        path: '', 
        component: AllBehaviors,
        beforeEnter: (to, from, next) => {
            if( !!localStorage.getItem('token') ){
                next(true);
            } else {
                next( '/signin?notLoggedin=true' );
            }
        }
    },
    {
        path: `/new-behavior`, 
        component: BehaviorForm,
        beforeEnter: (to, from, next) => {
            if( !!localStorage.getItem('token') ){
                next(true);
            } else {
                next( `/signin?notLoggedin=true` );
            }
        }
    },
    {
        path: `/edit-behavior/:id`, 
        component: BehaviorForm,
        props: () => ({ editing: true }),
        beforeEnter: (to, from, next) => {
            if( !!localStorage.getItem('token') ){
                next(true);
            } else {
                next( `/signin?notLoggedin=true` );
            }
        }
    },
    {
        path: `/signup`, 
        component: SignUp
    },
    {
        path: `/signin`, 
        component: SignIn
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
