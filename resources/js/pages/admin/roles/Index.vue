<template>
    <div>
        <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <search-bar url="/admin/roles/add" name="Add Role"></search-bar>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-striped mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ 'Name' | translate}}</th>
                                    <th scope="col">{{ 'Description' | translate}}</th>
                                    <th scope="col">{{ 'Permissions' | translate}}</th>
                                    <th scope="col">{{ 'Action' | translate}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="role in roles">
                                    <td>{{role.id}}</td>
                                    <td>{{ role.name }}</td>
                                    <td>{{ role.description}}</td>
                                    <td ><span v-if="role.permission" v-for="permission in role.permission" class="badge badge-primary">{{ permission.name }}</span></td>
                                    <td>
                                        <span style="cursor: pointer;" @click.prevent="deleteRole(role.id)" class="btn btn-danger" ><i class="fa fa-trash text-light" title="Delete"></i></span>
                                        <router-link :to="'/admin/roles/edit/' + role.id" style="cursor: pointer;" class="btn btn-secondary" ><i class="fa fa-edit text-light" title="Edit"></i></router-link>

                                    </td>
                                </tr>
                                <no-data v-if="roles.length == 0"></no-data>
                                </tbody>
                            </table>
                            <pagination :data="data" @pagination-change-page="getRoles"></pagination>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        name: "Index" ,
        data() {
            return {
                load_data: false,
                is_data: false,
                id: '',
                data:{},
                search:'',
                roles: [],
            }
        },
        methods: {
            deleteRole(id){
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
                                this.$root.PostRequest('/api/admin/roles/delete',{id:id}).then((data) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.body.message
                                    });
                                    this.getRoles();
                                    this.$Progress.finish();

                                });
                            }
                        }
                    }
                );
            },
            getRoles(page = 1){
                this.load_data = true;
                this.is_data = false;
                this.$root.PostRequest('/api/admin/roles/list?page=' + page , {search:this.search}).then(response=>{return response.json();}).then((data) => {
                    this.roles = data.data.data;
                    this.data = data.data;
                    // this.load_data = false;
                    // if (data.body.length == 0) {
                    //     this.is_data = true;
                    // }
                    // console.log(data);
                });
            },
        },
        mounted() {
            this.getRoles();
            this.$root.$on('SEARCH-WORD' , (data)=>{
                this.search = data;
                this.getRoles();
            });
        },
    }
</script>

<style scoped>

</style>
