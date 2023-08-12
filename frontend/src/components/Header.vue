<template>
  <nav
    class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0"
  >
    <a
      href="index.html"
      class="navbar-brand d-flex align-items-center px-4 px-lg-5"
    >
      <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>eLEARNING</h2>
    </a>
    <button
      type="button"
      class="navbar-toggler me-4"
      data-bs-toggle="collapse"
      data-bs-target="#navbarCollapse"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <router-link class="nav-item nav-link" :to="{ name: 'Home' }"
          >Trang chủ</router-link
        >
        <a href="/courses" class="nav-item nav-link">Danh sách khóa học</a>
        
        <a href="/" class="nav-item nav-link">Liên hệ</a>
        <div v-if="token" class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            >Cá nhân</a
          >
          <div class="dropdown-menu fade-down m-0" style="right:0%">
            <a href="/recomend-courses" class="dropdown-item">Khóa học gợi ý</a>
            <a href="/select-tag" class="dropdown-item">Định hướng</a>
            <a @click="logout" role="button" class="dropdown-item">Đăng xuất</a>
          </div>
        </div>
      </div>
      <a
        v-if="!token"
        href="/login"
        class="btn btn-primary py-4 px-lg-5 d-none d-lg-block"
        >Đăng nhập<i class="fa fa-arrow-right ms-3"></i
      ></a>
    </div>
  </nav>
</template>
<script>
import { ref } from "@vue/reactivity";
import { getAccessToken, removeAccessToken } from "@/utils/cookies";
// import { log_out } from "@/services/auth";

export default {
  name: "Header",
  components: {},
  setup() {
    const token = getAccessToken();
    return {
      token,
    };
  },
  methods: {
    async logout(){
      // const response = await log_out()
      removeAccessToken()
      this.$router.push({ name: 'Login' })
    }
  },
  created() {
  },
};
</script>
