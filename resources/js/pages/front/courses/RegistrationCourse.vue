<template>
    <div>
<!--        <banner name="Subscription"></banner>-->

        <section class="contact-us" style="margin-top: 100px">
            <div class="container">
                <div class="inner-contact-us">
                    <div class="first">
                        <div class="heading">
                            <h2>Subscription</h2>
                        </div>
                        <form class="contact-form">
                            <div>
                                <h4 class="header-title">Course Details</h4>
                                <input type="text" class="your_email" name="course" :placeholder="single_course.title" disabled>
                                <input type="text" class="your_email" name="amount" :placeholder="single_course.price" disabled>
                                <select name="subscription_type" v-model="subscription_type" id="Subscription" class="select-option"  >
                                    <option value="">please Subscription</option>
                                    <option value="free">Free Trail 15 days</option>
                                    <!--                                <option value="monthly">60 SAR</option>-->
                                    <option value="yearly">650 SAR - Yearly</option>
                                </select>
                            </div>
                            <div v-show="subscription_type == 'yearly'">
                                <h4 class="header-title">Payment Details</h4>
                                <input type="text" class="your_email" name="card name" placeholder="Card Name" >

                                <div ref="card" class="credit-card" >

                                </div>
                            </div>

                            <div class="loader credit-card" v-if="isSubmit"></div>
                            <button v-else class="contact-form-btn btn-block" type="submit" @click.prevent="submit">Subscription</button>

                            <successfully-message v-if="subscribe_done"></successfully-message>

                        </form>
                    </div>
                    <!-- <div class="second">
                        <img src="assets/images/contact_map.png">
                    </div> -->
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    // let styles = {
    //     base :{
    //         fontSize: "14px",
    //         color: "#000",
    //         border: "1px solid #707070",
    //         boxShadow: "none",
    //         padding: "17px 30px",
    //         borderRadius: "27px",
    //         width: "100%",
    //         float: "left",
    //         marginBottom: "6px",
    //         outline: "none",
    //         boxSizing: "border-box",
    //     }
    // }
    // let stripe = Stripe(process.env.MIX_STRIPE_PUBLISHABLE_KEY);
    // let element = stripe.elements();
    // let card = undefined;
    // import { StripeElementCard } from '@vue-stripe/vue-stripe';

    export default {
        name: "RegistrationCourse",
        mounted() {
            this.getSingleCourse();
            console.log("register course")
        },
        // components: {
        //     StripeElementCard,
        // },
        data () {
            return {
                isSubmit:false,
                subscription_type:'',
                single_course:[],
                data: {},
                search:'',
                dataError:[],
                subscription:{},
                subscribe_done:false
            };
        },
        methods: {
            // getSingleCourse(){
            //     this.$root.PostRequest('/api/courses/get_single_course',{id:this.$route.params.id}).then((data) => {
            //         this.single_course = data.data.data;
            //         this.data = data.data;
            //     });
            // },
            // submit(){
            //     this.isSubmit = true;
            //     this.validations();
            //     if (card != undefined && this.subscription_type =='yearly'){
            //         stripe.createToken(card).then((result)=>{
            //             if (result.error){
            //                 this.isSubmit = false;
            //                 console.log(result.error);
            //             }else{
            //                 this.saveSubscription();
            //                 this.handleToken(result.token);
            //             }
            //         });
            //     }else if(this.subscription_type =='free'){
            //         this.saveSubscription();
            //     }
            //
            // },
            // handleToken(token){
            //     this.subscription = {course_id:this.single_course.id,amount:this.single_course.price,subscription_type:this.subscription_type,user_id:1 , stripeToken:token.id};
            //     console.log(token)
            //     this.$root.PostRequest('/api/payment-process',{subscription:this.subscription}).then((response) => {
            //             this.isSubmit = false;
            //     });
            // },saveSubscription(){
            //     this.subscription = {course_id:this.single_course.id,amount:this.single_course.price,subscription_type:this.subscription_type,user_id:1};
            //     this.$root.PostRequest('/api/payment_subscriptions',{subscription:this.subscription}).then((response) => {
            //         if (response.status == 200){
            //             this.isSubmit = false;
            //             this.subscribe_done = true;
            //             console.log("subscriptions success")
            //             // window.location.href = "/payment";
            //         }
            //     });
            // },validations(){
            //     if (this.subscription_type == ''){
            //         Toast.fire({
            //             icon: 'warning',
            //             title: 'please select subscription type'
            //         });
            //         this.isSubmit = false;
            //         return false;
            //     }
            //     if( info == null){
            //         Toast.fire({
            //             icon: 'warning',
            //             title: 'please Login'
            //         });
            //         this.isSubmit = false;
            //         return false;
            //     }
            // }
        },
        watch:{
            // subscription_type:function () {
            //     if (this.subscription_type == 'yearly'){
            //         card = element.create("card",{
            //             style:styles,
            //             hidePostalCode:true,
            //         });
            //         card.mount(this.$refs.card);
            //     }else {
            //         // card.d
            //         // card.clear();
            //         if (card != undefined)
            //             card.destroy(this.$refs.card);
            //     }
            // }
        }
    }
</script>
<style scoped>
   .credit-card {
       font-size: 14px;
       color: #000;
       border: 1px solid #707070;
       box-shadow: none;
       padding: 17px 30px;
       border-radius: 27px;
       width: 100%;
       float: left;
       margin-bottom: 6px;
       outline: none;
       box-sizing: border-box;
   }
   .loader {
       margin-left: 200px;
       border: 16px solid #f3f3f3;
       border-radius: 50%;
       border-top: 16px solid #3498db;
       width: 120px;
       height: 120px;
       -webkit-animation: spin 2s linear infinite; /* Safari */
       animation: spin 2s linear infinite;
   }

   /* Safari */
   @-webkit-keyframes spin {
       0% { -webkit-transform: rotate(0deg); }
       100% { -webkit-transform: rotate(360deg); }
   }

   @keyframes spin {
       0% { transform: rotate(0deg); }
       100% { transform: rotate(360deg); }
   }
</style>
