<template>
    <div>
        <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
            <input type="hidden" name="id" :value="this.$route.params.id" v-if="this.$route.params.id">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Name <span style="color:red;">*</span></label>
                            <input type="text" name="name" class="form-control"  placeholder="Name" v-model="formData.name">
                            <span v-if="dataError.name" class="text-danger">{{ dataError.name[0]}}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>username <span style="color:red;">*</span></label>
                            <input type="text" name="username" class="form-control"  placeholder="username" v-model="formData.username">
                            <span v-if="dataError.username" class="text-danger">{{ dataError.username[0]}}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>first name <span style="color:red;">*</span></label>
                            <input type="text" name="first_name" class="form-control"  placeholder="first_name" v-model="formData.first_name">
                            <span v-if="dataError.first_name" class="text-danger">{{ dataError.first_name[0]}}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>last name <span style="color:red;">*</span></label>
                            <input type="text" name="last_name" class="form-control"  placeholder="last Name" v-model="formData.last_name">
                            <span v-if="dataError.last_name" class="text-danger">{{ dataError.last_name[0]}}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Email <span style="color:red;">*</span></label>
                            <input type="email" name="email" class="form-control"  placeholder="Email" v-model="formData.email">
                            <span v-if="dataError.email" class="text-danger">{{ dataError.email[0]}}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Password <span style="color:red;">*</span></label>
                            <input type="password" name="password" class="form-control"  placeholder="password" v-model="formData.password">
                            <span v-if="dataError.password" class="text-danger">{{ dataError.password[0]}}</span>
                        </div>
                        <div class="form-group col-md-4" v-if="sdm == 1">
                            <label>Roles <span style="color:red;">*</span></label>
                            <multiselect
                                :close-on-select="true"
                                placeholder="Pick some"
                                label="name"
                                track-by="name"
                                v-model="selected"
                                :options="roles">
                            </multiselect>
                            <span v-if="dataError.role_id" class="text-danger">{{ dataError.role_id[0]}}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Phone <span style="color:red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i>+966</span>
                                </div>
                                <input type="number" min="0" max="20" class="form-control" data-inputmask='"mask": "(999) 999-9999"' name="phone" v-model="formData.phone" data-mask>
                            </div>
                            <span v-if="dataError.phone" class="text-danger">{{ dataError.phone[0]}}</span>

                        </div>
                        <div class="form-group col-md-4">
                            <label>Gender <span style="color:red;">*</span></label>
                            <select class="form-control" name="gender" v-model="formData.gender">
                                <option value="">select please</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <span v-if="dataError.gender" class="text-danger">{{ dataError.gender[0]}}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" placeholder="City" v-model="formData.city">
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
                            <label >Background Image</label>
                            <vue-dropzone ref="myVueDropzone" id="dropzone" @vdropzone-error="errorUploading"
                                          @vdropzone-success="fileUploadeds" @vdropzone-removed-file="removeFile" :options="dropzoneeOptions"></vue-dropzone>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label >Description</label>
                            <textarea class="form-control" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label >Twitter</label>
                            <input type="text" class="form-control" name="twitter" placeholder="Twitter" v-model="formData.twitter">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Facebook</label>
                            <input type="text" class="form-control" name="facebook" placeholder="facebook" v-model="formData.facebook">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Youtube</label>
                            <input type="text" class="form-control" name="youtube" placeholder="youtube" v-model="formData.youtube">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Instagram</label>
                            <input type="text" class="form-control" name="snapchat" placeholder="Instagram" v-model="formData.snapchat">
                        </div>
                        <div class="form-group col-md-6">
                            <label >IinkedIn</label>
                            <input type="text" class="form-control" name="linkedin" placeholder="linkedin" v-model="formData.linkedin">
                        </div>
                    </div>
                    <div class="form-row" v-if="sdm == 1">
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
                    <button class="btn btn-primary" v-if="$route.params.id" @click.prevent="update()">{{ 'Update' | translate}}</button>
                    <button class="btn btn-primary" v-else @click.prevent="submitForm()">{{ 'Save' | translate}}</button>
                    <router-link to="/admin/users" class="btn btn-light">{{ 'Cancel' | translate}}</router-link>
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
                image_user:'',
                background_image:'',
                formData:{
                    name:'',
                    username:'',
                    first_name:'',
                    last_name:'',
                    gender:'',
                    email:'',
                    password:'',
                    role_id:'',
                    phone:'',
                    city:'',
                    twitter:'',
                    image:'',
                    background_image:'',
                    facebook:'',
                    youtube:'',
                    snapchat:'',
                    linkedin:'',
                    active:'',
                },
                dropzoneOptions: {
                    url: '/api/admin/users/upload_image',
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    dictDefaultMessage: "<i class='fas fa-upload text-primary'></i>  UPLOAD IMAGE ME ",
                },
                dropzoneeOptions: {
                    url: '/api/admin/users/upload_background_image',
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    dictDefaultMessage: "<i class='fas fa-upload text-primary'></i>  UPLOAD BACKGROUND IMAGE ME ",
                },
                sdm : sdm
            }
        },
        methods: {
            removeFile(file, error, xhr){

            },
            errorUploading (file, message, xhr) {
                console.log(message)
                // do something when a file errors
                // perhaps show a user a message and create a data element to stop form from processing below?
            },
            fileUploaded (file, response) {
                this.image_user = response
                // this.image_user = file.target.files[0];
                console.log(response)
                // do something with a successful file upload. response is the server response
                // perhaps add it to your form data?
            },
            fileUploadeds (file, response) {
                this.background_image = response
                // this.image_user = file.target.files[0];
                console.log(response)
                // do something with a successful file upload. response is the server response
                // perhaps add it to your form data?
            },
            submitForm:function(ev){
                this.formData.role_id = this.selected ? this.selected.id:'';
                this.formData.image = this.image_user ? this.image_user:'';
                this.formData.background_image = this.background_image ? this.background_image:'';
                // var formData = new FormData(this.$refs.myForm);
                // formData.append('image',this.image_user);
                // formData.append('role_id',this.selected.id);
                // console.log(formData)
                // formData.append('permission_id',permission_id);
                this.$root.PostRequest('/api/admin/users/add',this.formData,
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
                    this.$router.push({path: '/admin/users'});
                    this.$refs.myForm[0].reset;

                }).catch((errors)=>{
                    console.log(errors)
                    if (errors.status == 422) {
                        this.inputs = errors.body.inputs;
                        this.dataError = errors.body.error;
                    }else{

                    }
                });
            },
            async getUserByID(){
                if (this.id != null || this.id != undefined) {
                    await this.$root.PostRequest('/api/admin/users/edit', {id: this.id}).then((data) => {
                        // this.employees = data.body;
                        // this.load_data = false;
                        this.formData = data.body.data;
                        delete  this.formData.updated_at;
                        delete  this.formData.created_at;
                        delete  this.formData.deleted_at;
                        delete  this.formData.email_verified_at;
                        this.selected = this.roles.filter(item =>{
                           return (item.id == this.formData.role_id) ? item: '' ;
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
            update(){
                this.formData.role_id = this.selected ? this.selected.id:'';
                this.formData.image = this.image_user ? this.image_user: this.data.image;
                this.formData.background_image = this.background_image ? this.background_image: this.data.image;
                console.log(this.formData)
                this.$root.PostRequest('/api/admin/users/update',this.formData,
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
                        this.$refs.myForm[0].reset;
                        if(this.sdm == 1) this.$router.push({path: '/admin/users'});
                    }
                });
            }
        },
        mounted() {
            this.getRoles();
            this.getUserByID();

        }
    }
</script>

<style scoped>

</style>
