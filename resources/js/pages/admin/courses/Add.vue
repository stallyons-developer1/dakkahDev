<template>
    <div>
        <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
            <input type="hidden" name="id" :value="this.$route.params.id" v-if="this.$route.params.id">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>title <span style="color:red;">*</span></label>
                            <input type="text" name="title" class="form-control"  placeholder="title" v-model="formData.title">
                            <span v-if="dataError.title" class="text-danger">{{ dataError.title[0]}}</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category <span style="color:red;">*</span></label>
                            <multiselect
                                :multiple="true"
                                :close-on-select="true"
                                placeholder="Pick some"
                                label="category_en"
                                track-by="category_id"
                                v-model="selected"
                                :options="categories">
                            </multiselect>
                                <!-- <multiselect
                                    :multiple="true"
                                    :close-on-select="true"
                                    placeholder="Pick some"
                                    label="category_en"
                                    track-by="id"
                                    v-model="selected"
                                    :options="categories">
                                </multiselect> -->
                            <!-- <span v-if="dataError.category" class="text-danger">{{ dataError.category[0]}}</span> -->
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label>Category <span style="color:red;">*</span></label>
                            <input-tag v-model="formData.category"></input-tag>
                            <span v-if="dataError.category" class="text-danger">{{ dataError.category[0]}}</span>
                        </div> -->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Start Date <span style="color:red;">*</span></label>
                            <vuejs-datepicker valueType="format" v-model="formData.start_date"></vuejs-datepicker>
                            <span v-if="dataError.start_date" class="text-danger">{{ dataError.start_date[0]}}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>End Date <span style="color:red;">*</span></label>
                            <vuejs-datepicker valueType="format" v-model="formData.end_date"></vuejs-datepicker>
                            <span v-if="dataError.end_date" class="text-danger">{{ dataError.end_date[0]}}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Start Time <span style="color:red;">*</span></label>
                            <vuejs-datepicker valueType="format" type="time" v-model="formData.start_time"></vuejs-datepicker>
                            <span v-if="dataError.start_time" class="text-danger">{{ dataError.start_time[0]}}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>End Time <span style="color:red;">*</span></label>
                            <vuejs-datepicker valueType="format" type="time" v-model="formData.end_time"></vuejs-datepicker>
                            <span v-if="dataError.end_time" class="text-danger">{{ dataError.end_time[0] }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Location</label>
                            <input type="text" class="form-control float-left" name="location" placeholder="location" v-model="formData.location">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Attendance Type</label>
                            <select class="form-control" name="gender" v-model="formData.gender">
                                <option value="">select please</option>
                                <option value="male" :selected="data.gender == 'male' ? 'selected': '' ">Male</option>
                                <option value="female" :selected="data.gender == 'female' ? 'selected': '' ">Female</option>
                            </select>
                            <span v-if="dataError.gender" class="text-danger">{{ dataError.gender[0]}}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label>City</label>
                            <multiselect
                                :close-on-select="true"
                                placeholder="Pick some"
                                label="name_en"
                                track-by="city_id"
                                v-model="selected"
                                :options="cities">
                            </multiselect>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label >language</label>
                            <select class="form-control" name="gender" v-model="formData.language">
                                <option value="">select please</option>
                                <option value="arabic" :selected="data.language == 'arabic' ? 'selected': '' ">arabic</option>
                                <option value="english" :selected="data.language == 'english' ? 'selected': '' ">english</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label >seat</label>
                            <input type="number" min="1"  class="form-control" placeholder="seat" name="seat" v-model="formData.seat">
                        </div>
                        <div class="form-group col-md-6">
                            <label > registeration link</label>
                            <input type="text" class="form-control" placeholder="registeration" name="registration_link" v-model="formData.registeration_link" disabled="true">
                        </div>
                        <div class="form-group col-md-6">
                            <label >price</label>
                            <input type="number" min="1" class="form-control" placeholder="price" name="price" v-model="formData.price">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label >Image</label>
                            <vue-dropzone ref="myVueDropzone" id="dropzone" @vdropzone-error="errorUploading"
                                          @vdropzone-success="fileUploaded" @vdropzone-removed-file="removeFile" :options="dropzoneOptions"></vue-dropzone>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label >Description</label>
                            <textarea class="form-control" cols="100" v-model="formData.description"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="active" id="checkboxPrimary1" :checked="(data.active) ? ' checked ': '' " v-model="formData.active">
                                <label for="checkboxPrimary1">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" v-if="$route.params.id" @click.prevent="update()">update</button>
                    <button class="btn btn-primary" v-else @click.prevent="submitForm()">{{ 'Save' | translate}}</button>
                    <router-link to="/admin/courses" class="btn btn-light">{{ 'Cancel' | translate}}</router-link>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Add",
        data(){
            return{
                users:[],
                roles:[],
                data: {},
                selected: null,
                options: ['vue', 'script', 'com'],
                id: this.$route.params.id,
                dataError:[],
                permissions:[],
                cities:[],
                categories:[],
                image_course:'',
                formData:{
                    title:'',
                    end_date:'',
                    start_date:'',
                    start_time:'',
                    end_time:'',
                    gender:'',
                    city:'',
                    registeration_link:'',
                    image:'',
                    seat:'',
                    category:'',
                    price:'',
                    location:'',
                    active:'',
                    description:'',
                },
                value:'',
                dropzoneOptions: {
                    url: '/api/admin/courses/upload_image',
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    dictDefaultMessage: "<i class='fas fa-upload text-primary'></i>  UPLOAD ME ",
                }
            }
        },
        methods: {
            async generateRandomLink(){
                await this.$root.GetRequest('/api/admin/courses/generateRandomLink').then( async data => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.formData.registeration_link = await data.body.data;
                    // console.log(this.data)
                });
            },
            removeFile(file, error, xhr){

            },
            errorUploading (file, message, xhr) {
                console.log(message)
                // do something when a file errors
                // perhaps show a user a message and create a data element to stop form from processing below?
            },
            fileUploaded (file, response) {
                this.image_course = response
                // this.image_user = file.target.files[0];
                console.log(response)
                // do something with a successful file upload. response is the server response
                // perhaps add it to your form data?
            },
            submitForm:function(ev){
                this.formData.city = this.selected ? this.selected.name_en:'';
                this.formData.category = this.selected ? this.selected.category_en:'';
                this.formData.image = this.image_course ? this.image_course:'';
                this.$root.PostRequest('/api/admin/courses/add',this.formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((data) => {
                    Toast.fire({
                        icon: 'success',
                        title: data.body.message
                    });
                    this.$Progress.finish();
                    this.$router.push({path: '/admin/courses'});
                    this.$refs.myForm[0].reset;
                    this.newCourseEmail();
                }).catch((errors)=>{
                    console.log(errors)
                    if (errors.status == 422) {
                        this.inputs = errors.body.inputs;
                        this.dataError = errors.body.error;
                    }else{

                    }
                });
            },
            async getCourseByID(){
                if (this.id != null || this.id != undefined) {
                    await this.$root.PostRequest('/api/admin/courses/edit', {id: this.id}).then((data) => {
                        // this.employees = data.body;
                        // this.load_data = false;
                        this.formData = data.body.data;
                        //this.formData.category = this.formData.category.split(',');
                        //this.formData.category = this.formData.category;
                        //console.log(this.formData.category);
                        delete  this.formData.updated_at;
                        delete  this.formData.created_at;
                        delete  this.formData.deleted_at;
                        this.selected = this.cities.filter(item =>{
                            return (item.name_en == this.formData.city) ? item: '' ;
                        })[0];
                        this.selected = this.categories.filter(item =>{
                            return (item.category_en == this.formData.category) ? item: '' ;
                        })[0];
                        
                    });
                }
            },
            async getRoles(){
                await this.$root.GetRequest('/api/admin/roles/get_roles').then((data) => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.roles = data.body.data;
                    // console.log(this.data)
                });
            },
            async getCities(){
                await this.$root.GetRequest('/api/admin/cities/list').then( async data => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.cities = await data.body.data;
                    //console.log(this.cities);
                });
            },
            async getCategories(){
                await this.$root.GetRequest('/api/admin/categories/list').then( async data => {
                    //this.categories = await data.body.data;
                     this.categories = await data.body.data;
                    //console.log(this.categories);
                });
            },
            update(){
                this.formData.city = this.selected ? this.selected.name_en:'';
                this.formData.category = this.selected ? this.selected.category_en:'';
                this.formData.image = this.image_course ? this.image_course: this.data.image;
                this.$root.PostRequest('/api/admin/courses/update',this.formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((data) => {
                    if (data.body.error) {
                        this.inputs = data.body.inputs;
                        this.dataError = data.body.error;
                    }else{
                        Toast.fire({icon: 'success', title: data.body.message});
                        this.$Progress.finish();
                        this.$router.push({path: '/admin/courses'});
                        this.$refs.myForm[0].reset;
                    }
                });
            },
            newCourseEmail(){
                this.$root.PostRequest('/api/admin/newCourseEmail').then((data) => {

                });
            }
        },
        mounted() {
            this.generateRandomLink();
            this.getCities();
            this.getCategories();
            this.getRoles();
            this.getCourseByID();
        }
    }
</script>

<style scoped>

</style>
