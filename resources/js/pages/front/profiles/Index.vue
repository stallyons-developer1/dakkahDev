<template>
    <div>
        <section>
            <trainer-header :profile="profile" :rating="rating"></trainer-header>
            <div class="container">
                <section class="pd-y-40">
                    <div class="about-section pd-40 bg-light rounded">
                        <h3 class="mg-b-10 tx-primary"></h3>
                        <p class="tx-shade tx-primary">{{ profile.first_name}}</p>
                        <br>
                        <h3 class="mg-b-10 tx-primary"> نبذة عني</h3>
                        <p class="tx-shade tx-primary">من الصعب نجاح أي عمل دون وجود خطة محددة ومدروسة له، لذا كان من الضروري الاهتمام بتخطيط المشروعات؛ وذلك
                            لدورها الفاعل في تحقيق الأهداف المرجوة من المشروع. ونظرًا إلى أن المنظمات محدودة الموارد، من هنا تأتي أهمية
                            عملية التخطيط لأنها تُساعد المنظمات على اتخاذ قرارات صائبة نحو تعيين الموارد للوصول إلى الأهداف. ويهدف هذا
                            البرنامج التدريبي إلى التعرف على أساسيات ومفاهيم برمجة المشاريع الهندسية إضافةً إلى تطبيقها عمليًا على
                            برنامج Microsoft Project.</p>
                    </div>
                </section>
                <section class="pd-y-40">
                    <div class="d-flex justify-content-between mg-b-15">
                        <h3> الدورات التدريبية</h3>
                    </div>
                    <courses-list :count="5"></courses-list>
                </section>
            </div>
        </section>
<!--        <section class="main">-->
<!--            <div class="container">-->
<!--                <div class="inner-main">-->
<!--                    <div class="img-Div">-->
<!--                        <img :src="profile.image ? '/images/users/'+ profile.image : '/images/users/user_default_img.png'">-->
<!--                    </div>-->
<!--                    <div class="txt-Div">-->
<!--                        <h2>{{profile.first_name + ' ' + profile.last_name}}</h2>-->
<!--                        <h3>Product Designer</h3>-->
<!--                        <div class="stars-span">-->
<!--                            <span class="heading">{{rating !=null ? parseFloat(rating).toFixed(2):''}}</span>-->
<!--                            <span v-for="index in 5" style="cursor: pointer" @click="$route.params.id != null ? setRating(index): false;" :class=" index <= rating? 'fa fa-star checked':'fa fa-star'" ></span>-->
<!--&lt;!&ndash;                            <span class="fa fa-star checked"></span>&ndash;&gt;-->
<!--&lt;!&ndash;                            <span class="fa fa-star checked"></span>&ndash;&gt;-->
<!--&lt;!&ndash;                            <span class="fa fa-star checked"></span>&ndash;&gt;-->
<!--&lt;!&ndash;                            <span class="fa fa-star Unchecked"></span><br>&ndash;&gt;-->
<!--                        </div>-->
<!--                        <ul>-->
<!--                            <li><a href="#" @click.prevent="follow" v-if="info != null && this.$route.params.id != null && info.user_id != this.$route.params.id">{{ is_follow ? 'UnFollow':'Follow'}}</a></li>-->
<!--                            <li><img src="/assets/front/images/mail-send.svg"></li>-->
<!--                            <li><img src="/assets/front/images/call.svg"></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!--        <section class="texd">-->
<!--            <div class="container">-->
<!--                <div class="container My-Container">-->
<!--                    <div class="main-Tabs">-->

<!--                        <div class="tab">-->
<!--                            <button class="tablinks active" onclick="openCity(event, 'About-Us')">About Us</button>-->
<!--                            <button class="tablinks" onclick="openCity(event, 'Paris')">Courses</button>-->
<!--                            <button class="tablinks" onclick="openCity(event, 'Tokyo')">Contact Us</button>-->
<!--                        </div>-->

<!--                        <div id="About-Us" class="tabcontent active">-->
<!--                            <h3>About Us</h3>-->
<!--                            <p>{{profile.description}}</p>-->
<!--                        </div>-->

<!--                        <div id="Paris" class="tabcontent">-->
<!--                            <h3>Courses</h3>-->
<!--                            <p v-for="course in profile.courses">{{course.title}}</p>-->
<!--                        </div>-->

<!--                        <div id="Tokyo" class="tabcontent">-->
<!--                            <h3>Contact Us</h3>-->
<!--                            <p>phone:{{profile.phone}}</p>-->
<!--                            <p>linkedin:{{profile.linkedin}}</p>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
    </div>
</template>

<script>
    export default {
        name: "Index" ,
        data(){
            return{
                info:info,
                profile:[],
                data: {},
                search:'',
                dataError:[],
                user_id:'',
                is_follow:false,
                followers:[],
                rating:[],
                is_rated:0,
                valueRating:''
            }
        },
        methods: {
            async getProfile(){
                if (this.$route.params.id == null){
                    this.user_id = info.user_id
                }else{
                    this.user_id = this.$route.params.id;
                }
                await this.$root.PostRequest('/api/profile',{id:this.user_id}).then((response) => {
                     this.profile = response.data.data;
                     this.followers = this.profile.followers;
                });
            },
            checkIsFollow(){
                if(info != null){
                    this.is_follow = this.followers.some( el =>{
                        return el.user_id == info.user_id && el.trainer_id == this.$route.params.id;
                    });
                }
            },
            follow(){
                if (info != null){
                    this.$root.PostRequest('/api/follow/trainer',{user_id:info.user_id,trainer_id:this.$route.params.id, is_follow:this.is_follow}).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        this.is_follow = !this.is_follow;
                    });
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'Please Login'
                    });
                }
            },
            async getRating(){
                await this.$root.PostRequest('/api/rating/getRating',{trainer_id:this.$route.params.id}).then((response) => {
                    this.rating = response.data.data[0];
                    this.is_rated = response.data.data[0];
                });
            },
            async setRating(rating){
                if ( info == null){
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
                    this.getRating();
                });
            }
        },
        async mounted() {
            await this.getProfile();
            await this.checkIsFollow();
            await this.getRating();
        }
    }
</script>

<style scoped>

</style>
