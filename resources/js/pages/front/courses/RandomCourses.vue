<template>
    <section class="blog">
        <div class="container">
            <div class="inner-blog">
                <div class="col-blog" v-for="course in courses">
                    <div class="img-box">
                        <div class="img-box-image">
                            <img :src="'/images/courses/' + course.image">
                        </div>
                        <div class="img-box-text">
                            <h2>{{ course.title}} </h2>
                            <p>{{ course.description}} .</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "RandomCourses" ,
        data(){
            return{
                courses:[],
                data: {},
                searchEmit:'',
                dataError:[],
            }
        },
        methods: {
            getCourses(){
                this.$root.PostRequest('/api/courses/get_random_courses' ,{random:true}).then((response) => {
                    this.courses = response.data.data;
                    // this.data = data.data;
                });
            },
            search(){
                this.$root.PostRequest('/api/courses/search' , {search:this.searchEmit , city:this.selected}).then((response) => {
                    this.courses = response.data.data;
                    this.data = response.data;
                });
            },
        },
        mounted() {
            this.getCourses();
            this.$root.$on('run-search',(data) =>{
                console.log("emit on run")
                this.searchEmit = data
                this.search();
            })
        }
    }
</script>

<style scoped>

</style>
