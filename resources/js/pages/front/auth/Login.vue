<template>
   <div>
       <div class="contact-form bg-light pd-y-40">
           <div class="container">

               <h1 class="mg-b-20 tx-lg">تسجيل الدخول</h1>

               <div class="fail-msg" v-if="errors.length > 0" v-for="error in errors">
                   {{error}}
               </div>
               <div class="d-flex align-items-center">
                   <div class="form">

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> البريد الالكتروني</label>
                            <div class="form-group form-field">
                               <i class="form-ico ri-mail-line"></i>
                               <input placeholder=" " type="text" value="" v-model="loginData.email" class="rounded form-control" />
                            </div>
                        </div>
                        <div class="form-group mg-b-20">
                           <label class="mg-b-10 tx-sm d-flex"> كلمة المرور</label>
                           <div class="form-group form-field">
                               <i class="form-ico ri-lock-2-line"></i>
                               <input placeholder=" " type="password" value="" v-model="loginData.password" class="rounded form-control" />
                           </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button  class="btn rounded btn-secondary" @click.prevent="login">تسجيل الدخول</button>
                            <router-link :to="{ name : 'ForgotPassword' }">نسيت كلمة المرور؟</router-link>
                        </div>

                   </div>
                   <div class="form-avatar">
                       <img src="/assets/front/ico/c3.svg" alt="">
                   </div>
               </div>
           </div>
       </div>
   </div>
</template>

<script>
    export default {
        name: "Login",
        data(){
            return{
                errors:[],
                loginData:{
                    email:'',
                    password:'',
                }
            }
        },
        methods:{
            login(){
                this.$root.PostRequest('/api/auth/login',{data:this.loginData}).then((response) => {
                        var abc = response.data.data.role_id;
                        if (abc === 2) {
                            localStorage.setItem("role_id", abc);
                             setTimeout(()=>{
                                 window.location.href = "/admin/courses"
                             },2000)    
                          }else if(abc === 3){
                            localStorage.setItem("role_id", abc);
                            setTimeout(()=>{
                                window.location.href = "/";
                            },2000)
                         }
                    if(response.status === 200){
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        }); 
                    }

                    // this.$refs.myForm[0].reset;
                }).catch((error)=>{
                    let errors = Array.isArray(error.body.message) ? Object.values(error.body.message).flat() : [error.body.message];
                    console.log(errors)
                    this.errors =errors;
                    console.log(error)
                    if (error.status == 402){
                        window.location.href = "/payment";
                    }
                });
            }
        },
        mounted(){
            console.log("mounted")
        }
    }
</script>

<style scoped>
.login{

}
</style>
