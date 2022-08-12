<template>
    <div>
        <div class="card-header">
            <h3 class="card-title"><router-link :to="url" class="btn btn-primary float-right"> {{ name | translate}}</router-link></h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" v-model="search_word" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                        <button type="submit" @click.prevent="search()" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: String,
            name: String
        },
        name: "SearchBar",
        data() {
            return {
               search_word:""
            }
        },
        methods: {
         search() {
             this.$root.$emit('SEARCH-WORD',this.search_word)
         }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
