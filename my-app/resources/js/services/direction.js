import request from "@/utils/request";

export function getDirectionDetail(id) {
    return request({
      url: "/direction/" + id,
      method: "get",
    });
}

export function getDirections(params) {
    return request({
        url: "/direction",
        method: "get",
        params: params,
    });
}

export function createDirection(data) {
    return request({
        headers: { "content-type": "multipart/form-data" },
        url: "/direction/create",
        method: "post",
        data: data,
    });
}

export function editDirection(id, data) {
    return request({
        url: "/direction/edit/" + id,
        method: "post",
        data: data,
    });
}
