<template>
  <div>
      <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
          <input type="hidden" name="id" :value="this.$route.params.id" v-if="this.$route.params.id">
          <div class="card card-primary">
              <div class="card-body">
                  <div class="form-row">
                      <div class="form-group col-md-12">
                          <label for="name">{{ 'Name' | translate}}<span style="color:red;">*</span></label>
                          <input type="text" name="name" class="form-control"  placeholder="Name" :value="(data.name) ? data.name : ''">
                          <span v-if="dataError.name" class="text-danger">{{ dataError.name[0]}}</span>
                      </div>
                      <div class="form-group col-md-12">
                          <label>{{ 'Description' | translate}}</label>
                          <textarea cols="50" name="Description" class="form-control" placeholder="Description">{{ data.description ? data.description:'' }}</textarea>
                      </div>
                  </div>
              </div>
              <div class="card-footer">
                  <button class="btn btn-primary" v-if="$route.params.id" @click.prevent="update()">{{ 'Update' | translate}}</button>
                  <button class="btn btn-primary" v-else @click.prevent="submitForm()">{{ 'Save' | translate}}</button>
                  <router-link to="/admin/permissions" class="btn btn-light">{{ 'Cancel' | translate}}</router-link>
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
                id: this.$route.params.id,
                dataError:[],
            }
        },
        methods: {
            submitForm:function(ev){
                var formData = new FormData(this.$refs.myForm);
                this.$root.PostRequest('/api/admin/permissions/add',formData,
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
                    this.$router.push({path: '/admin/permissions'});
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
            getPermissionByID(){
                if (this.id != null || this.id != undefined) {
                    this.$root.PostRequest('/api/admin/permissions/edit', {id: this.id}).then((data) => {
                        // this.employees = data.body;
                        // this.load_data = false;
                        this.data = data.body.data;
                        console.log(this.data)
                    });
                }
            },
            update(){
                var formData = new FormData(this.$refs.myForm);
                this.$root.PostRequest('/api/admin/permissions/update',formData,
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
                        this.$router.push({path: '/admin/permissions'});
                        this.$refs.myForm[0].reset;
                    }
                });
            }
        },
        mounted() {
            this.getPermissionByID();
            // this.getRoles();
        }
    }
</script>

<style scoped>

</style>
