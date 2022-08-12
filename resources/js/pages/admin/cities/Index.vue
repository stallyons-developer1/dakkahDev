<template>
    <div>
        <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <search-bar url="/admin/cities/add" name="Add Cities"></search-bar>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-striped mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ 'Cities English' | translate}}</th>
                                    <th scope="col">{{ 'Cities Arabic' | translate}}</th>
                                    <th scope="col">{{ 'Action' | translate}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="city in cities">
                                    <td>{{city.city_id}}</td>
                                    <td>{{ city.name_en }}</td>
                                    <td>{{ city.name_ar }}</td>
                                    <td>
                                        <span style="cursor: pointer;" @click.prevent="deleteRole(city.city_id)" class="btn btn-danger" ><i class="fa fa-trash text-light" title="Delete"></i></span>
                                        <router-link :to="'/admin/cities/edit/' + city.city_id" style="cursor: pointer;" class="btn btn-secondary" ><i class="fa fa-edit text-light" title="Edit"></i></router-link>

                                    </td>
                                </tr>
                                <no-data v-if="cities.length == 0"></no-data>
                                </tbody>
                            </table>
                            <pagination :data="data" @pagination-change-page="getCities"></pagination>

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
                city_id: '',
                data:{},
                search:'',
                cities: [],
            }
        },
        methods: {
            deleteRole(city_id){
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
                                this.$root.PostRequest('/api/admin/cities/delete',{city_id:city_id}).then((data) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.body.message
                                    });
                                    this.getCities();
                                    this.$Progress.finish();

                                });
                            }
                        }
                    }
                );
            },
            getCities(page = 1){
                this.load_data = true;
                this.is_data = false;
                this.$root.PostRequest('/api/admin/cities/list?page=' + page , {search:this.search}).then(response=>{return response.json();}).then((data) => {
                    this.cities = data.data.data;
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
            this.getCities();
            this.$root.$on('SEARCH-WORD' , (data)=>{
                this.search = data;
                this.getCities();
            });
        },
    }
</script>

<style scoped>

</style>
