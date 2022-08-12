<template>
<div>
    <front-search-bar url="/api/courses/search"></front-search-bar>
    <courses-list :page="1"></courses-list>
</div>
</template>

<script>
    export default {
        name: "Index",
        data(){
            return{
                courses:[],
                data: {},
                dataError:[],
            }
        },
        methods: {
        },
        mounted() {
            // this.$root.$on('SEARCH',(data)=>{
            //    this.courses = data;
            // });
        }
    }
</script>

<style scoped>

</style>
