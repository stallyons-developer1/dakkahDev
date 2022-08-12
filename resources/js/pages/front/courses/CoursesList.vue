<template>
    <div>
        <div class="courses d-flex">
            <div   v-for="(course ,n) in courses" :key="n" class="course-box rounded bg-light pd-10">

                <router-link :to="'/courses/single_course/' + course.id" class="course-thumb-bg rounded mg-b-15" :style="course.image ? 'background-image: url(/images/courses/' + course.image + ')'  : 'background-image: url(assets/front/images/course_00-790x550.jpg) '">
                    <a href="/" class="fav-ico" @click.prevent="addFavorite(course.id)">
                        <i v-if="course.favorites ? course.favorites.find((el)=>el.course_id ===course.id):false" class="ri-heart-fill tx-secondary"></i>
                        <i v-else class="ri-heart-line"></i>
                    </a>
                </router-link>
                <div class="pd-10">
                    <div class="course-author d-flex align-items-center justify-content-between mg-b-15">
                        <router-link :to="'/trainer/profile/' + course.created_by" class="d-flex align-items-center tx-danger tx-sm">
                            <i class="ri-user-voice-line tx-md"></i>
                            <span class="pd-x-10">{{ course.users.first_name}}</span>
                        </router-link>

                        <!-- <div class="rating mg-x-10 tx-warning">
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                        </div> -->
                    </div>


                    <h3 class="tx-primary tx-md mg-b-10"><router-link :to="'/courses/single_course/' + course.id">{{ course.title}}</router-link></h3>
                    <p class="tx-sm tx-shade tx-primary">{{ course.description}}</p>
                </div>
            </div>
        </div>
        <no-data v-if="courses.length==0"></no-data>
    </div>
</template>

<script>
    export default {
        name: "CoursesList" ,
        props:{
            page:Number,
            favorites:Boolean
        },
        data(){
            return{
                courses:[],
                data: {},
                searchEmit:'',
                dataError:[],
                isFav:false,
                url:null,
                is_favorite:false,
                favoritesCourses:[],
                info:info,
            }
        },
        methods: {
            getCourses(){
                if (this.page)
                    this.url='/api/courses/get_courses?page=' + this.page;
                else
                    this.url = '/api/courses/get_courses';

                this.$root.PostRequest(this.url , {user_id:this.$route.params.id}).then(response => {
                    return response.json();
                }).then((data) => {
                    this.courses = data.data;
                    this.data = data.data;
                    // this.favoritesCourses = data.data.favorites;
                });
            },
            addFavorite(course_id){
                if (info != null){
                    this.$root.PostRequest('/api/favorite',{user_id:info.user_id,course_id:course_id, is_favorite:this.is_favorite}).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        this.is_favorite = !this.is_favorite;
                        this.getCourses();
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
                    this.is_favorite = this.favoritesCourses.some( el =>{
                        return el.user_id == info.user_id && el.course_id == this.$route.params.id;
                    });
                }
            },
             getFavoriteCourses(){
                this.$root.PostRequest('/api/favorites/myFavorites',{user_id:info.user_id}).then((response) => {
                    if (response.status == 200){
                        this.courses = response.body.data;
                        this.is_favorite = true;
                    }
                });
            }
        },
        async mounted() {
            if (this.favorites){
                await this.getFavoriteCourses();
            }else{
                await this.getCourses();
            }
            this.$root.$on('SEARCH',(data)=>{
                this.courses = data;
                this.data = data;
            });
            await this.checkIsFavorite();
        }
    }
</script>

<style scoped>

</style>
