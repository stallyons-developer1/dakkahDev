<template>
    <section>

        <div class="contact-form bg-light pd-y-40">
            <div class="container">

                <h1 class="mg-b-20 tx-lg">قم بإنشاء حساب كمدرب</h1>


                <div v-if="showSuccess" class="success-msg">
                    تم انشاء الحساب بنجاح
                </div>

                <div v-if="showError" class="fail-msg">
                    لم يتم الانشاء بنجاح
                </div>
                <div class="fail-msg" v-if="dataError.length > 0" v-for="error in dataError">
                   {{error}}
                </div>


                <div class="d-flex align-items-center">
                    <div class="form">
                        <!-- <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> نوع العضوية</label>
                            <div class="form-group form-field">
                                <i class="form-ico select-ico ri-arrow-down-s-line"></i>
                                <select name=""  class="rounded form-control" v-model="formData.role_id">
                                    <option value="">إختر </option>
                                    <option value="2">Trainer</option>
                                    <option value="3">Trainee</option>
                                </select>
                            </div>
                        </div> -->
                       

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> الاسم الكامل</label>
                            <div class="form-group form-field">
                                <i class="form-ico ri-user-line"></i>
                                <input placeholder="" type="text" value="" class="rounded form-control"  v-model="formData.first_name"   />
                            </div>
                        </div>
                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> الجنس</label>
                            <div class="form-group form-field">
                                <i class="form-ico select-ico ri-arrow-down-s-line"></i>
                                <select name=""  class="rounded form-control" v-model="formData.gender">
                                    <option value="">إختر </option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> البريد الالكتروني</label>
                            <div class="form-group form-field">
                                <i class="form-ico ri-mail-line"></i>
                                <input placeholder=" " type="email" value="" class="rounded form-control" v-model="formData.email" />
                            </div>
                        </div>
                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> كلمة المرور</label>
                            <div class="form-group form-field">
                                <i class="form-ico ri-lock-2-line"></i>
                                <input placeholder=" " type="password" value="" class="rounded form-control" v-model="formData.password"/>
                            </div>
                        </div>

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> رقم الهاتف</label>
                            <div class="form-group form-field">
                                <i class="form-ico ri-phone-line"></i>
                                <input placeholder=" " type="number" value="" class="rounded form-control" v-model="formData.phone" />
                            </div>
                        </div>

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> نيذة عنك</label>
                            <div class="form-group form-field">
                                <i class="form-ico ri-file-text-line"></i>
                                <textarea rows="5" placeholder=" " type="text" value="" v-model="formData.about_you" class="rounded form-control" />
                            </div>
                        </div>

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> المدينة</label>
                            <div class="form-group form-field">
                                <i class="form-ico select-ico ri-arrow-down-s-line"></i>
                                <select name=""  class="rounded form-control"v-model="selected" >
                                    <option value="">إختر </option>
                                    <option :value="city.name_ar" v-for="city in cities">{{city.name_ar}}</option>
                                </select>
                            </div>
                        </div>




                        <button @click="register"  class="btn rounded btn-secondary">سجل كمدرب</button>

                    </div>
                    <div class="form-avatar">
                        <img src="/assets/front/ico/c2.svg" alt="">
                    </div>
                </div>




            </div>
        </div>

    </section>
</template>

<script>
    export default {
        name: "Register",
        data(){
            return{
                showError : false,
                showSuccess : false,
                users:[],
                cities:[],
                data: {},
                selected: null,
                options: ['vue', 'script', 'com'],
                id: this.$route.params.id,
                dataError:[],
                permissions:[],
                image_user:'',
                formData:{
                    first_name:'',
                    last_name:'',
                    gender:'',
                    email:'',
                    password:'',
                    about_you:'',
                    phone:'',
                    city:'',
                    role_id:'2',

                },
            }
        },
        methods: {
            register(){
                this.$root.PostRequest('/api/auth/register' , {data:this.formData}).then((response) => {
                    if (response.status == 200){
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        setTimeout(()=>{
                            window.location.href ='/auth/login'
                        },2000)
                        this.$refs.myForm[0].reset;

                    }
                }).catch((error)=>{
                    this.dataError = error.body.message
                    // console.log(error)
                    let errors = Object.values(error.body.message);
                    errors = errors.flat();
                    this.dataError = errors;
                });
            },
            async getCities(){
                await this.$root.GetRequest('/api/admin/cities/list').then( async data => {
                    // this.employees = data.body;
                    // this.load_data = false;
                    this.cities = await data.body.data;
                    // console.log(this.data)
                });
            },
            onError(){
                this.showError = true
            },
            onSuccess(){
                this.showSuccess = true
            }
        },
        mounted() {
            this.getCities()
        }
    }
</script>

<style scoped>

</style>
