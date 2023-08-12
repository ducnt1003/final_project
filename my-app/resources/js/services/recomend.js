import request from "@/utils/request";

export function recomend(id) {
    return request({
      url: "/recomend/" + id,
      method: "get",
    });
}

export function changeConfig(data) {
    return request({
      url: "/recomend/change-config",
      method: "post",
      data: data,
    });
}

export function getConfig() {
    return request({
      url: "/recomend/get-config",
      method: "post",
    });
}
