<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        How was your day?
                    </div>

                    <form class="panel-body" v-on:submit.prevent="submitForm">
            
                        <div class="form-group" :class="{'has-error': errors.has('breakfast') }">
                            <label class="form-label" for="breakfast">What did you eat today for breakfast?</label>
                            <select v-model="breakfast" name="breakfast" v-validate data-vv-rules="required" class="form-control">
                                <option value="">Please select an option</option>
                                <option v-for="( option, key, i ) in options.breakfast.selectOptions" :value="option"  :key="i">
                                    {{option}}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.has('breakfast')">{{ errors.first('breakfast') }}</p>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('daily_routine') }">
                            <label class="form-label" for="daily_routine">What did you do today?</label>
                            <select v-model="daily_routine" name="daily_routine" v-validate data-vv-rules="required" class="form-control">
                                <option value="" >Please select an option</option>
                                <option v-for="( option, key, i ) in options.daily_routine.selectOptions" :value="option" :key="i">
                                  {{option}}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.has('daily_routine')">{{ errors.first('daily_routine') }}</p>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('feeling') }">
                            <label class="form-label" for="feeling">How did you feel today?</label>
                            <select v-model="feeling" name="feeling" v-validate data-vv-rules="required"  class="form-control">
                                <option value="" >Please select an option</option>
                                <option v-for="( option, key, i ) in options.feeling.selectOptions" :value="option" :key="i">
                                  {{option}}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.has('feeling')">{{ errors.first('feeling') }}</p>
                        </div>

                        <button v-if="this.editing" class="btn btn-primary" :disabled="errors.any() || !isComplete">
                            Update
                        </button>
                        <button v-else class="btn btn-primary" :disabled="errors.any() || !isComplete">
                            Submit
                        </button>

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
        props: ['editing'],
        data(){
            return {
                breakfast: '',
                daily_routine: '',
                feeling: '',
                options: {
                    breakfast: {
                        selectOptions: [
                            'eggs', 
                            'cereal', 
                            'toast'
                        ]
                    },
                    daily_routine: {
                        selectOptions: [
                            'work', 
                            'relax', 
                            'exercise'
                        ]
                    },
                    feeling: {
                        selectOptions: [
                            'bad', 
                            'good', 
                            'great'
                        ]
                    }
                } 
            }
        },
        methods: {
            submitForm(e) {
                const { breakfast, daily_routine, feeling } = this;
                const token = localStorage.getItem('token');

                if( this.editing ) {

                    axios.put(`${window.BASE_URL}/api/behavior/${this.$route.params.id}?token=${token}`, { breakfast, daily_routine, feeling })
                        .then((response) => {
                            if( response.status === 200 ){
                                this.$router.push('/')
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });

                } else {

                    axios.post(`${window.BASE_URL}/api/behavior?token=${token}`, { breakfast, daily_routine, feeling })
                        .then((response) => {
                             if( response.status === 201 ){
                                this.$router.push('/')
                            }
                        })
                        .catch((error) => {
                            if( response.status === 400 ){
                                this.$router.push('/signin')
                            }
                        });

                    
                }
                
            }
        },
        computed: {
            isComplete () {
                return this.breakfast && this.daily_routine && this.feeling;
            }
        },
        created(){
            const token = localStorage.getItem('token');

            if( this.editing ){
                axios.get( `${window.BASE_URL}/api/behavior/${this.$route.params.id}?token=${token}` )
                    .then( (response) => {
                        const currentBehavior = response.data.behavior;
                        this.breakfast = currentBehavior.breakfast;
                        this.daily_routine = currentBehavior.daily_routine;
                        this.feeling = currentBehavior.feeling;
                        console.log(response.data.behavior);
                    })
                    .catch( (error) => {
                        console.log(error)
                    })
            }
        },
        mounted() {
            console.log('Component mounted.',  )
        },
        
    }
</script>
