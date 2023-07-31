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
    <div class="container-fluid py-5">
      <div class="container py-5">
        <div class="row">
          <div class="col-lg-8">
            <div class="mb-5">
              <div class="position-relative mb-5">
                <h1 class="display-4">
                  {{ course.name }}
                </h1>
              </div>

              <img
                class="img-fluid rounded w-100 mb-4"
                src="/img/thumbnail_placeholder.png"
                alt="Image"
              />

              <p>
                {{ course.description }}
              </p>
              <p>
                {{ course.description }}
              </p>
            </div>

            <div class="card">
              <div class="card-header">
                <h2 class="mb-3">Nội dung khóa học</h2>
              </div>
              <div class="card-body">
                <CAccordion style="margin-top: 20px" :active-item-key="0">
                  <div>
                    <CAccordionItem
                      v-for="(part, part_index) in parts"
                      :item-key="part_index"
                    >
                      <CAccordionHeader>
                        <strong
                          >Buổi {{ part_index + 1 }}:{{ part.name }}</strong
                        >
                      </CAccordionHeader>
                      <CAccordionBody>
                        <CListGroup>
                          <CListGroup
                            flush
                            v-for="(document, index) in part.documents"
                          >
                            <CListGroupItem component="button"
                              ><strong>{{
                                document.name
                              }}</strong></CListGroupItem
                            >
                          </CListGroup>
                        </CListGroup>
                      </CAccordionBody>
                    </CAccordionItem>
                  </div>
                </CAccordion>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="bg-primary mb-5 py-3">
              <h3 class="text-white py-3 px-4 m-0">Thông tin khóa học</h3>
              <div class="d-flex justify-content-between border-bottom px-4">
                <h6 class="text-white my-3">Giảng viên</h6>
                <h6 class="text-white my-3">{{ course.teacher?.name }}</h6>
              </div>
              <div class="d-flex justify-content-between border-bottom px-4">
                <h6 class="text-white my-3">Danh mục</h6>
                <h6 class="text-white my-3">{{ course.category }}</h6>
              </div>
              <div class="d-flex justify-content-between border-bottom px-4">
                <h6 class="text-white my-3">Đánh giá</h6>
                <h6 class="text-white my-3">4.5 <small>(250)</small></h6>
              </div>
              <div class="d-flex justify-content-between border-bottom px-4">
                <h6 class="text-white my-3">Bài giảng</h6>
                <h6 class="text-white my-3">{{ course.number_parts }}</h6>
              </div>
              <div class="d-flex justify-content-between border-bottom px-4">
                <h6 class="text-white my-3">Độ khó</h6>
                <h6 class="text-white my-3">{{ course.level }}</h6>
              </div>
              <div class="d-flex justify-content-between px-4">
                <h6 class="text-white my-3">Ngôn ngữ</h6>
                <h6 class="text-white my-3">Tiếng Việt</h6>
              </div>
              <div class="d-flex justify-content-between px-4">
                <h6 class="text-white my-3">Số người học</h6>
                <h6 class="text-white my-3">{{ course.number_enrolls }}</h6>
              </div>

              <div class="py-3 px-4">
                <button
                  class="btn btn-block btn-secondary py-3 px-5"
                  @click="getDocument()"
                >
                  {{ enroll_text }}
                </button>
              </div>
            </div>

            <div class="mb-5">
              <h2 class="mb-4">Khóa học tương tự</h2>
              <a
                v-for="course in recomend"
                class="d-flex align-items-center text-decoration-none mb-4"
                href=""
              >
                <div class="pl-3">
                  <img class="img-fluid rounded" :src="course.image" alt="" />
                  <h5>{{ course.name }}</h5>
                  <div class="d-flex">
                    <small class="text-body mr-3"
                      ><i class="fa fa-user text-primary mr-2"></i
                      >{{ course.teacher }}</small
                    >
                    <small class="text-body"
                      ><i class="fa fa-star text-primary mr-2"></i>4.5
                      (450)</small
                    >
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Detail End -->
  </div>
</template>
<script>
import { ref } from "@vue/reactivity";
import { enroll, getCourseDetail, isEnroll } from "../services/course";
import { useRoute } from "vue-router";
import { getAccessToken } from "@/utils/cookies";
export default {
  setup() {
    const course = ref({});
    const recomend = ref([]);
    const parts = ref([]);
    const courseId = useRoute().params.id;
    const enroll_text = ref("Đăng ký");
    return {
      course,
      recomend,
      parts,
      courseId,
      enroll_text,
    };
  },
  methods: {
    async getData() {
      try {
        const response = await getCourseDetail(this.courseId);
        this.course = response.data;
      } finally {
      }

      this.recomend = [
        {
          id: 1,
          name: "Thiết kế giao diện người dùng",
          teacher: "Thang Nguyen",
          number_parts: 15,
          image: "/img/thumbnail_placeholder.png",
          price: 1000000,
          number_enrolls: 120,
        },
        {
          id: 2,
          name: "Kiến trúc phần mềm",
          teacher: "Trung Nguyen",
          number_parts: 20,
          image: "/img/thumbnail_placeholder.png",
          price: 1000000,
          number_enrolls: 120,
        },
        {
          id: 3,
          name: "Tư duy toán học",
          teacher: "Dat Nguyen",
          number_parts: 12,
          image: "/img/thumbnail_placeholder.png",
          price: 1000000,
          number_enrolls: 120,
        },
      ];
      this.parts = [
        {
          name: "Tổng quan",
          documents: [
            {
              id: 1,
              type: "mp4",
              path: "/intro.mp4",
              name: "Mở đầu",
            },
            {
              id: 2,
              type: "pdf",
              path: "/ui-ux1.pdf",
              name: "Giới thiệu",
            },
          ],
        },
        {
          name: "Bài học đầu",
          documents: [
            {
              id: 3,
              type: "mp4",
              path: "/intro.mp4",
              name: "Lý thuyết",
            },
            {
              id: 4,
              type: "pdf",
              path: "/ui-ux1.pdf",
              name: "Bài tập",
            },
          ],
        },
      ];
    },
    async getDocument() {
      const token = getAccessToken();
      if (!token) {
        this.$router.push({ name: "Login" });
      } else {
        if (this.enroll_text != "Tiếp tục") {
          try {
            const response = await enroll({course_id : this.courseId})
          } finally {}
        } 
        this.$router.push({
          name: "Course-Document",
          params: { id: this.courseId },
        });
      }
    },
    async checkEnroll() {
      const token = getAccessToken();
      if (!!token) {
        try {
          const response = await isEnroll({course_id : this.courseId});
          if (response.data == true) {
            this.enroll_text = "Tiếp tục";
          }
        } finally {
        }
      }
    },
  },
  async created() {
    await this.getData();
    await this.checkEnroll();
  },
};
</script>
