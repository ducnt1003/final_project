import request from '@/utils/request'

export function getDirections(params) {
    return request({
        url: "/direction",
        method: "get",
        params: params,
    });
}

export function selectDirection(data) {
    return request({
      url: '/direction/select',
      method: 'post',
      data: data,
    })
  }

  export function selectedDirection() {
    return request({
      url: '/direction/selected',
      method: 'post',
    })
  }
