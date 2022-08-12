<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <search-bar url="/admin/permissions/add" name="Add Permission"></search-bar>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ 'Name' | translate}}</th>
                                <th scope="col">{{ 'Description' | translate}}</th>
                                <th scope="col">{{ 'Action' | translate}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="permission in permissions">
                                <td>{{permission.id}}</td>
                                <td>{{ permission.name }}</td>
                                <td>{{ permission.description}}</td>
                                <td>
                                    <span style="cursor: pointer;" @click.prevent="deletePermission(permission.id)" class="btn btn-danger"><i class="fa fa-trash text-light" title="Delete"></i></span>
                                    <router-link :to="'/admin/permissions/edit/' + permission.id" style="cursor: pointer;" class="btn btn-secondary"><i class="fa fa-edit text-light" title="Edit"></i></router-link>

                                </td>
                                <no-data v-if="permission.length==0"></no-data>
                            </tr>
                            </tbody>
                        </table>
                        <pagination :data="data" @pagination-change-page="getPermissions"></pagination>

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
        data() {
            return {
                load_data: false,
                is_data: false,
                id: '',
                data:{},
                permissions: [],
                search:''
            }
        },
        methods: {
            deletePermission(id){
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
                                this.$root.PostRequest('/api/admin/permissions/delete',{id:id}).then((data) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.body.message
                                    });
                                    this.getPermissions();
                                    this.$Progress.finish();

                                });
                            }
                        }
                    }
                );
            },
            getPermissions(page = 1){
                this.load_data = true;
                this.is_data = false;
                this.$root.PostRequest('/api/admin/permissions/list?page=' + page,{search:this.search}).then(response=>{return response.json();}).then((data) => {
                    this.permissions = data.data.data;
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
            this.getPermissions();
            this.$root.$on('SEARCH-WORD' , (data)=>{
                this.search = data;
                this.getPermissions();
            });
        },
    }
</script>

<style scoped>

</style>
