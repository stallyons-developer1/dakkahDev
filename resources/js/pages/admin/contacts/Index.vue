<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Title</th>
                                <th scope="col">Email</th>
                                <th scope="col">Message</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="contact in contacts">
                                <td>{{contact.id}}</td>
                                <td>{{ contact.name }}</td>
                                <td>{{ contact.title }}</td>
                                <td>{{ contact.email }}</td>
                                <td>{{ contact.message }}</td>
                                <td>
                                    <span style="cursor: pointer;" @click="deleteContact(contact.id)" class="btn btn-danger"><i class="fa fa-trash text-light" title="Delete"></i></span>

                                </td>
                            </tr>
                            <no-data v-if="contacts.length == 0"></no-data>
                            </tbody>
                        </table>
                        <pagination :data="data" @pagination-change-page="getContacts"></pagination>

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
                contacts:[],
                data: {},
                search:'',
                dataError:[],
            }
        },
        methods: {
            deleteContact(id){
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
                                this.$root.PostRequest('/api/admin/contacts/delete',{id:id}).then((data) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.body.message
                                    });
                                    this.getCourses();
                                    this.$Progress.finish();

                                });
                            }
                        }
                    }
                );
            },
            getContacts(page = 1){
                this.$root.PostRequest('/api/admin/contacts/list?page=' + page , {search:this.search}).then(response => {
                    return response.json();
                }).then((data) => {
                    this.contacts = data.data.data;
                    this.data = data.data;
                });
            },
        },
        mounted() {
            this.getContacts();
            this.$root.$on('SEARCH-WORD' , (data)=>{
                this.search = data;
                this.getContacts();
            });
        }
    }
</script>

<style scoped>

</style>
