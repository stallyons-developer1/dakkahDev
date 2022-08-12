<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <search-bar url="/admin/courses/add" name="Add Course"></search-bar>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ 'Title' | translate}}</th>
                                <th scope="col">{{ 'Start Date' | translate}}</th>
                                <th scope="col">{{ 'End Date' | translate}}</th>
                                <th scope="col">{{ 'Action' | translate}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="course in courses">
                                <td>{{course.id}}</td>
                                <td>{{ course.title }}</td>
                                <td>{{ course.start_date }}</td>
                                <td>{{ course.end_date }}</td>
                                <td>
                                    <span style="cursor: pointer;" @click="deleteCourse(course.id)" class="btn btn-danger"><i class="fa fa-trash text-light" title="Delete"></i></span>
                                    <router-link :to="'/admin/courses/edit/' + course.id" style="cursor: pointer;" class="btn btn-secondary"> <i class="fa fa-edit"></i></router-link>

                                </td>
                            </tr>
                            <no-data v-if="courses.length == 0"></no-data>
                            </tbody>
                        </table>
                        <pagination :data="data" @pagination-change-page="getCourses"></pagination>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data(){
            return{
                courses:[],
                data: {},
                search:'',
                dataError:[],
            }
        },
        methods: {
            deleteCourse(id){
                this.$confirm(
                    {
                        message: `Are you sure want Delete?`,
                        button: {
                            no: 'No',
                            yes: 'Yes'
                        },
                        callback: confirm => {
                            if (confirm) {
                                // ... do something
                                this.$root.PostRequest('/api/admin/courses/delete',{id:id}).then((data) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.body.message
                                    });
                                    this.getCourses();
                                    this.$Progress.finish();

                                });
                            }
                        }
                    }
                );
            },
            getCourses(page = 1){ 
                localStorage.removeItem("role_id");
                this.$root.PostRequest('/api/admin/courses/list?page=' + page , {search:this.search}).then(response => {
                    return response.json();
                }).then((data) => {
                    this.courses = data.data.data;
                    this.data = data.data;
                });
            },
        },
        mounted() {
            this.getCourses();
            this.$root.$on('SEARCH-WORD' , (data)=>{
                this.search = data;
                this.getCourses();
            });
        }
    }
</script>

<style scoped>

</style>
