<template>
    <div>
        <div class="contact-form bg-light pd-y-40">
           <div class="container">

               <h1 class="mg-b-20 tx-lg">إعادة تعيين كلمة المرور</h1>

                <div class="fail-msg" v-if="errors.length > 0" v-for="error in errors">
                   {{error}}
                </div>
               
               <div class="d-flex align-items-center">
                   <div class="form">

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> أدخل عنوان بريدك الالكتروني</label>
                            <div class="form-group form-field" >
                               <i class="form-ico ri-mail-line"></i>
                               <input placeholder=" " type="email" v-model="email" class="rounded form-control"  readonly/>
                            </div>
                        </div>

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> كلمة المرور</label>
                            <div class="form-group form-field" >
                               <i class="form-ico ri-lock-2-line"></i>
                               <input type="password" value="" v-model="password" class="rounded form-control" />
                            </div>
                        </div>

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> تأكيد كلمة المرور</label>
                            <div class="form-group form-field" >
                               <i class="form-ico ri-lock-2-line"></i>
                               <input type="password" value="" v-model="password_confirmation" class="rounded form-control" />
                            </div>
                        </div>

                        <input type="hidden" name="token" v-model="token">

                        <div class="d-flex justify-content-between align-items-center">
                            <button  class="btn rounded btn-secondary" @click.prevent="resetPassword">إعادة تعيين</button>
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
        data(){
            return{
                errors:[],
                email : '',
                password : '',
                password_confirmation : '',
                token : ''
            }
        },
        methods:{
            resetPassword() {

                this.$root.PostRequest('/api/auth/reset-password',{
                    token : this.token,
                    email : this.email,
                    password : this.password,
                    password_confirmation : this.password_confirmation,
                }).then((response) => {
                    if(response.status == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        this.$router.push({ name : 'Login'})
                    }
                }).catch((errors) => {

                    this.errors = [];

                    let error = errors.body.message;

                    for (var key in error) {
                        if (error.hasOwnProperty(key)) {
                            this.errors.push(error[key][0]);
                        }
                    }
                });
            }
        },
        mounted(){
            this.token = this.$route.params.token;
            this.email = this.$route.query.email;
        }
    }
</script>