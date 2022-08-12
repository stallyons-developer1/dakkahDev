<template>
    <section class="newsletters bg-light">
        <div class="container">
            <div class="pd-y-60 tx-center">

                <img class="mg-b-10" width="70" src="assets/front/ico/newsletter.svg" alt="">
                <h3 class="mg-b-10 tx-xl">أحدث الدورات التدريبية</h3>
                <p class="mg-b-20 tx-shade">إنضم لتصلك احدث الدورات التدريبية على بريدك الالكترونى</p>
                <form method="post" action="#">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="form-group mg-x-10">
                            <i class="form-ico ri-mail-line"></i>
                            <input placeholder="أدخل بريدك الالكترونى هنا" type="text" value="" class="btn-rounded form-control" >
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-rounded">اشترك</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Newsletter"
    }
</script>

<style scoped>

</style>
