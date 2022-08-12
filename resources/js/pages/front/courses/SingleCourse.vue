<template>

    <div>
        <course-header :courseDetails="single_course"></course-header>
        <div class="container">
            <section class="pd-y-40">
                <div class="about-section pd-40 bg-light rounded mg-b-40">
                    <h3 class="mg-b-10 tx-primary"> نظرة عامة</h3>
                    <p class="tx-shade tx-primary">{{ single_course.description}}</p>
                </div>
                <div class="bg-secondary rounded mg-b-40 pd-30 d-flex align-items-center justify-content-between">
                    <h3 class="tx-light tx-lg pd-y-10">كن شريكا فى البناء والازدهار والتطوير</h3>


                    <a href="#" class="btn btn-rounded btn-light tx-secondary"> ابدأ التدريب الآن </a>

                </div>
                <div class="about-section pd-40 bg-light rounded mg-b-40">
                    <h3 class="mg-b-10 tx-primary"> تفاصيل الدورة</h3>
                    <p class="tx-shade tx-primary">من الصعب نجاح أي عمل دون وجود خطة محددة ومدروسة له، لذا كان من الضروري الاهتمام بتخطيط المشروعات؛ وذلك
                        لدورها الفاعل في تحقيق الأهداف المرجوة من المشروع. ونظرًا إلى أن المنظمات محدودة الموارد، من هنا تأتي أهمية
                        عملية التخطيط لأنها تُساعد المنظمات على اتخاذ قرارات صائبة نحو تعيين الموارد للوصول إلى الأهداف. ويهدف هذا
                        البرنامج التدريبي إلى التعرف على أساسيات ومفاهيم برمجة المشاريع الهندسية إضافةً إلى تطبيقها عمليًا على
                        برنام

                        <br><br>
                        وذلك
                        لدورها الفاعل في تحقيق الأهداف المرجوة من المشروع. ونظرًا إلى أن المنظمات محدودة الموارد، من هنا تأتي أهمية
                        عملية التخطيط لأنها تُساعد المنظمات على اتخاذ قرارات صائبة نحو تعيين الموارد للوصول إلى الأهداف. ويهدف هذا
                        البرنامج التدريبي إلى التعرف على أساسيات ومفاهيم برمجة المشاريع الهندسية

                        <br><br>

                        وذلك
                        لدورها الفاعل في تحقيق الأهداف المرجوة من المشروع. ونظرًا إلى أن المنظمات محدودة الموارد، من هنا تأتي أهمية
                        عملية التخطيط لأنها تُساعد المنظمات على اتخاذ قرارات صائبة نحو تعيين الموارد للوصول إلى الأهداف. ويهدف هذا
                        البرنامج التدريبي إلى التعرف على أساسيات ومفاهيم برمجة المشاريع الهندسية


                    </p>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SingleCourse" ,
        data(){
            return{
                info:info,
                single_course:[],
                data: {},
                search:'',
                dataError:[],
                is_favorite:false,
                favorites:[],
            }
        },
        methods: {
            async getSingleCourse(page = 1){
                await this.$root.PostRequest('/api/courses/get_single_course',{id:this.$route.params.id}).then(response => {
                    return response.json();
                }).then((data) => {
                    this.single_course = data.data;
                    this.data = data.data;
                    this.favorites = this.single_course.favorites;
                });
                await this.$root.PostRequest('/api/courses/get_single_course',{id:this.$route.params.id}).then(response => {
                    return response.json();
                }).then((data2) => {
                    this.single_course = data2.data;
                    this.data = data2.data;
                });
            },
        },
        async mounted() {
            await this.getSingleCourse();
        }
    }
</script>

<style scoped>

</style>
