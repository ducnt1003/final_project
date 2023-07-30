<template>
  <!-- Section: Design Block -->
  <!-- Section: Design Block -->
  <!-- Jumbotron -->
  <div
    class="min-vh-100 d-flex px-4 py-5 px-md-5 text-center text-lg-start"
    style="background-color: hsl(0, 0%, 96%)"
  >
    <div class="container aligns-items-center">
      <div class="row gx-lg-5 align-items-center justify-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            HỌC VIỆN ONLINE <br />
            <span class="text-primary">eLearnings</span>
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
            Chia sẻ kiến thức và kinh nghiệm thực tế tới hàng triệu người
            <br />
            HỌC MỌI LÚC, MỌI NƠI
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <h2 class="card-title py-5 text-center">Đăng ký</h2>
            <div class="card-body py-5 px-md-5">
              <form>
                <!-- Name input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example3">Tên</label>
                  <input v-model="name" type="text" class="form-control" />
                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example3">Email</label>
                  <input v-model="email" type="mail" class="form-control" />
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example4">Mật khẩu</label>
                  <input
                    v-model="password"
                    type="password"
                    class="form-control"
                  />
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example4"
                    >Nhập lại mật khẩu</label
                  >
                  <input
                    v-model="re_password"
                    type="password"
                    class="form-control"
                  />
                </div>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-center mb-4">
                  <input
                    class="form-check-input me-2"
                    type="checkbox"
                    value=""
                    id="form2Example33"
                    checked
                  />
                  <label class="form-check-label" for="form2Example33">
                    Đăng ký nhận thông tin mới
                  </label>
                </div>

                <!-- Submit button -->
                <div class="d-flex justify-content-center">
                  <button
                    @click.prevent="register"
                    class="btn btn-primary btn-block mb-4"
                  >
                    Sign up
                  </button>
                </div>

                <div class="d-flex justify-content-center">
                  Đã có tài khoản ?
                  <router-link to="/login"> Đăng nhập</router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</template>
<script>
import { ref } from "@vue/reactivity";
import { register } from "@/services/auth";
import { useToast } from "vue-toastification";
import { setAccessToken } from '@/utils/cookies'

export default {
  setup() {
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const re_password = ref("");
    const toast = useToast();
    return {
      name,
      email,
      password,
      re_password,
      toast,
    };
  },
  methods: {
    async register() {
      // console.log(this.email)
      const data = {
        email: this.email,
        name: this.name,
        password: this.password,
        re_password: this.re_password,
      };
      // console.log(import.meta.env.VITE_API_URL)
      try {
        const response = await register(data);
        console.log(response);
        if (response.success) {
          this.toast.success("Create account success");
          await setAccessToken(response.data.access_token, {
            expires: new Date(Date.now() + 3600 * 1000),
            path: '/',
          }) 
          this.$router.push("/select-tag");
        }
      } finally {
        this.isSubmiting = false;
      }
      // localStorage.setItem("email", this.email)
      // this.$router.push('/select-tag')
    },
  },
};
</script>
