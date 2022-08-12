<template>
    <div>
        <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
            <input type="hidden" name="city_id" :value="this.$route.params.city_id" v-if="this.$route.params.city_id">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{ 'Cities English' | translate}}<span style="color:red;">*</span></label>
                            <input type="text" name="name_en" class="form-control"  :placeholder="'Cities English' | translate" :value="(data.name_en) ? data.name_en : ''">
                            <span v-if="dataError.name_en" class="text-danger">{{ dataError.name_en[0]}}</span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>{{ 'Cities Arabic' | translate}}</label>
                            <textarea cols="50" name="name_ar" class="form-control" :placeholder="'Cities Arabic' | translate">{{ data.name_ar ? data.name_ar:'' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" v-if="$route.params.city_id" @click.prevent="update()">update</button>
                    <button class="btn btn-primary" v-else @click.prevent="submitForm()">{{ 'Save' | translate}}</button>
                    <router-link to="/admin/cities" class="btn btn-light">{{ 'Cancel' | translate}}</router-link>
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
                cities:[],
                data: [],
                options: ['vue', 'script', 'com'],
                city_id: this.$route.params.city_id,
                dataError:[]
            }
        },
        methods: {
            submitForm:function(ev){
                var formData = new FormData(this.$refs.myForm);
                //formData.append('permission_id',permission_id);
                this.$root.PostRequest('/api/admin/cities/add',formData,
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
                    this.$router.push({path: '/admin/cities'});
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
            async getCitiesByID(){
                console.log(this.city_id);
                if (this.city_id != null || this.city_id != undefined) {
                    await this.$root.PostRequest('/api/admin/cities/edit', {city_id: this.city_id}).then((data) => {
                        // this.employees = data.body;
                        // this.load_data = false;

                        this.data = data.body.data;
                    });
                }
            },
            update(){
                var formData = new FormData(this.$refs.myForm);
                this.$root.PostRequest('/api/admin/cities/update',formData,
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
                        this.$router.push({path: '/admin/cities'});
                        this.$refs.myForm[0].reset;
                    }
                });
            }
        },
        mounted() {
            this.getCitiesByID();
        }
    }
</script>

<style scoped>

</style>
