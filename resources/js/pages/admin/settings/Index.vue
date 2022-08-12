<template>
    <div>
        <form  action="#" id="formData" method="post" enctype="multipart/form-data" ref="myForm">
            <input type="hidden" name="id" :value="this.$route.params.id" v-if="this.$route.params.id">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control"  placeholder="Title" v-model="dataForm.title">
<!--                            <span v-if="dataError.name" class="text-danger">{{ dataError.name[0]}}</span>-->
                        </div>
                        <div class="form-group col-md-12">
                            <label>services</label>
                            <input type="text" name="services" class="form-control"  placeholder="services" v-model="dataForm.services">

                        </div>
                        <div class="form-group col-md-12">
                            <label>phone</label>
                            <input type="text" name="resources" class="form-control"  placeholder="phone" v-model="dataForm.phone">
                        </div>
                        <div class="form-group col-md-12">
                            <label>email</label>
                            <input type="email" name="email" class="form-control"  placeholder="email" v-model="dataForm.email">
                        </div>
                        <div class="form-group col-md-12">
                            <label>location</label>
                            <input type="text" name="location" class="form-control"  placeholder="location" v-model="dataForm.location">
                        </div>
                        <div class="form-group col-md-12">
                            <label>copy_righter</label>
                            <input type="text" name="copy_righter" class="form-control"  placeholder="copy_righter" v-model="dataForm.copy_righter">
                        </div>
                        <div class="form-group col-md-12">
                            <label>facebook</label>
                            <input type="text" name="facebook" class="form-control"  placeholder="facebook" v-model="dataForm.facebook">
                        </div>
                        <div class="form-group col-md-12">
                            <label>twitter</label>
                            <input type="text" name="twitter" class="form-control"  placeholder="twitter" v-model="dataForm.twitter">
                        </div>
                        <div class="form-group col-md-12">
                            <label>instagram</label>
                            <input type="text" name="instagram" class="form-control"  placeholder="instagram" v-model="dataForm.instagram">
                        </div>
                        <div class="form-group col-md-12">
                            <label>linkedin</label>
                            <input type="text" name="linkedin" class="form-control"  placeholder="linkedin" v-model="dataForm.linkedin">
                        </div>
                        <div class="form-group col-md-12">
                            <label>resources</label>
                            <textarea cols="50" name="resources" class="form-control" placeholder="resources" v-model="dataForm.resources"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" @click.prevent="update()">update</button>
                    <router-link to="/admin/settings/1" class="btn btn-light">Cancel</router-link>
                </div>
            </div>
        </form>

    </div>
</template>

<script>
    export default {
        name: "Index",
        data(){
            return{
                data: {},
                selected: null,
                id: this.$route.params.id,
                dataError:[],
                dataForm:{
                    title:'',
                    resources:'',
                    services:'',
                    phone:'',
                    email:'',
                    copy_righter:'',
                    location:'',
                    linkedin:'',
                    facebook:'',
                    twitter:'',
                    instagram:'',
                }
            }
        },
        methods: {
            update(){
                this.$root.PostRequest('/api/admin/settings/update', {setting:this.dataForm},
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((data) => {
                    if (data.body.error) {
                        this.dataError = data.body.error;
                    }else{
                        Toast.fire({icon: 'success', title: data.body.message});
                        this.$Progress.finish();
                        // this.$router.push({path: '/admin/setting/1'});
                        // this.$refs.myForm[0].reset;
                    }
                });
            },
            async getSetting(){
                if (this.id != null || this.id != undefined) {
                    await this.$root.PostRequest('/api/admin/settings/edit', {id: this.id}).then((response) => {
                        this.dataForm = response.body.data;
                    });
                }
            },
        },
        mounted() {
            this.getSetting();
        }
    }
</script>

<style scoped>

</style>
