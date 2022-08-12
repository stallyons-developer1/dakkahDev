<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <search-bar url="/admin/users/add" name="Add User"></search-bar>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ 'username' | translate}}</th>
                                <th scope="col">{{ 'email' | translate}}</th>
                                <th scope="col">{{ 'Roles' | translate}}</th>
                                <th scope="col">{{ 'Action' | translate}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users">
                                <td>{{user.id}}</td>
                                <td>{{ user.username }}</td>
                                <td>{{ user.email}}</td>
                                <td>{{ user.roles.name}}</td>
                                <td>
                                    <span style="cursor: pointer;" class="btn btn-danger" @click="deleteUser(user.id)" v-if="user.id != 1 && user.is_super_admin != 1 "><i class="fa fa-trash text-light" title="Delete"></i></span>
                                    <router-link :to="'/admin/users/edit/' + user.id" style="cursor: pointer;" class="btn btn-secondary" ><i class="fa fa-edit text-light"></i></router-link>

                                </td>
                            </tr>
                            <no-data v-if="users.length == 0"></no-data>
                            </tbody>
                        </table>
                        <pagination :data="data" @pagination-change-page="getUsers"></pagination>

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
        data(){
            return{
                users:[],
                data: {},
                search: '',
                dataError:[],
            }
        },
        methods: {
            deleteUser(id){
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
                                this.$root.PostRequest('/api/admin/users/delete',{id:id}).then((data) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.body.message
                                    });
                                    this.getUsers();
                                    this.$Progress.finish();

                                });
                            }
                        }
                    }
                );
            },
            getUsers(page = 1){
                this.$root.PostRequest('/api/admin/users/list?page=' + page , {search:this.search}).then(response => {
                    return response.json();
                }).then((data) => {
                    this.users = data.data.data;
                    this.data = data.data;
                });
            },
        },
        mounted() {
            this.getUsers();
            this.$root.$on('SEARCH-WORD' , (data)=>{
                this.search = data;
                this.getUsers();
            });
        }
    }
</script>

<style scoped>

</style>
