<template>
  <div style="background: rgba(206, 220, 242, 0.3)" height="100%">
    <div class="container-fluid" style="padding-top: 60px; padding-bottom: 60px">
      <div class="row">
        <div class="col-md-3">
          <CCard>
            <CCardHeader
              ><CCardTitle
                >{{ course.name }}</CCardTitle
              ></CCardHeader
            >
            <CCardBody>
              <CCardText
                >{{course.description}}</CCardText
              >
            </CCardBody>
          </CCard>
          <CAccordion style="margin-top: 20px" :active-item-key="0">
            <div>
              <CAccordionItem
                v-for="(part, part_index) in parts"
                :item-key="part_index"
              >
                <CAccordionHeader>
                  <strong>{{ part.name }}</strong>
                </CAccordionHeader>
                <CAccordionBody>
                  <CListGroup>
                    <CListGroup
                      flush
                      v-for="(document, index) in part.documents"
                    >
                      <CListGroupItem
                        v-if="document.id == selected.id"
                        component="button"
                        @click="selectDoc(part_index, index)"
                        ><strong>{{ document.name }}</strong></CListGroupItem
                      >
                      <CListGroupItem
                        v-else
                        component="button"
                        @click="selectDoc(part_index, index)"
                        >{{ document.name }}</CListGroupItem
                      >
                    </CListGroup>
                  </CListGroup>
                </CAccordionBody>
              </CAccordionItem>
            </div>
          </CAccordion>
        </div>

        <div class="col-md-9">
          <div class="container" style="text-align: center">
            <object
              v-if="this.selected.type == 'pdf'"
              :data="selected.path"
              type="application/pdf"
              width="100%"
              height="600px"
            ></object>

            <video v-if="this.selected.type == 'mp4'" width="900" controls>
              <source :src="selected.path" type="video/mp4" />
            </video>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VuePdfEmbed from "vue-pdf-embed";
import { ref } from "@vue/reactivity";
export default {
  components: {
    VuePdfEmbed,
  },
  setup() {
    const parts = ref([]);
    const selected = ref({});
    const course = ref({});
    return {
      parts,
      selected,
      course,
    };
  },
  methods: {
    selectDoc(part, index) {
      const documents = this.parts[part].documents;
      this.selected = documents[index];
    },
    async getData() {
      this.course ={
        id: 1,
        name: "Thiết kế giao diện người dùng",
        teacher: "Thang Nguyen",
        number_parts: 15,
        image: "img/thumbnail_placeholder.png",
        price: 1000000,
        number_enrolls: 120,
        description:
          "Đa số người dùng  đánh giá chất lượng của 1 hệ thống thông qua giao diện hơn là thông qua chức năng. Giao diện không tốt là nguyên nhân dẫn người dùng đến lỗi. Thiết kế giao diện người dùng không tốt là nguyên nhân dẫn đến nhiều phần mềm không được sử dụng.",
      },
      this.parts = [
        {
          name: "Tổng quan",
          documents: [
            {
              id: 1,
              type: "mp4",
              path: "/intro.mp4",
              name: "Mo dau",
            },
            {
              id: 2,
              type: "pdf",
              path: "/ui-ux1.pdf",
              name: "Gioi thieu",
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
              name: "Mo dau",
            },
            {
              id: 4,
              type: "pdf",
              path: "/ui-ux1.pdf",
              name: "Gioi thieu",
            },
          ],
        },
      ];
    },
  },
  async created() {
    await this.getData();
    this.selectDoc(0, 0);
  },
};
</script>
<style scoped></style>
