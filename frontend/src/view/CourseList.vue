<template>
  <div>
    <!-- Carousel Start -->
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
                    Học viện online
                  </h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Carousel End -->
    <!-- Detail Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title bg-white text-center text-primary px-3">
            Khóa học
          </h6>
          <h1 class="mb-5">Danh sách khóa học</h1>
        </div>
        <div class="row justify-content-center" style="margin-bottom: 20px">
          <div class="col-4 form-group">
            <input
              id="name"
              type="text"
              value=""
              class="form-control"
              name="name"
              placeholder="Khóa học"
            />
          </div>

          <div class="col-3 form-group">
            <input
              id="teacher"
              type="text"
              class="form-control"
              name="teacher"
              placeholder="Giảng viên"
            />
          </div>

          <div class="col-3 form-group">
            <select class="form-control" name="courses_category_id" id="">
              <option value="">Tất cả</option>
              <option value="">Tất cả</option>
            </select>
          </div>
          <div
            class="col-2 text-align-right"
            style="
              display: flex;
              justify-content: flex-center;
              padding-right: 15px;
            "
          >
            <button
              style="width: 100%"
              padding-right="0"
              type="submit"
              class="btn btn-primary"
            >
              Tìm kiếm
            </button>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row g-4 justify-content-center">
          <div
            v-for="(course, index) in courses"
            class="col-lg-4 col-md-6 wow fadeInUp"
            data-wow-delay="0.1s"
          >
            <div class="course-item bg-light">
              <div class="position-relative overflow-hidden">
                <img class="img-fluid" :src=course.image alt="" />
                <div
                  class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4"
                >
                <router-link
                    :to="{ name: 'Course-Detail', params: { id: course.id } }"
                    class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end"
                    style="border-radius: 30px 0 0 30px"
                    >Tìm hiểu</router-link
                  >
                  <router-link
                    :to="{ name: 'Course-Detail', params: { id: course.id } }"
                    href="#"
                    class="flex-shrink-0 btn btn-sm btn-primary px-3"
                    style="border-radius: 0 30px 30px 0"
                    >Tham gia</router-link
                  >
                </div>
              </div>
              <div class="text-center p-4 pb-0">
                
                <div class="mb-3">
                  <small class="fa fa-star text-primary"></small>
                  <small class="fa fa-star text-primary"></small>
                  <small class="fa fa-star text-primary"></small>
                  <small class="fa fa-star text-primary"></small>
                  <small class="fa fa-star text-primary"></small>
                  <small>({{ course.number_enrolls }})</small>
                </div>
                <h5 class="mb-4">{{ course.name }}</h5>
              </div>
              <div class="d-flex border-top">
                <small class="flex-fill text-center border-end py-2"
                  ><i class="fa fa-user-tie text-primary me-2"></i
                  >{{ course.teacher.name }}</small
                >

                <small class="flex-fill text-center py-2"
                  ><i class="fa fa-video text-primary me-2"></i
                  >{{ course.number_parts }} bài giảng</small
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row justify-content-center" style="margin-top: 20px">
          <div class="col-4 justify-content-center" style="display: flex; justify-content: flex-center">
            <Pagination
              :pages="pages"
              @pageChange="handlePageChange"
              :currentPage="currentPage"
          />
          </div>
        </div>
      </div>
    </div>
    <!-- Detail End -->
  </div>
</template>
<script>
import { ref } from "@vue/reactivity";
import { getCourses } from "../services/course";
import Pagination from '@/components/Pagination.vue'
export default {
  components: {
    Pagination, 
  },
  setup() {
    const courses = ref([]);
    const param = ref('');
    const pages = ref(1)
    const currentPage = ref(1)
    const queries = ref({});
    return {
      courses,
      param,
      pages,
      currentPage
    };
  },
  // watch: {
  //   queries(queries) {
  //     this.setQueriesData(queries)
  //   },
  // },
  methods: {
    async getData() {
      try {
        const response = await getCourses(this.queries)
        this.courses = response.data.data
        this.pages = response.data.pagination.total_pages
        this.currentPage = parseInt(this.queries?.['page']) || 1
      } finally {

      }
      
    },
    setQueries() {
      this.queries = this.$route.query;
    },
    handlePageChange(number) {
      this.$router.push({ query: {page: number } })
    }
  },
  async created() {
    await this.getData();

    this.$watch(
      () => this.$route.query,
      async () => {
        if (this.$route.name === "Course-List") {
          
          this.setQueries();
          await this.getData();
          // this.isLoading = false;
        }
      }
    );
  },
};
</script>
