<template>
    <section class="pages-header" style="background-image: url(/assets/front/ico/course_00-790x550.jpg) ">
        <div class="container d-flex pd-t-40 flex-wrap align-items-center  justify-content-between">
            <div class="trainer-header-content">
                <h1 class="tx-light tx-xl mg-b-15">{{courseDetails.title}}</h1>
                <div class="d-flex align-items-center mg-b-20 ">
                    <div class="trainer-thumb-sm rounded-circle" style="background-image: url(/assets/front/ico/course_00-790x550.jpg)"></div>
                    <div class="mg-x-10">
                        <a href="#" class="d-flex align-items-center tx-light tx-sm mg-b-10 ">
                            <span class="pd-x-10 tx-lg tx-bold">{{courseDetails.users ? courseDetails.users.first_name :'--'}}</span>
                        </a>
                        <div class="rating mg-x-10 tx-warning" >
                            <i v-for="index in 5" style="cursor: pointer" @click="courseDetails.users.id != null ? setRating(index): false;" :class=" index <= rating? 'ri-star-s-fill':'ri-star-s-line'"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" social-icons">
                <div class="social-icons d-flex" style="margin-bottom: 15px;" v-if="courseDetails.users">
                    <a  :href="courseDetails.users.facebook ? courseDetails.users.facebook:''" target="_blank" class="tx-light mg-x-5"> <i class="ri-2x ri-facebook-box-fill"></i> </a>
                    <a  :href="courseDetails.users.twitter ? courseDetails.users.twitter:''" target="_blank"  class="tx-light mg-x-5"> <i class="ri-2x ri-twitter-fill"></i> </a>
                    <a   :href="courseDetails.users.snapchat ? courseDetails.users.snapchat:''" target="_blank" class="tx-light mg-x-5"> <i class="ri-2x ri-instagram-fill"></i> </a>
                    <a   :href="courseDetails.users.linkedin ? courseDetails.users.linkedin:''" target="_blank" class="tx-light mg-x-5"> <i class="ri-2x ri-linkedin-box-fill"></i> </a>
                </div>
                <div class="d-flex mg-b-20">
                    <a href="#" @click.prevent="addFavorite()" class="footer-ico bg-light rounded-circle d-flex align-items-center justify-content-center">
                        <i :class="is_favorite ? 'ri-heart-fill tx-xl tx-secondary':'ri-heart-line tx-xl tx-primary'"></i>
                    </a>

                    <a href="#" class="footer-ico mg-x-10 bg-light rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ri-share-line tx-xl tx-primary"></i>
                    </a>

                </div>
                <div class="tx-end pd-y-10 course-actions">
                    <a href="#" class="btn btn-rounded btn-secondary" @click="startTrainer(courseDetails.course_id)">{{is_subscription ? 'الغاء الاشتراك' : 'بدأ التدريب الآن'}} </a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="course-meta pd-30 bg-light">
                <div class="d-flex">

                    <div class="meta-box flex-fill d-flex align-items-center">
                        <i class="ri-calendar-event-line ri-2x tx-secondary"></i>
                        <div class="meta-box-data pd-x-10">
                            <h4 class="tx-md tx-primary">فترة التدريب</h4>
                            <p class="tx-sm tx-shade tx-primary">{{courseDetails.start_date}} - {{courseDetails.end_date}}</p>
                        </div>
                    </div>
                    <div class="meta-box flex-fill d-flex align-items-center">
                        <i class="ri-user-follow-line ri-2x tx-secondary"></i>
                        <div class="meta-box-data pd-x-10">
                            <h4 class="tx-md tx-primary">فئة الحضور</h4>
                            <p class="tx-sm tx-shade tx-primary">{{courseDetails.gender}}</p>
                        </div>
                    </div>
                    <div class="meta-box flex-fill d-flex align-items-center">
                        <i class="ri-map-pin-line ri-2x tx-secondary"></i>
                        <div class="meta-box-data pd-x-10">
                            <h4 class="tx-md tx-primary">مكان الدورة</h4>
                            <p class="tx-sm tx-shade tx-primary">{{courseDetails.location}}</p>
                        </div>
                    </div>
                    <div class="meta-box flex-fill d-flex align-items-center">
                        <i class="ri-global-line ri-2x tx-secondary"></i>
                        <div class="meta-box-data pd-x-10">
                            <h4 class="tx-md tx-primary">اللغة</h4>
                            <p class="tx-sm tx-shade tx-primary">{{courseDetails.language}}</p>
                        </div>
                    </div>

                    <div class="meta-box d-flex align-items-center">
                        <i class="ri-bank-card-line ri-2x tx-secondary"></i>
                        <div class="meta-box-data pd-x-10">
                            <h4 class="tx-md tx-primary">سعر الدورة</h4>
                            <p class="tx-sm tx-shade tx-primary">{{courseDetails.price}}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</template>

<script>
    export default {
        name: "CourseHeader",
        props:{
            courseDetails:Object | Array
        },
        data(){
            return{
                info:info,
                single_course:[],
                data: {},
                search:'',
                dataError:[],
                rating:[],
                is_rated:0,
                valueRating:'',
                trainer_id :'',
                is_favorite:false,
                is_subscription:false,
                favorites:[],
            }
        },
        methods:{
            addFavorite(){
                if (info != null){
                    this.$root.PostRequest('/api/favorite',{user_id:info.user_id,course_id:this.$route.params.id, is_favorite:this.is_favorite}).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        this.is_favorite = !this.is_favorite;
                    });
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'Please Login'
                    });
                }
            },
            startTrainer(){
                if (info != null){
                    this.$root.PostRequest('/api/subscriptionCourse',{user_id:info.user_id,course_id:this.$route.params.id}).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        this.is_subscription = !this.is_subscription;
                    });
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'Please Login'
                    });
                }
            },
            checkIsFavorite(){
                if(info != null){
                    this.is_favorite = this.favorites.some( el =>{
                        return el.user_id == info.user_id && el.course_id == this.$route.params.id;
                    });
                }
            },
            async getRating(){
                await this.$root.PostRequest('/api/rating/getRating',{trainer_id:this.trainer_id}).then((response) => {
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
                await this.$root.PostRequest('/api/rating/setRating',{trainer_id:this.trainer_id , rating:rating}).then((response) => {
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
            await this.checkIsFavorite();
            await this.getRating();
        },
        watch:{
            'courseDetails':function () {
                this.trainer_id = this.courseDetails.users.id
            }
        }
    }
</script>

<style scoped>

</style>
