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
import { getCourseDetail } from "../services/course";
import { useRoute } from "vue-router";
export default {
  components: {
    VuePdfEmbed,
  },
  setup() {
    const parts = ref([]);
    const selected = ref({});
    const course = ref({});
    const courseId = useRoute().params.id;
    return {
      parts,
      selected,
      course,
      courseId
    };
  },
  methods: {
    selectDoc(part, index) {
      const documents = this.parts[part].documents;
      this.selected = documents[index];
    },
    async getData() {
      try {
        const response = await getCourseDetail(this.courseId);
        this.course = response.data;
      } finally {
      }
      this.parts = this.course.parts
      
    },
  },
  async created() {
    await this.getData();
    this.selectDoc(0, 0);
  },
};
</script>
<style scoped></style>
