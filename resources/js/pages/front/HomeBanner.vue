
<template>
  <div class="bg-primary tx-center">
  <div class="home-slider">
    <slider ref="slider" :options="options">
      <slideritem><img src="/assets/front/banners/home_01.jpg" alt=""></slideritem>
      <slideritem>2</slideritem>
      <slideritem>3</slideritem>
      <slideritem>4</slideritem>
      <div slot="loading">loading...</div>
    </slider>
  </div>
  </div>
</template>
<script>
import { slider, slideritem } from 'vue-concise-slider'// import slider components
export default {
  name: 'HomeBanners',
  data () {
    return {
        options: {
        currentPage: 0,
        thresholdDistance:500,
        thresholdTime:100,
         direction:'horizontal',
        loopedSlides:1,
        slidesToScroll:1,
        timingFunction: 'ease',
        speed: 300
      }
    }
  },
  components: {
    slider,
    slideritem
  },

 }
</script>