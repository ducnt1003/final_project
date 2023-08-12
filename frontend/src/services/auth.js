import request from '@/utils/request'

export function register(data) {
    return request({
      url: '/auth/register',
      method: 'post',
      data: data,
    })
  }

export function login(data) {
  return request({
    url: '/auth/login',
    method: 'post',
    data: data,
  })
}

export function me() {
  return request({
    url: '/auth/me',
    method: 'post',
  })
}

export function log_out() {
  return request({
    url: '/auth/logout',
    method: 'post',
  })
}