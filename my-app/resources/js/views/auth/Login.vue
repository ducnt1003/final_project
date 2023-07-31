<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol xs="12" md="10" lg="8" xl="6">
          <CCard class="p-0 p-sm-4">
            <div class="d-flex justify-content-center">
              <img :src="logoSquare" class="img-fluid" style="max-width: 200px" />
            </div>
            <CCardBody>
              <h1 class="text-center">{{ $t('auth.login.title') }}</h1>
              <Form id="login_form"
                  as="CForm"
                  v-slot="{ errors }"
                  @submit="onSubmit"
                  :validation-schema="schema"
              >
                <CFormFloating class="my-4">
                  <Field
                      as="CFormInput"
                      name="user_name"
                      type="text"
                      id="user_name"
                      :placeholder="$t('auth.common.username')"
                      :invalid="!!errors?.user_name"
                      :feedback-invalid="errors?.user_name"
                  />
                  <CFormLabel for="user_name">
                    {{ $t('auth.common.username') }}
                  </CFormLabel>
                </CFormFloating>

                <CFormFloating class="my-4">
                  <Field
                      as="CFormInput"
                      name="password"
                      type="password"
                      id="password"
                      :placeholder="$t('auth.common.password')"
                      :invalid="!!errors?.password"
                      :feedback-invalid="errors?.password"
                  />
                  <CFormLabel for="password">
                    {{ $t('auth.common.password') }}
                  </CFormLabel>
                </CFormFloating>

                <div class="d-grid gap-2">
                  <CButton id="login_button"
                      type="submit"
                      color="primary"
                      size="lg"
                      :disabled="isSubmiting || Object.keys(errors).length > 0"
                  >
                    <CSpinner
                        v-if="isSubmiting"
                        component="span"
                        size="sm"
                        aria-hidden="true"
                    />
                    <span v-else>{{ $t('auth.common.login') }}</span>
                  </CButton>
                </div>
              </Form>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import { Form, Field } from 'vee-validate';
import * as yup from 'yup';
import { login } from '@/services/auth';
import { setAccessToken, getAccessToken } from '@/utils/cookies';
import logoSquare from '@/assets/images/logo.jpg';
import { mapActions } from 'vuex';

export default {
  name: 'Login',
  components: {
    Form,
    Field,
  },
  data() {
    const schema = yup.object({
      user_name: yup
          .string()
          .required(this.$t('validate.username.required')),
      password: yup
          .string()
          .required(this.$t('validate.password.required'))
        //   .min(8, this.$t('validate.password.min')),
    })

    return {
      isSubmiting: false,
      schema,
      logoSquare
    }
  },
  methods: {
    ...mapActions(['setUser']),
    async onSubmit(values) {
      const enable_otp = import.meta.env.VITE_OTP_ENABLED;
      this.isSubmiting = true
      const body = {
        email: values.user_name,
        password: values.password,
      }
      try {
        const response = await login(body)

        if (response?.data) {
          await setAccessToken(response.data.access_token, {
            expires: new Date(Date.now() + response.data.expires_in * 1000),
            path: "/",
          })
          console.log( new Date(Date.now() + response.data.expires_in * 1000))
          this.setUser(response.data)
          this.$router.push({name: "Home"})
        }
      } finally {
        this.isSubmiting = false
      }
    },
  },
}
</script>
