<template>
    <div>
        <header-bar></header-bar>
        <!--        <header-content></header-content>-->
<!--        <vue-confirm-dialog></vue-confirm-dialog>-->
        <router-view></router-view>
        <footer-bar></footer-bar>
        <vue-progress-bar></vue-progress-bar>

    </div>
</template>

<script>
    import '../../../sass/main.scss';
    import 'remixicon/fonts/remixicon.css';
    export default {
        name: "AppFront",
        mounted(){
        }
    }
</script>

<style lang=>

</style>
