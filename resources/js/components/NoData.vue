<template>
    <div class="no-data"> <span class="text-center">{{'No Data' | translate}}</span></div>
</template>

<script>
    export default {
        name: "NoData"
    }
</script>

<style scoped>
.no-data{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150px;
}
</style>
