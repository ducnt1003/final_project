import axios from 'axios'
import { StatusCodes } from 'http-status-codes'
import { useToast } from 'vue-toastification'
import {
  getAccessToken,
  removeAccessToken,
} from '@/utils/cookies'
import Router from '@/router'

const toast = useToast()

const service = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: false,
  headers: {
    'Content-Type': 'application/json',
    accept: '*/*',
    'X-Requested-With': 'XMLHttpRequest',
    'Access-Control-Allow-Origin': '*',
  },
})

// Request intercepter
service.interceptors.request.use(
  (config) => {
    // Set JWT token
    const token = getAccessToken()
    if (token) {
      config.headers['Authorization'] = 'Bearer ' + token
    }

    return config
  },
  (error) => {
    return Promise.reject(error)
  },
)

// Response interceptor
service.interceptors.response.use(
  (response) => {
    // may remove this
    // if (response.headers.authorization) {
    //   response.data.token = response.headers.authorization
    // }

    if (response.status) {
      response.data.statusCode = response.status
    }

    return response.data
  },
  (error) => {
    // when token expired - 401
    if (error.response.status === StatusCodes.UNAUTHORIZED) {
      removeAccessToken()
      // push to error page

      Router.push({ name: 'Login' })
    }

    // when not allowed - 403
    if (error.response.status === StatusCodes.FORBIDDEN) {
      // push to error page
    }

    let message = error.message

    if (error.response.data) {
      message = error.response.data.message || 'Error'
    }

    toast.error(message)

    return Promise.reject(error)
  },
)

export default service
