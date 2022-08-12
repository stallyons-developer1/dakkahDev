<template>
    <div>
        <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
            <input type="hidden" name="category_id" :value="this.$route.params.category_id" v-if="this.$route.params.category_id">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{ 'category_en' | translate}} <span style="color:red;">*</span></label>
                            <input type="text" name="category_en" class="form-control"  placeholder="Category en" :value="(data.category_en) ? data.category_en : ''">
                            <span v-if="dataError.category_en" class="text-danger">{{ dataError.category_en[0]}}</span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>{{ 'category_ar' | translate}}</label>
                            <textarea cols="50" name="category_ar" class="form-control" placeholder="Category ar">{{ data.category_ar ? data.category_ar:'' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" v-if="$route.params.category_id" @click.prevent="update()">Update</button>
                    <button class="btn btn-primary" v-else @click.prevent="submitForm()">{{ 'Save' | translate}}</button>
                    <router-link to="/admin/categories" class="btn btn-light">{{ 'Cancel' | translate}}</router-link>
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
                categories:[],
                data: [],
                options: ['vue', 'script', 'com'],
                category_id: this.$route.params.category_id,
                dataError:[]
            }
        },
        methods: {
            submitForm:function(ev){
                var formData = new FormData(this.$refs.myForm);
                //formData.append('permission_id',permission_id);
                this.$root.PostRequest('/api/admin/categories/add',formData,
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
                    this.$router.push({path: '/admin/categories'});
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
            async getCategoryByID(){
                if (this.category_id != null || this.category_id != undefined) {
                    await this.$root.PostRequest('/api/admin/categories/edit', {category_id: this.category_id}).then((data) => {
                        // this.employees = data.body;
                        // this.load_data = false;
                        this.data = data.body.data;
                        console.log("test");
                    });
                }
            },
            update(){
                var formData = new FormData(this.$refs.myForm);
                this.$root.PostRequest('/api/admin/categories/update',formData,
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
                        this.$router.push({path: '/admin/categories'});
                        this.$refs.myForm[0].reset;
                    }
                });
            }
        },
        mounted() {
            this.getCategoryByID();
        }
    }
</script>

<style scoped>

</style>
