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
                    Vui lòng chọn những nội dung quan tâm
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
          Các nội dung của hệ thống
        </h6>
      </div>
      <div class="container mt-5">
        <div class="row g-3 mb-4">
          <div v-for="item in data" class="col-lg-4 mb-2 text-center">
            <button
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
        <a href="/" type="button" class="btn btn-info" style="width: 100%"
          >Xác nhận</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "@vue/reactivity";
export default {
  name: "SelectTag",

  setup() {
    const data = ref([]);

    return {
      data,
    };
  },
  methods: {
    getData() {
      this.data = [
        {
          name: "BackEnd Developer",
        },
        {
          name: "FrontEnd Developer",
        },
        {
          name: "Bussiness Analyst",
        },
        {
          name: "Data Engineer",
        },
        {
          name: "Big Data",
        },
        {
          name: "Machine Learning",
        },
      ];
    },
    activeLink(event, item) {
      console.log(item);
      if (event.target.className == "btn btn-outline-secondary") {
        event.target.className = "btn btn-secondary";
      } else {
        event.target.className = "btn btn-outline-secondary";
      }
    },
  },
  created() {
    this.getData();
  },
};
</script>
