<template>
  <div>
    <!--<div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>-->
    <!-- Spinner End -->

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
                    class="display-3 text-primary text-uppercase animated slideInDown"
                  >
                    Học viện Online
                  </h1>
                  <p class="fs-5 text-white mb-4 pb-2">
                    Chia sẻ kiến thức và kinh nghiệm thực tế tới hàng triệu
                    người
                    <br />
                    HỌC MỌI LÚC, MỌI NƠI
                  </p>
                  <a
                    href=""
                    class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft"
                    >Tìm hiểu</a
                  >
                  <a
                    href=""
                    class="btn btn-light py-md-3 px-md-5 animated slideInRight"
                    >Tham gia ngay</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Carousel End -->

    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title bg-white text-center text-primary px-3">
            Danh mục
          </h6>
          <h1 class="mb-5">Các danh mục</h1>
        </div>
        <div class="row g-3">
          <div class="col-lg-7 col-md-6">
            <div class="row g-3">
              <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                <a class="position-relative d-block overflow-hidden" href="">
                  <img class="img-fluid" src="/img/cat-1.jpg" alt="" />
                  <div
                    class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                    style="margin: 1px"
                  >
                    <h5 class="m-0">Khoa học máy tính</h5>
                    <small class="text-primary">78 khóa</small>
                  </div>
                </a>
              </div>
              <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                <a class="position-relative d-block overflow-hidden" href="">
                  <img class="img-fluid" src="/img/cat-2.jpg" alt="" />
                  <div
                    class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                    style="margin: 1px"
                  >
                    <h5 class="m-0">Mạng và truyền thông</h5>
                    <small class="text-primary">39 khóa</small>
                  </div>
                </a>
              </div>
              <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                <a class="position-relative d-block overflow-hidden" href="">
                  <img class="img-fluid" src="/img/cat-3.jpg" alt="" />
                  <div
                    class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                    style="margin: 1px"
                  >
                    <h5 class="m-0">Ngôn ngữ</h5>
                    <small class="text-primary">67 khóa</small>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div
            class="col-lg-5 col-md-6 wow zoomIn"
            data-wow-delay="0.7s"
            style="min-height: 350px"
          >
            <a class="position-relative d-block h-100 overflow-hidden" href="">
              <img
                class="img-fluid position-absolute w-100 h-100"
                src="/img/cat-4.jpg"
                alt=""
                style="object-fit: cover"
              />
              <div
                class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                style="margin: 1px"
              >
                <h5 class="m-0">Kĩ năng mềm</h5>
                <small class="text-primary">49 khóa</small>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Categories Start -->

    <!-- Courses Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title bg-white text-center text-primary px-3">
            Khóa học
          </h6>
          <h1 class="mb-5">Khóa học phổ biến</h1>
        </div>
        <div class="row g-4 justify-content-center">
          <div
            v-for="(course, index) in courses"
            class="col-lg-4 col-md-6 wow fadeInUp"
            data-wow-delay="0.1s"
          >
            <div class="course-item bg-light">
              <div class="position-relative overflow-hidden">
                <img class="img-fluid" :src="course.image" alt="" />
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
                  >{{ course.teacher?.name }}</small
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
    </div>
    <!-- Courses End -->

    <!-- Courses Start -->
    <div v-if="!!token" class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h1 class="mb-5">Khóa học gợi ý</h1>
        </div>
        <div class="row g-4 justify-content-center">
          <div
            v-for="(course, index) in recomends"
            class="col-lg-4 col-md-6 wow fadeInUp"
            data-wow-delay="0.1s"
          >
            <div class="course-item bg-light">
              <div class="position-relative overflow-hidden">
                <img class="img-fluid" :src="course.image" alt="" />
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
                  >{{ course.teacher?.name }}</small
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
    </div>
    <!-- Courses End -->
    <!-- About Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="row g-5">
          <div
            class="col-lg-6 wow fadeInUp"
            data-wow-delay="0.1s"
            style="min-height: 400px"
          >
            <div class="position-relative h-100">
              <img
                class="img-fluid position-absolute w-100 h-100"
                src="/img/about.jpg"
                alt=""
                style="object-fit: cover"
              />
            </div>
          </div>
          <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
            <h6 class="section-title bg-white text-start text-primary pe-3">
              Về chúng tôi
            </h6>
            <h1 class="mb-4">Chào mừng bạn đến với eLEARNING</h1>
            <p class="mb-4">
              E-learning không chỉ là một lĩnh vực đầu tư tiềm năng mà còn là
              một sản phẩm nhân văn, mang lại cơ hội tiếp cận tri thức tinh hoa
              cho tất cả mọi người.
            </p>
            <p class="mb-4">
              Nếu bạn có đam mê với giáo dục, hãy cùng chúng tôi tạo nên những
              đột phá mới để thay đổi thực tại và kiến tạo tương lai!
            </p>
            <div class="row gy-2 gx-4 mb-4">
              <div class="col-sm-6">
                <p class="mb-0">
                  <i class="fa fa-arrow-right text-primary me-2"></i>Học mọi lúc
                  mọi nơi
                </p>
              </div>
              <div class="col-sm-6">
                <p class="mb-0">
                  <i class="fa fa-arrow-right text-primary me-2"></i>Chi phí hợp
                  lý
                </p>
              </div>
              <div class="col-sm-6">
                <p class="mb-0">
                  <i class="fa fa-arrow-right text-primary me-2"></i>Tính ứng
                  dụng cao
                </p>
              </div>
              <div class="col-sm-6">
                <p class="mb-0">
                  <i class="fa fa-arrow-right text-primary me-2"></i>Tương tác
                  với giảng viên
                </p>
              </div>
              <div class="col-sm-6">
                <p class="mb-0">
                  <i class="fa fa-arrow-right text-primary me-2"></i>Hỗ trợ 24/7
                </p>
              </div>
            </div>
            <a class="btn btn-primary py-3 px-5 mt-2" href="">Tìm hiểu</a>
          </div>
        </div>
      </div>
    </div>
    <!-- About End -->
    <!-- Service Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="row g-4">
          <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="service-item text-center pt-3">
              <div class="p-4">
                <i class="fa fa-3x fa-desktop text-primary mb-4"></i>
                <h5 class="mb-3">FrontEnd Develop</h5>
                <p>Bạn muốn trở thành một lập trình viên FrontEnd</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
            <div class="service-item text-center pt-3">
              <div class="p-4">
                <i class="fa fa-3x fa-desktop text-primary mb-4"></i>
                <h5 class="mb-3">BackEnd Develop</h5>
                <p>Bạn muốn trở thành một lập trình viên BackEnd</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
            <div class="service-item text-center pt-3">
              <div class="p-4">
                <i class="fa fa-3x fa-lightbulb text-primary mb-4"></i>
                <h5 class="mb-3">Data Analyst</h5>
                <p>Phân tích dữ liệu</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
            <div class="service-item text-center pt-3">
              <div class="p-4">
                <i class="fa fa-3x fa-lightbulb text-primary mb-4"></i>
                <h5 class="mb-3">Data Engineer</h5>
                <p>Trở thành một kĩ sư data</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Service End -->
    <!-- Team Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title bg-white text-center text-primary px-3">
            Giảng viên
          </h6>
          <h1 class="mb-5">GIảng viên tiêu biểu</h1>
        </div>
        <div class="row g-4">
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="team-item bg-light">
              <div class="overflow-hidden">
                <img
                  width="100%"
                  height="300px"
                  src="/img/user_placeholder.png"
                  alt=""
                />
              </div>
              <div
                class="position-relative d-flex justify-content-center"
                style="margin-top: -23px"
              >
                <div class="bg-light d-flex justify-content-center pt-2 px-1">
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-facebook-f"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-twitter"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-instagram"></i
                  ></a>
                </div>
              </div>
              <div class="text-center p-4">
                <h5 class="mb-0">Dat Nguyen</h5>
                <small>Tiến sĩ</small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
            <div class="team-item bg-light">
              <div class="overflow-hidden">
                <img
                  width="100%"
                  height="300px"
                  src="/img/user_placeholder.png"
                  alt=""
                />
              </div>
              <div
                class="position-relative d-flex justify-content-center"
                style="margin-top: -23px"
              >
                <div class="bg-light d-flex justify-content-center pt-2 px-1">
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-facebook-f"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-twitter"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-instagram"></i
                  ></a>
                </div>
              </div>
              <div class="text-center p-4">
                <h5 class="mb-0">Hai Nguyen</h5>
                <small>Tiến sĩ </small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
            <div class="team-item bg-light">
              <div class="overflow-hidden">
                <img
                  width="100%"
                  height="300px"
                  src="/img/user_placeholder.png"
                  alt=""
                />
              </div>
              <div
                class="position-relative d-flex justify-content-center"
                style="margin-top: -23px"
              >
                <div class="bg-light d-flex justify-content-center pt-2 px-1">
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-facebook-f"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-twitter"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-instagram"></i
                  ></a>
                </div>
              </div>
              <div class="text-center p-4">
                <h5 class="mb-0">Trung Nguyen</h5>
                <small>Thạc sĩ</small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
            <div class="team-item bg-light">
              <div class="overflow-hidden">
                <img
                  width="100%"
                  height="300px"
                  src="/img/user_placeholder.png"
                  alt=""
                />
              </div>
              <div
                class="position-relative d-flex justify-content-center"
                style="margin-top: -23px"
              >
                <div class="bg-light d-flex justify-content-center pt-2 px-1">
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-facebook-f"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-twitter"></i
                  ></a>
                  <a class="btn btn-sm-square btn-primary mx-1" href=""
                    ><i class="fab fa-instagram"></i
                  ></a>
                </div>
              </div>
              <div class="text-center p-4">
                <h5 class="mb-0">Long Pham</h5>
                <small>Thạc sĩ</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Team End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
      ><i class="bi bi-arrow-up"></i
    ></a>
  </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { getAccessToken } from "@/utils/cookies";
