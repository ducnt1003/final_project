import request from "@/utils/request";

export function searchStudent(params) {
    return request({
      url: "/user/search-student",
      method: "get",
      params: params,
    });
}

export function getUsers(params) {
    return request({
      url: "/user",
      method: "get",
      params: params,
    });
}
