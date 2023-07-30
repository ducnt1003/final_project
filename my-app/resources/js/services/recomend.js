import request from "@/utils/request";

export function recomend(id) {
    return request({
      url: "/recomend/" + id,
      method: "get",
    });
}
