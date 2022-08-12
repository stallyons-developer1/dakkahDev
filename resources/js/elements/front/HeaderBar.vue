<template>
    <header class="header bg-light">
    <div class="container d-flex justify-content-between align-items-center">

      <router-link to="/" class="logo"><img src="/assets/front/images/logo.svg" alt="دكة للدورات التدريبية"></router-link>


      <a href="#" @click="isMobileNav=!isMobileNav" class="mobile-nav">
        <i class="ri-menu-line" v-if="!isMobileNav"></i>
        <i class="ri-close-fill" v-if="isMobileNav"></i>
      </a>

      <div :class="{active: isMobileNav}" class="d-flex align-items-center sub-nav">
        <ul class="d-flex primary-nav">
          <li><router-link exact-active-class="active" to="/" >{{ 'Home' | translate}}</router-link></li>
          <li><router-link exact-active-class="active" to="/trainers">{{'Trainers' | translate}}</router-link></li>
          <li><router-link exact-active-class="active" to="/courses">الدورات التدريبية</router-link></li>
          <li><router-link exact-active-class="active" to="/contact">تواصل معنا</router-link></li>
        </ul>
        <div class="my-account dropdown" v-if="info">
          <a @click.prevent="dropDown =! dropDown" class="btn btn-rounded btn-primary-outline">حسابي</a>
          <ul :class="{active: dropDown}" class="dropdown-menu">
              <li><router-link to="/profile">الملف الشخصي</router-link></li>
              <li id="test"><a href="/admin/courses">لوحة التحكم</a></li>
            <li><router-link to="/myFavorite">المفضلة</router-link></li>
            <li><router-link :to="'/courses/my_courses/' + info.user_id">دوراتى التدريبية</router-link></li>
            <li><a href="/logout_front">تسجيل الخروج</a></li>
          </ul>
        </div>
        <div class="d-flex" v-if="info == null">
          <router-link to="/auth/login" class="btn btn-rounded btn-primary-outline">تسجيل الدخول</router-link>
          <router-link to="/auth/register" class="btn btn-rounded btn-secondary">سجل كمدرب</router-link>
          <router-link to="/auth/registertrainee" class="btn btn-rounded btn-secondary">سجل كمتدرب</router-link>
        </div>
      </div>

    </div>
    </header>
</template>


<script>
const myTimeout = setTimeout(myGreeting, 2000);

function myGreeting() {
  const role_id = localStorage.getItem("role_id");
  if (role_id == 3) {
  console.log(role_id);
      document.getElementById("test").style.display = 'none';
  }
}

function myStopFunction() {
  clearTimeout(myTimeout);
}


export default {
  name: 'headerBar',

  data () {
    return {
      isMobileNav:false,
      isMember:false,
      dropDown:false,
      info:info ,
      dir:dir,
      locale:locale
     }
  },
  methods: {

  },

}

</script>
