<template>
    <div>
        <section class="banner">
            <div class="container">
                <div class="inner-slider">
                    <div class="heading">
                        <h1>{{name}}</h1>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        props: {
          name:String,
          isHome:String
        },
        name: "Banner"
    }
</script>

<style scoped>

</style>
