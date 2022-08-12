<template>
    <div>
        <div class="contact-form bg-light pd-y-40">
           <div class="container">

               <h1 class="mg-b-20 tx-lg">نسيت كلمة المرور</h1>

                <div class="fail-msg" v-if="errors.length > 0" v-for="error in errors">
                   {{error}}
                </div>
               
               <div class="d-flex align-items-center">
                   <div class="form">

                        <div class="form-group mg-b-20">
                            <label class="mg-b-10 tx-sm d-flex"> أدخل عنوان بريدك الالكتروني</label>
                            <div class="form-group form-field" >
                               <i class="form-ico ri-mail-line"></i>
                               <input placeholder=" " type="email" value="" v-model="email" class="rounded form-control"  :class="[ errors.length > 0 ? 'form-invalid' : '' ]"/>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button  class="btn rounded btn-secondary" @click.prevent="getResetLink">إرسال رابط إعادة التعيين</button>
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
            }
        },
        methods:{
            getResetLink() {

                this.$root.PostRequest('/api/auth/forget-password-link',{email : this.email}).then((response) => {
                    if(response.status == 200) {
                        this.errors = [];
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                        this.email = '';
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
        }
    }
</script>