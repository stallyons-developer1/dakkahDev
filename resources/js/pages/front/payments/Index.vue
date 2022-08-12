<template>
<div>
    <div class="contact-form bg-light pd-y-40">
        <div class="container">

            <h1 class="mg-b-20 tx-lg">الدفع الالكتروني</h1>


            <div class="d-flex align-items-center">
                <div class="form">

                    <form id="form-container" method="post">
                        <!-- Tap element will be here -->
                        <div id="element-container"></div>
                        <div id="error-handler" role="alert"></div>
                        <!--                            <div id="success" style=" display: none;;position: relative;float: left;">-->
                        <!--                                Success! Your token is <span id="token"></span>-->
                        <!--                            </div>-->
                        <!-- Tap pay button -->
                        <loader v-if="loading"></loader>
                        <button  class="btn rounded btn-secondary" @click.prevent="submitCharges">دفع</button>
                    </form>
                </div>
                <div class="form-avatar">
                    <img src="/assets/front/ico/payment-integration.webp" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        name: "Index",
        data() {
            return{
                token: "" ,
                loading:false
            }
        },
        mounted() {
            this.tapjsli();
        },
        methods:{
            tapjsli(){
                let that = this;
                //pass your public key from tap's dashboard
                var tap = Tapjsli('pk_test_fZl13RTsNOLw6V7opUIbKAzS');

                var elements = tap.elements({});

                var style = {
                    base: {
                        color: '#535353',
                        lineHeight: '18px',
                        fontFamily: 'sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: 'rgba(0, 0, 0, 0.26)',
                            fontSize:'15px'
                        }
                    },
                    invalid: {
                        color: 'red'
                    }
                };
                // input labels/placeholders
                var labels = {
                    cardNumber:"Card Number",
                    expirationDate:"MM/YY",
                    cvv:"CVV",
                    cardHolder:"Card Holder Name"
                };
                //payment options
                var paymentOptions = {
                    currencyCode:["KWD","USD","SAR"],
                    labels : labels,
                    TextDirection:'ltr'
                }
                //create element, pass style and payment options
                var card = elements.create('card', {style: style},paymentOptions);
                //mount element
                card.mount('#element-container');
                //card change event listener
                card.addEventListener('change', function(event) {
                    if(event.loaded){
                        console.log("UI loaded :"+event.loaded);
                        console.log("current currency is :"+card.getCurrency())
                    }
                    var displayError = document.getElementById('error-handler');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
                // Handle form submission
                var form = document.getElementById('form-container');
                form.addEventListener('submit', function(event) {
                    this.loading = true
                    event.preventDefault();
                    tap.createToken(card).then((result) => {
                        console.log(result);
                        if (result.error) {
                            // Inform the user if there was an error
                            var errorElement = document.getElementById('error-handler');
                            errorElement.textContent = result.error.message;
                        } else {
                            // Send the token to your server
                            // var errorElement = document.getElementById('success');
                            // errorElement.style.display = "block";
                            // var tokenElement = document.getElementById('token');
                            // tokenElement.textContent = result.id;
                            // this.token = result.id;
                            // tapTokenHandler()
                            // that.charges(result.id)
                            // token = result.id;
                            that.submitCharges(result.id);
                        }
                    });
                });
            },
            submitCharges(token){
                this.loading = true;
                this.$root.PostRequest('/api/payment/charges',{token:token}).then((response) => {
                    if (response.status == 200){
                        this.loading = false
                        window.location.href = response.body.data.transaction.url;
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
 .bttuon {
     font-size: 14px;
     font-weight: bold;
     color: #fff;
     background: #BA0D2F;
     border: 1px solid #BA0D2F;
     box-shadow: none;
     outline: none;
     padding: 15px 44px;
     border-radius: 24px;
     margin: auto;
     display: table;
     transition: all 0.3s ease;
     cursor: pointer;
 }
</style>
