<template>
  <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">All Behaviors</div>
                </div>
                <div class="panel panel-default" v-for="behavior in behaviors" :key="behavior.id">
                    <div class="panel-heading">
                        {{ behavior.created_at | timeToDate }}
                    </div>
                    <div class="panel-body">
                       <div> Breakfast - {{ behavior.breakfast }}</div>
                       <div> Daily Routine - {{ behavior.daily_routine }}</div>
                       <div> Feeling - {{ behavior.feeling }}</div>
                    </div>
                    <div class="panel-footer">
                        <div>
                            <router-link :to="`/edit-behavior/${behavior.id}`">Edit</router-link>
                            <a @click="onDelete(behavior)">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                behaviors: []
            }
        },
        created(){
            const token = localStorage.getItem('token');

            axios.get( `${window.BASE_URL}/api/behaviors?token=${token}` )
                .then( (response) => {
                    this.behaviors = response.data.behaviors
                })
                .catch( (error) => {
                    console.log(error)
                })
        },
        methods: {
            onDelete(behavior) {
                const token = localStorage.getItem('token');

                axios.delete( `${window.BASE_URL}/api/behavior/${behavior.id}?token=${token}` )
                    .then( (response) => {

                        if( response.status == 200 ) {
                            this.behaviors.splice(this.behaviors.indexOf(behavior), 1);
                        }
                        
                    })
                    .catch( (error) => {
                        console.log(error)
                    })
            }
        }
    }
</script>