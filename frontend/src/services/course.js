import request from '@/utils/request'

export function getCourses(params) {
    return request({
        url: "/course",
        method: "get",
        params: params,
    });
}

export function getCourseDetail(id) {
    return request({
        url: "/course/"+id,
        method: "get",
    });
}

export function recomend(id) {
    return request({
        url: "/recomend/"+id,
        method: "get",
    });
}

export function enroll(data) {
    return request({
      url: '/enroll/enroll',
      method: 'post',
      data: data,
    })
}

export function isEnroll(data) {
    return request({
      url: '/enroll/is_enrolled',
      method: 'post',
      data: data,
    })
}

