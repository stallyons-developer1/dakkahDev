<template>
   <div>
       <front-search-bar></front-search-bar>
        <courses-list :favorites="true"></courses-list>
   </div>
</template>

<script>
    export default {
        name: "Favorites" ,
        data(){
            return{
                info:info,
                profile:[],
                data: {},
                search:'',
                dataError:[],
                user_id:'',
                is_follow:false,
                followers:[],
                courses:[]
            }
        },
        methods: {

        },
        async mounted() {

        }
    }
</script>

<style scoped>

</style>