import { getCourses, recomend } from "../services/course";

export default {
  name: "Main",
  setup() {
    const courses = ref([]);
    const recomends = ref([]);
    const token = getAccessToken();

    return {
      courses,
      recomends,
      token,
    };
  },
  methods: {
    async getData() {
      try {
        const response = await getCourses();

        this.courses = response.data.data.slice(0, 3);
        if (!!this.token) {
          // const recomends = await recomend(1)
          this.recomends = response.data.data.slice(4, 7);
        }
      } finally {
      }
      // this.courses = [
      //   {
      //     id: 1,
      //     name: "Thiết kế giao diện người dùng",
      //     teacher: "Thang Nguyen",
      //     number_parts: 15,
      //     image: "img/thumbnail_placeholder.png",
      //     price: 1000000,
      //     number_enrolls: 120,
      //   },
      //   {
      //     id: 2,
      //     name: "Kiến trúc phần mềm",
      //     teacher: "Trung Nguyen",
      //     number_parts: 20,
      //     image: "img/thumbnail_placeholder.png",
      //     price: 1000000,
      //     number_enrolls: 120,
      //   },
      //   {
      //     id: 3,
      //     name: "Tư duy toán học",
      //     teacher: "Dat Nguyen",
      //     number_parts: 12,
      //     image: "img/thumbnail_placeholder.png",
      //     price: 1000000,
      //     number_enrolls: 120,
      //   }
      // ];
    },
  },
  async created() {
    await this.getData();
  },
};
</script>
