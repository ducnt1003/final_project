<template>
  <div>
    <div class="container-fluid">
      <div class="">
        <div class="position-relative">
          <img class="img-fluid" width="100%" src="/img/bg-ab.jpg" alt="" />
          <div
            class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
            style="background: rgba(24, 29, 56, 0.7)"
          >
            <div class="container">
              <div class="row justify-content-start">
                <div class="col-sm-10 col-lg-8">
                  <h5
                    class="text-primary text-uppercase mb-3 animated slideInDown"
                  ></h5>
                  <h1
                    class="display-3 text-white text-uppercase animated slideInDown"
                  >
                    Vui lòng chọn những định hướng quan tâm
                  </h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-xxl mt-5 mb-2">
      <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">
          Các định hướng của hệ thống
        </h6>
      </div>
      <div class="container mt-5">
        <div class="row g-3 mb-4">
          <div v-for="item in data" class="col-lg-4 mb-2 text-center">
            <button
              v-if="select_id.includes(item.id)"
              type="button"
              @click="activeLink($event, item)"
              class="btn btn-secondary"
              style="width: 90%"
            >
              {{ item.name }}
            </button>
            <button
              v-else
              type="button"
              @click="activeLink($event, item)"
              class="btn btn-outline-secondary"
              style="width: 90%"
            >
              {{ item.name }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 mb-5 row g-6 justify-content-center">
      <div class="col-lg-2 text-center">
        <button @click="submit" type="button" class="btn btn-info" style="width: 100%"
          >Xác nhận</button
        >
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { getDirections, selectDirection, selectedDirection  } from "../services/direction";
import { getAccessToken } from '@/utils/cookies'
export default {
  name: "SelectTag",

  setup() {
    const data = ref([]);
    const select = ref([]);
    const select_id = ref([]);

    return {
      data,
      select,
      select_id
    };
  },
  methods: {
    async getData() {
      try {  
        const response = await getDirections()
        const selected = await selectedDirection()
        this.data = response.data.data
        this.select = selected.data.data
        this.select_id = this.select.map((e) => e.id)
        console.log(this.select)
        
        // this
      } finally {
        this.isSubmiting = false
      }
    },
    activeLink(event, item) {
      if (event.target.className == "btn btn-outline-secondary") {
        event.target.className = "btn btn-secondary";
        this.select.push(item)
      } else {
        event.target.className = "btn btn-outline-secondary";
        this.select = this.select.filter((e) => e.id != item.id)
      }
      
    },
    async submit() {
      // console.log(this.select)
      const data = {
        directions : this.select.map((e) => e.id)
      }
      try {
        const response = await selectDirection(data)
        if (response.success) {
          this.$router.push('/')
        }
      } finally {

      }
      
    }
  },
  async created() {
    await this.getData();
  },
  async beforeRouteEnter(to, from, next) {
      const token = await getAccessToken();
      if (!token) {
        return next({ name: "Login" });
      } else {
        return next();
      }
  }
};
</script>
