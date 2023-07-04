<template>
    <ContentCard>
      <template #title>{{ $t('users.list.title') }}</template>

      <!-- Table -->
      <DataTable
        :columns="columns"
        :datas="datas"
        :queries="queries"
        :filters="filters"
        :pages="pages"
        :isLoading="isLoading"
        :defaultSort="defaultSort"
        clickable
        @viewClick="handleView"
      />
    </ContentCard>
  </template>

  <script>
  import ContentCard from '@/components/Common/ContentCard.vue'
//   import * as units from '@/configs/users/Unit'
//   import * as positions from '@/configs/users/Position'
  import DataTable from '@/components/Common/DataTable.vue'
  import { ref } from '@vue/reactivity'

  export default {
    name: 'UserList',
    components: {
      ContentCard,
      DataTable,
    },
    setup() {
      const columns = []
      const queries = ref({})
      const filters = ref([])
      const isLoading = ref(false)
      const datas = ref([])
      const pages = ref(1)
      const defaultSort = ['id', 'asc']

      return {
        columns,
        queries,
        filters,
        datas,
        pages,
        isLoading,
        defaultSort,
      }
    },
    methods: {
      setColumns() {
        this.columns = [
        //   { data: 'id', title: this.$t('users.common.id'), sortable: true },
          {
            data: 'fullname',
            title: this.$t('users.common.fullname'),
            sortable: true,
          },
          { data: 'school', title: 'Trường', sortable: true },
          {
            data: 'email',
            title: 'Email',
            sortable: true,
          },
          {
            data: 'role',
            title: 'Vai trò',
            sortable: true,
          },
        ]
      },
      setFilters() {
        this.filters = [
          {
            data: 'name',
            type: 'CFormInput',
            label: this.$t('common.fullName'),
          },
          {
            data: 'email',
            type: 'CFormInput',
            label: 'Email',
          },
        ]
      },
      setQueries() {
        this.queries = this.$route.query
      },
      handleGetData() {
        // TODO: Call api to get data here
        this.isLoading = true
        this.pages = 1

        setTimeout(() => {
          this.datas = [
            {
              id: '0001',
              fullname: 'User1',
              school: 'Trường công nghệ thông tin và truyền thông',
              role: 'Admin',
              email: 'user1@sample.com',
            },
            {
              id: '0002',
              fullname: 'User2',
              school: 'Trường công nghệ thông tin và truyền thông',
              role: 'Giảng viên',
              email: 'user2@sample.com',
            },
            {
              id: '0003',
              fullname: 'User3',
              school: 'Trường công nghệ thông tin và truyền thông',
              role: 'Giảng viên',
              email: 'user3@sample.com',
            },
            {
              id: '0004',
              fullname: 'User4',
              school: 'Trường công nghệ thông tin và truyền thông',
              role: 'Sinh viên',
              email: 'user4@sample.com',
            },
            {
              id: '0005',
              fullname: 'User5',
              school: 'Trường công nghệ thông tin và truyền thông',
              role: 'Sinh viên',
              email: 'user5@sample.com',
            },
          ]

          this.pages = 1
          this.isLoading = false
        }, 1000)
      },
      handleView(event) {
        this.$router.push({ name: 'UserInfo', params: { id: event.id } })
      },
    },
    created() {
      this.setFilters()
      this.setColumns()

      // watch query change
      this.$watch(
        () => this.$route.query,
        () => {
          if (this.$route.name === 'UserList') {
            this.setQueries()
            this.handleGetData()
          }
        },
      )
    },
    mounted() {
      this.setQueries()
      this.handleGetData()
    },
  }
  </script>
