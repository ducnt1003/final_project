import request from "@/utils/request";

export function getCourseDetail(id) {
    return request({
      url: "/course/" + id,
      method: "get",
    });
}

export function getCourses(params) {
    return request({
        url: "/course",
        method: "get",
        params: params,
    });
}

export function createCourse(data) {
    return request({
        headers: { "content-type": "multipart/form-data" },
        url: "/course/create",
        method: "post",
        data: data,
    });
}

export function editCourse(id, data) {
    return request({
        url: "/course/edit/" + id,
        method: "put",
        data: data,
    });
}

export function deleteCourse(id) {
    return request({
        url: "/course/delete/" + id,
        method: "delete",
    });
}
