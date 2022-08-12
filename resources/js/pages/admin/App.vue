<template>
    <div>
        <admin-menu></admin-menu>
<!--        <header-content></header-content>-->
        <vue-confirm-dialog></vue-confirm-dialog>
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>

    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>
