<template>
    <div>
        <home-banner></home-banner>
        <front-search-bar url="/api/trainer/search"></front-search-bar>
        <section class="pd-y-40">
            <trainers-list :count="5" :showSearchBar="false"></trainers-list>
        </section>
        <why-us></why-us>
        <Newsletter></Newsletter>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data(){
            return {
                wordSearch:''
            }
        },
        mounted(){
        },
        methods:{
        }
    }
</script>

<style lang='scss'>

</style>
