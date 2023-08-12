import request from '@/utils/request'

export function getCategories(params) {
  return request({
    url: '/category',
    method: 'get',
    params: params,
  })
}

export function getCategory(id) {
    return request({
      url: '/category/' + id,
      method: 'get',
    })
  }

export function createCategory(data) {
    return request({
      url: '/category/create',
      method: 'post',
      data: data,
    })
  }

  export function editCategory(id, data) {
    return request({
      url: '/category/edit/' + id,
      method: 'put',
      data: data,
    })
  }

  export function deleteCategory(id) {
    return request({
      url: '/category/delete/' + id,
      method: 'delete',
    })
  }
