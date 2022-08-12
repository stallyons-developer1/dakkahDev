<template>
    <div>
        <front-search-bar url="/api/courses/search"></front-search-bar>
        <courses-list></courses-list>
    </div>
</template>

<script>
    export default {
        name: "MyCourses" ,
        data(){
            return{
                courses:[],
                data: {},
                dataError:[],
            }
        },
        methods: {
            // getMyCourses(page = 1){
            //     this.$root.PostRequest('/api/courses/get_my_courses?page=' + page , {id:this.$route.params.id}).then(response => {
            //         return response.json();
            //     }).then((data) => {
            //         this.courses = data.data;
            //         this.data = data.data;
            //     });
            // },
        },
        mounted() {
            // this.getMyCourses();
            // this.$root.$on('SEARCH',(data)=>{
            //     this.courses = data;
            // });
        }
    }
</script>

<style scoped>

</style>
