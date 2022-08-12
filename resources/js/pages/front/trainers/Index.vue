<template>
    <div>
        <front-search-bar url="/api/trainer/search" v-if="showSearch"></front-search-bar>
        <section class="pd-y-40">

            <div class="container">

                <div class="d-flex justify-content-between mg-b-15">
                    <h3>المدربين الاكثر تميزا</h3>
                    <a href="#" class="tx-secondary">عرض كل المدربين</a>
                </div>

                <div class="courses trainers-list d-flex">

                    <div v-for="(trainer ,n) in trainers" :key="n" class="course-box trainers-list-box rounded bg-light">

                        <router-link :to="'/trainer/profile/' + trainer.id" class="trainer-thumb-bg rounded-circle mg-b-15" :style="trainer.image ? 'background-image: url(/images/users/' + trainer.image + ')'  : 'background-image: url(/images/users/user-icon.jpg) '"></router-link>

                        <div class="pd-10">
                            <div class="course-author mg-b-15 tx-center">
                                <a href="#" class="tx-md tx-center tx-sm">
                                    {{ trainer.first_name}}
                                </a>
                                <div class="rating mg-10 tx-warning">
                                    <!-- <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i> -->
                                </div>

                                <router-link :to="'/trainer/profile/' + trainer.id" class="btn btn-rounded btn-secondary">الملف الشخصي</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "Index" ,
        props: ['count','showSearchBar'],
        data(){
            return{
                trainers:[],
                data: {},
                search:'',
                dataError:[],
                showSearch:false,
            }
        },
        methods: {
            getTrainers(){
                this.$root.PostRequest('/api/trainers').then((response) => {
                    this.trainers = response.data.data;
                    // this.data = data.data;
                });
            },
        },
        mounted() {
            this.getTrainers();
            this.$root.$on('SEARCH',(data)=>{
                this.trainers = data;
            });
            if (this.showSearchBar == undefined)
                this.showSearch  = true;
            else
                this.showSearch = this.showSearchBar;
        }
    }
</script>

<style scoped>

</style>
