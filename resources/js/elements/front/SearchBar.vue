<template>
        <section class="header-search bg-dark pd-y-20">
            <div class="container">
                <form action="#" method=""  @submit.prevent>
                    <div class="d-flex search-fields">
                        <div class="form-group form-field">
                            <i class="form-ico ri-search-2-line"></i>
                            <input placeholder="كلمات البحث" type="text" v-model="searchWord" value="" class="btn-rounded form-control" />
                        </div>
                        <div class="form-group mg-x-10 form-field">
                            <i class="form-ico select-ico ri-arrow-down-s-line"></i>
                            <select name="" v-model="selectedCategory" class="btn-rounded form-control" >
                                <option value="">إختر التصنيف المناسب</option>
                                <option value="" :value="cateogry.category_en" v-for="cateogry in categories">{{cateogry.category_en}}</option>
                            </select>
                        </div>
                        <div class="form-group form-field mg-l-10">
                            <i class="form-ico select-ico ri-arrow-down-s-line"></i>
                            <select name=""  v-model="selected" class="btn-rounded form-control" >
                                <option value="">إختر المدينة</option>
                                <option :value="city.name_en" v-for="city in cities">{{city.name_ar}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-rounded" @click="search">بحث</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
</template>

<script>
    export default {
        props:{'url':String},
        name: "SearchBar",
        data(){
            return{
                cities:[],
                categories:[],
                selected: null,
                selectedCategory: null,
                searchWord:'',
            }
        },
        methods:{
            search(){
                console.log(this.searchWord)
                this.$root.PostRequest(this.url , {search:this.searchWord , city:this.selected , category:this.selectedCategory}).then((response) => {
                    this.courses = response.data.data;
                    this.data = response.data;
                    this.$root.$emit('SEARCH',this.courses);
                });
            },
            async getCities(){
                await this.$root.GetRequest('/api/admin/cities/list').then( async data => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.cities = await data.body.data;
                    // console.log(this.data)
                });
            },
            async getCategories(){
                await this.$root.GetRequest('/api/category').then( async data => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.categories = await data.body.data;
                });
            },
        },mounted() {
            this.getCities();
            this.getCategories();
        }
    }
</script>

<style scoped>

</style>
