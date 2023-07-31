import axios from 'axios'
import { StatusCodes } from 'http-status-codes'
import { useToast } from 'vue-toastification'
import { getAccessToken, removeAccessToken } from '@/utils/cookies'
import Router from '@/router'
import i18n from '@/i18n/i18n'

const toast = useToast()
const { t } = i18n.global

// Http header setting
const HEADER_ACCEPT = 'application/json'
const HEADER_CONTENT_TYPE = 'application/json'
const WITH_CREDENTIALS = false
const REQUEST_HEADER = {
  Accept: HEADER_ACCEPT,
  'Content-Type': HEADER_CONTENT_TYPE,
}

const service = axios.create({
  baseURL: import.meta.env.VITE_API_ENDPOINT,
  withCredentials: WITH_CREDENTIALS,
  headers: REQUEST_HEADER,
})

// Request intercepter
service.interceptors.request.use(
    (config) => {
      // Set JWT token
      const token = getAccessToken()
      if (token) {
        config.headers['Authorization'] = 'Bearer ' + token
      } else Router.push({ name: 'Login' });

      return config
    },
    (error) => {
      return Promise.reject(error)
    },
)

// Response interceptor
service.interceptors.response.use(
    (response) => {
      if (response.status) {
        response.data.statusCode = response.status
      }

      return response.data
    },
    (error) => {
      let message = error.message

      if (error.response.data) {
        message = error.response.data.message || t('common.errorMessage')
      }

      switch (error.response.status) {
        // when token expired - 401
        case StatusCodes.UNAUTHORIZED:
          removeAccessToken({ path: "/" });
          Router.push({ name: 'Login' });

          break;
        // when not allowed - 403
        case StatusCodes.FORBIDDEN:
          Router.push({ name: 'Error', params: { pathMatch: 403 } });
          break;
        //when not found - 404
        case StatusCodes.NOT_FOUND:
          Router.push({ name: 'Error', params: { pathMatch: 404 } });
          break;
        // 422
        case StatusCodes.UNPROCESSABLE_ENTITY:
          // Get the first error message of first variable
          message = Object.values(error.response.data.errors)?.[0]?.[0] || t('common.errorMessage');
          break;
        default:
          break;
      }

      toast.error(message)

      return Promise.reject(error)
    },
)

export default service
