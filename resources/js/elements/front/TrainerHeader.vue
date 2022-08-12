<template>
    <div>
        <!-- <section class="trainer-header pages-header d-flex align-items-center" style="background-image: url(/assets/front/ico/course_00-790x550.jpg) "> -->

            <section class="trainer-header pages-header d-flex align-items-center" :style="profile.background_image ? 'background-image: url(/images/users/' + profile.background_image + ')'  : 'background-image: url(/assets/front/ico/course_00-790x550.jpg) '">

            
            <div class="container d-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center trainer-header-content">
                    <slot v-if="profile.image!=null">
                        <img :src="'/images/users/'+ profile.image" class="trainer-thumb rounded-circle">
                    </slot>
                    <slot v-else>
                        <img src="/images/users/user-icon.jpg" class="trainer-thumb rounded-circle">
                    </slot>
                    <div class="mg-x-10">
                        <a href="#" class="d-flex align-items-center tx-light tx-sm mg-b-10 ">
                            <span class="pd-x-10 tx-lg tx-bold">{{profile.first_name}}</span>
                        </a>
                        <div class="rating mg-x-10 tx-warning" >
                            <i v-for="index in 5" style="cursor: pointer" @click="$route.params.id != null ? setRating(index): false;" :class=" index <= rating? 'ri-star-s-fill':'ri-star-s-line'"></i>
                        </div>
                    </div>
                </div>

                <div class="social-icons d-flex">
                    <a :href="profile.facebook ? profile.facebook:''" target="_blank" class="tx-light mg-x-5"> <i class="ri-2x ri-facebook-box-fill"></i> </a>
                    <a :href="profile.twitter ? profile.twitter:''" target="_blank"  class="tx-light mg-x-5"> <i class="ri-2x ri-twitter-fill"></i> </a>
                    <a :href="profile.snapchat ? profile.snapchat:''" target="_blank" class="tx-light mg-x-5"> <i class="ri-2x ri-instagram-fill"></i> </a>
                    <a :href="profile.linkedin ? profile.linkedin:''" target="_blank" class="tx-light mg-x-5"> <i class="ri-2x ri-linkedin-box-fill"></i> </a>
                </div>



            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "TrainerHeader",
        props:{
            profile:Object | Array,
        },
        data(){
            return{
                courses:[],
                data: {},
                searchEmit:'',
                dataError:[],
                isFav:false,
                url:null,
                rating:[],
                is_rated:0,
                valueRating:'',
                is_favorite:false,
                favoritesCourses:[],
                info:info,
            }
        },
        methods: {
            async getRating(){
                await this.$root.PostRequest('/api/rating/getRating',{trainer_id:this.$route.params.id}).then((response) => {
                    this.rating = response.data.data[0];
                    this.is_rated = response.data.data[0];
                });
            },
            async setRating(rating){
                console.log("pdosfdf")
                if ( info == null){
                    console.log("00")
                    Toast.fire({
                        icon: 'warning',
                        title: 'Please Login Before Rating'
                    });
                    return false;
                }
                if (this.is_rated > 0){
                    Toast.fire({
                        icon: 'warning',
                        title: 'You Already Rated Before'
                    });
                    return false;
                }
                await this.$root.PostRequest('/api/rating/setRating',{trainer_id:this.$route.params.id , rating:rating}).then((response) => {
                    // this.rating = response.data.data;
                    if (response.status == 200){
                        Toast.fire({
                            icon: 'success',
                            title: 'Rating Successfully'
                        });
                        this.getRating();
                    }
                });
            }
        },
        async mounted() {
            await this.getRating();
        }

    }
</script>

<style scoped>

</style>
