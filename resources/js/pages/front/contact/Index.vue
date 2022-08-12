<template>
 <section >
    <div class="contact-form bg-light pd-y-40">
      <div class="container">
        <h1 class="mg-b-20 tx-lg">تواصل معنا</h1>
        <div class="d-flex align-items-center">
          <div class="form" method="post" @submit.prevent="">
            <div class="form-group mg-b-20">
              <label class="mg-b-10 tx-sm d-flex"> الاسم</label>
              <div class="form-group form-field">
                <i class="form-ico ri-user-line"></i>
                <input placeholder="" type="text" value="" class="rounded form-control" v-model="dataForm.name"/>
              </div>
            </div>
            <div class="form-group mg-b-20">
              <label class="mg-b-10 tx-sm d-flex"> البريد الالكتروني</label>
              <div class="form-group form-field">
                <i class="form-ico ri-mail-line"></i>
                <input placeholder=" " type="text" class="rounded form-control" v-model="dataForm.email">
                <span class="your_email text-danger" v-if="errors.email">{{errors.email[0]}}</span>
              </div>
            </div>
            <div class="form-group mg-b-20">
              <label class="mg-b-10 tx-sm d-flex"> موضوع الرسالة</label>
              <div class="form-group form-field">
                <i class="form-ico ri-mail-send-line"></i>
                <input placeholder=" " type="text" class="rounded form-control" v-model="dataForm.title">
                <span class="subject text-danger" v-if="errors.title">{{errors.title[0]}}</span>
              </div>
            </div>
            <div class="form-group mg-b-20">
              <label class="mg-b-10 tx-sm d-flex"> الرسالة</label>
              <div class="form-group form-field">
                <i class="form-ico ri-file-text-line"></i>
                <textarea rows="5" placeholder=" " type="text" class="rounded form-control" v-model="dataForm.message"></textarea>
                <span class="subject text-danger" v-if="errors.message">{{errors.message[0]}}</span>
              </div>
            </div>
            <button  type="submit" class="btn rounded btn-secondary" @click="store">ارسل الرسالة</button>
            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <vue-recaptcha
                                        class="messages"
                                        ref="recaptcha"
                                        @verify="onVerify"
                                        v-model="dataForm.recaptcha"
                                        sitekey="6LfcMZ0bAAAAAKrVJSUcuAaZ_2BeFEZiqvCzMqfB">
                                    </vue-recaptcha>
                                    <span class="subject text-danger" v-if="errors.recaptcha">{{errors.recaptcha[0]}}</span>
                                </div>
            </div>
          </div>
          <div class="form-avatar">
            <img src="/assets/front/ico/c1.svg" alt="">
          </div>
        </div>




      </div>
    </div>

  </section>
</template>
<script>
    import VueRecaptcha from 'vue-recaptcha';
    export default {
        name: "Index",
        components: { VueRecaptcha },
        data(){
            return {
                errors: [],
                isSubmitting: false,
                myForm: null,
                dataForm:{
                    name:'',
                    email:'',
                    title:'',
                    message:'',
                    recaptcha:'',
                }
            }
        },
        methods:{
            onVerify(response) {
                this.dataForm.recaptcha = response;
            },
            store(){
                console.log(this.dataForm)
                this.$root.PostRequest('/api/contacts/store',{dataForm:this.dataForm}).then(response => {
                    if(response.status == 200){
                        this.clearFormInput();
                        Toast.fire({
                            icon: 'success',
                            title: response.body.message
                        });
                    }

                }).catch(error =>{
                    this.errors = error.body.data;
                });
            },
            clearFormInput(){
                this.dataForm = {
                    name:'',
                    email:'',
                    title:'',
                    message:'',
                    recaptcha:'',
                }
            }
        }
    }
</script>

<style scoped>
.text-danger{
    color: red;
}
</style>
