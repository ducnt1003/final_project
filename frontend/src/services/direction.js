import request from '@/utils/request'

export function getDirections(params) {
    return request({
        url: "/direction",
        method: "get",
        params: params,
    });
}