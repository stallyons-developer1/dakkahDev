<template>
    <div>
        <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
            <input type="hidden" name="id" :value="this.$route.params.id" v-if="this.$route.params.id">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{ 'Name' | translate}} <span style="color:red;">*</span></label>
                            <input type="text" name="name" class="form-control"  placeholder="Name" :value="(data.name) ? data.name : ''">
                            <span v-if="dataError.name" class="text-danger">{{ dataError.name[0]}}</span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>{{ 'Permissions' | translate}} <span style="color:red;">*</span></label>
                                <multiselect
                                    :multiple="true"
                                    :close-on-select="true"
                                    placeholder="Pick some"
                                    label="name"
                                    track-by="name"
                                    v-model="selected"
                                    :options="permissions">
                                </multiselect>
                            <span v-if="dataError.permission_id" class="text-danger">{{ dataError.permission_id[0]}}</span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>{{ 'Description' | translate}}</label>
                            <textarea cols="50" name="Description" class="form-control" placeholder="Description">{{ data.description ? data.description:'' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" v-if="$route.params.id" @click.prevent="update()">update{{ 'Update' | translate}}</button>
                    <button class="btn btn-primary" v-else @click.prevent="submitForm()">{{ 'Save' | translate}}</button>
                    <router-link to="/admin/roles" class="btn btn-light">{{ 'Cancel' | translate}}</router-link>
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
                permissions:[]
            }
        },
        methods: {
            getPermissionID(){
                return this.selected.map( el => el.id);
            },
            submitForm:function(ev){
                let permission_id = this.selected.map( el => el.id);
                console.log(permission_id)
                var formData = new FormData(this.$refs.myForm);
                formData.append('permission_id',permission_id);
                this.$root.PostRequest('/api/admin/roles/add',formData,
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
                    this.$router.push({path: '/admin/roles'});
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
            async getRoleByID(){
                if (this.id != null || this.id != undefined) {
                    await this.$root.PostRequest('/api/admin/roles/edit', {id: this.id}).then((data) => {
                        // this.employees = data.body;
                        // this.load_data = false;
                        this.data = data.body.data;
                        this.selected = this.data.permission.filter((el)=>el);
                        console.log(this.data)
                    });
                }
            },
            async getPermission(){
                await this.$root.GetRequest('/api/admin/permissions/get_permissions').then((data) => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.permissions = data.body.data;
                    console.log(this.data)
                });
            },
            update(){
                let permission_id = this.selected.map( el => el.id);
                console.log(permission_id)
                var formData = new FormData(this.$refs.myForm);
                formData.append('permission_id',permission_id);
                this.$root.PostRequest('/api/admin/roles/update',formData,
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
                        this.$router.push({path: '/admin/roles'});
                        this.$refs.myForm[0].reset;
                    }
                });
            }
        },
        mounted() {
            this.getPermission();
            this.getRoleByID();
        }
    }
</script>

<style scoped>

</style>
