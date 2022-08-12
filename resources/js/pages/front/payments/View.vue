<template>
    <div>
        <div class="contact-form bg-light pd-y-40">
            <div class="container">

                <h1 class="mg-b-20 tx-lg">عرض الدفع الالكتروني</h1>


                <div class="d-flex align-items-center">
                    <successfully-message v-if="showMessage"></successfully-message>
<!--                    <div class="form-avatar">-->
<!--                        <img src="/assets/front/ico/payment-integration.webp" alt="">-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ViewPayment" ,
        data() {
            return{
                token: "" ,
                showMessage:false
            }
        },
        mounted() {
            this.getCharges();
        },
        methods:{
            async getCharges(){
               await this.$root.PostRequest('/api/payment/getCharges', {id:this.$route.query.tap_id}).then((response) => {
                    if (response.status == 200){
                        this.showMessage = true;
                        this.storePayment(response.body.data.post.url , response.body.data);
                    }
                }).catch((error)=>{
                    // this.error = error.body.message
                    console.log(error)
                });

            },
            async storePayment(url , data){
                await this.$root.PostRequest(url, {data:data}).then((response) => {
                    if (response.status == 200){
                        // this.showMessage = true;
                        console.log("save");
                    }
                }).catch((error)=>{
                    // this.error = error.body.message
                    console.log(error)
                });
            }
        }
    }
</script>

<style scoped>

</style>
