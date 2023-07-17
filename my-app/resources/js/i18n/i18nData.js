/********************************************
 *** File Name: i18nData.js               ***
 *** Description: i18n resource bundles   ***
 *** Creator: Cowell: Linh Huy Do      ***
 *** Created at: 2021/10/28               ***
 ********************************************/
export default {
  en: {},
  ja: {
    ERR_01: 'err_01',
    MSG01: 'messsage01',
  },
    vi: {
        "defaultTitle": "Asset Management",
        "common": {
          "filter": "Tìm kiếm",
          "advancedFilter": "Tìm kiếm mở rộng",
          "save": "Lưu",
          "send": "Gửi",
          "back": "Trở lại",
          "cancel": "Hủy bỏ",
          "accept": "Đồng ý",
          "deny": "Từ chối",
          "confirm": "Xác nhận",
          "display": "Hiển thị",
          "search": "Tìm kiếm",
          "resetFilter": "Bỏ lọc",
          "employee": "Nhân viên",
          "employeeId": "Mã nhân viên",
          "name": "Tên",
          "fullName": "Họ Tên",
          "unit": "Bộ phận",
          "position": "Vị trí",
          "status": "Trạng thái",
          "type": "Loại",
          "description": "Mô tả",
          "descriptionDevice": "Mô tả thiết bị",
          "descriptionRequest": "Mô tả yêu cầu",
          "reply": "Phản hồi",
          "comment": "Bình luận",
          "index": "STT",
          "actions": "Thao tác",
          "loading": "Đang tải...",
          "noData": "Không tìm thấy dữ liệu",
          "id": "ID",
          "quantity": "Số lượng",
          "createdDate": "Ngày tạo",
          "creator": "Người yêu cầu",
          "report": "Người báo cáo",
          "asset": "Tài sản",
          "device": "Thiết bị",
          "unavailable": "Không có",
          "errorMessage": "Có lỗi xảy ra",
          "successMessage": "Thành công",
          "confirmDeleteMessage": "Xác nhận xóa?",
          "deleteSuccessMessage": "Xóa thành công",
          "addSuccessMessage": "Thêm thành công",
          "editSuccessMessage": "Sửa thành công",
          "changeRoleSuccessMessage": "Cập nhật quyền thành công",
          "petitioner": "Người yêu cầu",
          "confirmSaveMessage": "Xác nhận lưu ?",
          "confirmCancelMessage": "Xác nhận hủy ?",
          "confirmDenyMessage": "Xác nhận từ chối ?",
          "confirmMessage": "Xác nhận toàn bộ thông tin ?",
          "confirmDeleteRoleAdmin": "Xác nhận bỏ quyền Admin của ",
          "confirmAddRoleAdmin": "Xác nhận cung cấp quyền Admin cho ",
          "newMessage": "New",
          "editMessage": "Edit",
          "searchDevice": "Tìm kiếm thiết bị ",
        },
        "home": {
          "title": "Trang chủ"
        },
        "dashboard": {
          "title": "Dashboard",
          "totalDevices": "Tổng số thiết bị",
          "totalRequests": "Tổng số yêu cầu",
          "totalHandovers": "Tổng số bàn giao",
          "totalUsers": "Tổng số người dùng",
          "requiredReportDevices": "Tài sản cần kiểm kê",
          "deviceCondition": "Tình trạng tài sản Thiết bị",
          "deviceAvailable": "Tình trạng lưu kho Thiết bị",
          "deviceCategory": "Phân loại Thiết bị",
          "requestStatus": "Trạng thái Yêu cầu",
          "handoverStatus": "Trạng thái Bàn giao",
        },
        "auth": {
          "common": {
            "username": "Tên đăng nhập",
            "email": "Email",
            "password": "Mật khẩu",
            "login": "Đăng nhập"
          },
          "login": {
            "title": "Đăng nhập"
          },
          "authentication": {
            "code": "Code xác thực",
            "title": "Xác thực hai lớp",
            "vertify": "Xác nhận",
            "instruction": "Mở ứng dụng xác thực hai lớp trên thiết bị của bạn để xem mã xác thực và xác minh danh tính của bạn"
          },
          "authenticationRegister": {
            "title": "Cài đặt xác thực hai lớp",
            "register": "Hoàn tất đăng ký",
            "headText1": "Cài đặt xác thực hai lớp bằng cách quét mã QRcode bên dưới với ứng dụng xác thực của bạn",
            "headText2": "Cách khác, bạn có thể sử dụng code",
            "headText3": "Nhập mã",
            "headText4": "được tạo trên ứng dụng xác thực trên điện thoại của bạn. Nếu không, bạn sẽ không thể đăng nhập được."
          },
          "twoFactorAuthentication": {
            "code": "Mã xác thực",
            "title": "Xác thực hai lớp",
            "vertify": "Xác nhận",
            "instruction": "Mã xác thực đã được gửi tới email của bạn, vui lòng sử dụng để đăng nhập",
            "resendSuccess": "Đã gửi email mã xác thực thành công",
            "labelRemember": "Ghi nhớ thiết bị này",
            "resendMail": "Gửi lại mã xác thực",
          },
        },
        "devices": {
          "title": "Thiết bị",
          "common": {
              "return": "Thu hồi thiết bị",
              "select": "Lựa chọn thiết bị",
              "reportError": "Báo cáo hỏng",
              "categoryName": "Tên danh mục",
              "displayedProperties": "Thông số hiển thị",
              "addProperty": "Thêm thông số",
              "addOption": "Thêm lựa chọn",
              "nameProperty": "Tên thông số",
              "condition": "Tình trạng tài sản",
              "name": "Tên",
              "code": "Mã",
              "type": "Loại tài sản",
              "add": "Thêm thiết bị",
              "user": "Người sử dụng",
              "assetCondition": "Tình trạng tài sản",
              "assetStatus": "Lưu kho",
              "supplier": "Nhà cung cấp",
              "branch": "Chi nhánh",
              "bill": "Hóa đơn",
              "price": "Giá trị (VND)",
              "value": "Giá trị",
              "provide": "Cung cấp thiết bị",
              "export" : "Xuất file excel",
              "displayedRequirements": "Yêu cầu cài đặt",
              "addRequirements": "Thêm yêu cầu",
              "nameRequirement": "Tên yêu cầu",
              "addSetup": "Cài đặt thêm",
              "quantity": "Số lượng thiết bị",
              "addSimilar": "Thêm tương tự",
              "propertyDisplay": "Hiển thị thông số",
          },
          "category": {
            "title": "Danh mục",
            "list": "Danh sách danh mục",
            "searchPlaceholder": "Tìm kiếm danh mục",
            "addCategoryError": "Danh mục đã tồn tại",
            "type": {
              "name": "Loại thông số",
              "title": "Danh sách lựa chọn",
              "text": "Văn bản",
              "option": "Lựa chọn",
              "propertyError": "Danh sách lựa chọn đang trống",
            }
          },
          "provide": {
              "title": "Cung cấp thiết bị",
              "selectReceiver": "Chọn người nhận",
              "provideAnotherDevice": "Thêm thiết bị khác"
          },
          "action" :{
              "create" : "Thêm thành công ",
              "edit" : "Sửa thành công ",
              "assign" : "Cấp thiết bị thành công ",
              "returnSuccessMessage" : "Thu hồi thiết bị thành công ",
          },
          "status": {
            "new" : "Mới",
            "normal" : "Bình thường",
            "broken" : "Hỏng",
            "maintain" : "Bảo hành",
            "server" : "Server",
            "liquidated" : "Thanh lý",
            "lost" : "Mất",
          },
          "assignStatus": {
              "have" : "Còn",
              "end" : "Không",
              "occupied": "Đang sử dụng",
              "maintain" : "Bảo hành",
              "providing" : "Đang cung cấp",
              "returning" : "Đang thu hồi",
              "wait_process": "Chờ xử lý",
          },
          "list": {
              "title": "Danh sách thiết bị"
          },
          "add": {
            "title": "Thêm thiết bị",
            "errorAddProperty": "Đã tồn tại thông số",
            "errorAddRequied": "Đã tồn tại yêu cầu",
            "errorAddOption": "Đã tồn tại giá trị",
          },
          "edit": {
              "title": "Sửa thông tin thiết bị"
          },
          "detail": {
              "title": "Thông tin chi tiết thiết bị",
              "generalInfo": "Thông tin chung",
              "propertyInfo": "Thông số kỹ thuật",
              "historyInfo": "Lịch sử",
              "edit": "Sửa",
              "delete": "Xóa",
              "updateHistoryButton": "Lịch sử cập nhật",
              "updateHistory": "Lịch sử cập nhật thông số",
              "warrantyHistory": "Lịch sử bảo hành",
              "useHistory": "Lịch sử sử dụng",
              "parentDevice": "Tài sản cha",
              "price": "Giá trị",
              "providedDate": "Ngày cấp",
              "returnedDate": "Ngày trả",
              "warrantyDate": "Ngày bảo hành",
              "updatedDate": "Ngày cập nhật",
              "oldSpecs": "Thông số cũ",
              "newSpecs": "Thông số mới",
              "showQrcode": "Tạo QR Code",
              "downloadQrcode": "Tải QR Code"
          },
          "maintainHistory": {
              "title": "Lịch sử bảo hành"
          },
          "useHistory": {
              "title": "Lịch sử sử dụng"
          },
          "return": {
              "title": "Thu hồi thiết bị",
              "deviceDetail": "Chi tiết thiết bị",
              "isRetired": "Nghỉ việc",
          },
          "addCategory": {
              "title": "Thêm danh mục"
          },
          "editCategory": {
              "title": "Sửa danh mục"
          }
        },
        "requests": {
          "title": "Yêu cầu",
          "list": {
            "title": "Danh sách yêu cầu"
          },
          "detail": {
            "title": "Chi tiết yêu cầu",
            "manager": "Quản lý",
            "managerReply": "Phản hồi từ quản lý",
            "approver": "Người duyệt",
            "approverReply": "Phản hồi từ người duyệt",
            "handler": "Người xử lý",
            "handlerReply": "Phản hồi từ người xử lý",
            "process": "Xử lý",
            "selectDevice": "Lựa chọn Thiết bị",
            "deviceDetail": "Chi tiết thiết bị",
            "deviceRequirement": "Thiết bị mong muốn",
            "deviceProvide": "Thiết bị cung cấp",
            "deviceReturn": "Thiết bị thu hồi",
            "detailLabel": "Chi tiết",
            "detailHandover": "Chi tiết bàn giao",
          },
          "create": {
            "title": "Tạo yêu cầu",
            "successMessage": "Tạo yêu cầu thành công"
          },
          "process": {
            "title": "Xử lý yêu cầu",
            "request": "Yêu cầu",
            "replaceDevice": "Thay thế thiết bị",
            "newDevice": "Cấp thiết bị mới",
            "replaceComponent": "Thay thế linh kiện",
            "deviceDetail": "Chi tiết thiết bị",
            "selectReplacedDevice": "Lựa chọn Thiết bị",
            "selectComponent": "Lựa chọn Linh kiện",
            "selectReplacedComponent": "Linh kiện thay thế",
            "selectNewComponent": "Lựa chọn Linh kiện mới",
            "replacedDeviceDetail": "Chi tiết thiết bị",
            "parentDevice": "Thiết bị cha",
            "childrenDevice": "Thiết bị kèm theo",
            "generalInfo": "Thông tin chung",
            "specification": "Thông số",
            "placeHolder": "Nhập tên thiết bị muốn tìm kiếm...",
          },
          "acceptRequest": {
            "successMessage": "Xác nhận yêu cầu thành công",
          },
          "handleRequest": {
            "successMessage": "Xử lý yêu cầu thành công",
          },
          "provide": {
            "successMessage": "Cấp thiết bị mới thành công",
          },
          "replaceDevice": {
            "successMessage": "Thay thế thiết bị mới thành công",
          },
          "replaceComponent": {
            "successMessage": "Thay thế linh kiện thành công",
          },
          "status": {
            "pending": "Chờ duyệt",
            "approved": "Đã duyệt - Chờ xử lý",
            "denied": "Từ chối",
            "completed": "Đã xử lý",
            "itDenied": "IT từ chối"
          },
          "type": {
            "provide_device": "Cung cấp thiết bị",
            "replace_component": "Đổi linh kiện",
            "replace_device": "Đổi thiết bị"
          }
        },
        "handovers": {
          "title": "Bàn giao",
          "list": {
            "title": "Danh sách bàn giao tài sản"
          },
          "detail": {
            "title": "Bàn giao tài sản",
            "print": "In biên bản",
            "generalInfo": "Thông tin chung",
            "creator": "Người tạo",
            "request": "Chi tiết yêu cầu",
            "provide": "Cung cấp",
            "return": "Thu hồi",
            "replaceComponent": "Thay thế linh kiện",
            "handoverContent": "Nội dung bàn giao",
            "info": "Thông tin",
            "component": "Linh kiện",
            "oldSpec": "Thông số cũ",
            "newSpec": "Thông số mới",
            "clickToConfirmText": "Bằng cách nhấp vào nút \"Xác nhận\" dưới đây, Người dùng đã xác nhận tất cả nội dung thông tin bàn giao tài sản ở trên là hoàn toàn chính xác.",
            "editDocument": "Sửa biên bản",
            "documentContent": "Nội dung biên bản",
            "documentNote": "Ghi chú",
            "addDocumentNote": "Thêm ghi chú",
            "editDocumentNote": "Sửa ghi chú",
            "installedPrograms": "Các phần mềm cài đặt",
            "addInstalledProgram": "Thêm phần mềm cài đặt",
          },
          "common": {
            "user": "Đối tượng bàn giao",
            "id": "Mã",
          },
          "status": {
            "pending": "Chờ xác nhận",
            "canceled": "Hủy",
            "denied": "Từ chối",
            "confirmed": "Đã xác nhận"
          },
          "type": {
            "provide_device": "Cung cấp thiết bị",
            "replace_component": "Đổi linh kiện",
            "replace_device": "Đổi thiết bị",
            "return_device": "Thu hồi thiết bị"
          }
        },
        "users": {
          "title": "Người dùng",
          "processType": "Lưu với quyền SuperAdmin",
          "detail": {
            "title": "Chi tiết"
          },
          "common": {
            "id": "Mã nhân viên",
            "fullname": "Họ Tên",
            "email": "Địa chỉ Email",
            "phone": "Số điện thoại",
            "unit": "Bộ phận",
            "addRoleAdmin": "Thêm quyền Admin",
            "deleteRoleAdmin": "Bỏ quyền Admin",
            "position": "Vị trí",
            "manager": "Quản lý",
            "joinedDate": "Ngày gia nhập",
            "role": "Vai trò",
          },
          "tabs": {
            "info": "Thông tin",
            "devices": "Thiết bị",
            "requests": "Yêu cầu"
          },
          "list": {
            "title": "Danh sách người dùng"
          },
          "info": {
            "title": "Chi tiết (Thông tin người dùng)"
          },
          "devices": {
            "title": "Chi tiết (Danh sách thiết bị)",
            "code": "Mã",
            "name": "Tên",
            "category": "Loại",
            "providedDate": "Ngày cấp",
            "returnedDate": "Ngày trả (Dự kiến)",
            "condition": "Tình trạng",
            "state": "Trạng thái"
          },
          "requests": {
            "title": "Chi tiết (Danh sách yêu cầu)",
            "type": "Loại",
            "status": "Trạng thái",
            "new": "Tạo yêu cầu"
          },
          "role": {
            "admin": "Admin",
            "manager": "Manager",
            "it": "IT",
            "employee": "Employee",
            "superAdmin": "SuperAdmin",
          },
          "unit": {
            "es11": "ES1-1",
            "es12": "ES1-2",
            "es21": "ES2-1",
            "es22": "ES2-2",
            "dn": "DN",
            "gecd": "GECD",
            "ss": "SS",
            "bo": "BO",
            'qs': "QS"
          }
        },
        "reports": {
          "title": "Báo cáo",
          "errors": {
            "title": "Báo cáo hỏng",
            "create":{
              "successMessage": "Tạo báo cáo hỏng thành công"
            },
            "creator": "Người báo cáo",
            "list": {
              "title": "Danh sách báo cáo hỏng"
            },
            "detail": {
              "title": "Báo cáo hỏng",
              "detail": "Chi tiết báo cáo",
              "confirmCondition": "Xác nhận tình trạng",
              "reply": "Phản hồi từ IT"
            },
            "status": {
              "pending": "Chờ kiểm duyệt",
              "confirmed": "Đã xác nhận",
              "denied": "Từ chối",
            }
          },
          "inventories": {
            "title": "Báo cáo kiểm kê",
            "common": {
                "create": "Tạo kiểm kê",
                "edit": "Sửa",
                "startedDate": "Ngày bắt đầu",
                "endedDate": "Ngày kết thúc",
                "name": "Tên kì kiểm kê",
                "status": "Trạng thái",
                "total": "Tổng tài sản đã kiểm kê",
                "total_asset" : "Tổng số tài sản",
            },
            "status": {
              "none": "Chưa kiểm kê",
              "done": "Đã kiểm kê",
              "confirmed": "Đã xác nhận",
              "refused": "Từ chối",
              "constant": "Không có thay đổi",
              "change": "Có thay đổi"
            },
            "periodList": {
                "title": "Danh sách kì kiểm kê"
            },
            "addPeriod": {
                "title": "Tạo kì kiểm kê"
            },
            "editPeriod": {
              "title": "Sửa kì kiểm kê"
            },
            "list": {
                "title": "Danh sách kiểm kê"
            },
            "form": {
                "title": "Báo cáo kiểm kê"
            },
            "periodDetail": {
                "staffID": "Mã NV",
                "name": "Họ tên",
                "user": "Người sử dụng",
                "createdDate": "Ngày tạo",
                "updatedDate": "Ngày cập nhật",
                "assetNumbers": "Số tài sản",
                "status": "Trạng thái",
                "owner": "Người tạo",
                "unit": "Bộ phận",
                "change_status": "Trạng thái tài sản kiểm kê",
                "total_change": "Số tài sản thay đổi"
            },
            "detail": {
                "title": "Báo cáo kiểm kê",
                "userInfo": "Thông tin người nhập",
                "assetNumbers": "Số tài sản",
                "assetStatus": "Trạng thái tài sản"
            }
          }
        },
        "sidebar": {
          "dashboard": "Dashboard",
          "devices": "Thiết bị",
          "courses" : "Khóa học",
          "categories" : "Danh mục",
          "requests": "Yêu cầu",
          "handovers": "Bàn giao",
          "users": "Người dùng",
          "reports": "Báo cáo",
          "inventoryReports": "Báo cáo kiểm kê",
          "errorReports": "Báo cáo hỏng"
        },
        "dropdown": {
          "greeting": "Xin chào",
          "info": "Thông tin cá nhân",
          "devices": "Thiết bị",
          "requests": "Yêu cầu",
          "notifications": "Xem tất cả thông báo",
          "logout": "Đăng xuất"
        },
        "validate": {
          "common": {
            "required": "Đang bỏ trống.",
            "taken": "Đã tồn tại",
            "min": "Dưới tối thiểu.",
            "max": "Vượt tối đa.",
            "max250": "Nhập tối đa 250 kí tự ",
            "integer": "Chỉ nhận số nguyên.",
            "positive": "Chỉ nhận số dương.",
            "notValid": "Không hợp lệ.",
            "maxString": "Nhập tối đa 50 kí tự",
            "maxStringValue": "Nhập tối đa 250 kí tự",
            "maxStringName": "Nhập tối đa 100 kí tự",
            "number": "Vui lòng nhập số",
            "minValueQuantity": "Số lượng phải lớn hơn 0",
            "numberMax": "Vui lòng nhập số nhỏ hơn 1 000 000 000 000",
            "quantityMax": "Vui lòng nhập số nhỏ hơn 1000",
            "maxWord": "Nhập tối đa 30 chữ cái trong một từ",
            "maxStringInstall": "Nhập tối đa 35 kí tự",
            "maxStringNote": "Nhập tối đa 1000 kí tự",
            'requiredRequest': "Cần nhập lý do từ chối",
          },
          "username": {
            "required": "Tên đăng nhập đang bỏ trống."
          },
          "email": {
            "required": "Email đang bỏ trống.",
            "notValid": "Email không hợp lệ"
          },
          "password": {
            "required": "Mật khẩu đang bỏ trống.",
            "min": "Mật khẩu phải ít nhất 8 kí tự."
          },
          "properties": {
            "min": "Cần ít nhất một Thông số kĩ thuật."
          },
          "selectedDevices": {
            "min": "Cần lựa chọn ít nhất một thiết bị."
          },
          "authentication":{
            "required": "Mã xác thực đang bỏ trống",
            "min": "Code tối thiểu 6 kí tự"
          }
        },
        "notifications": {
          "title": "Tất cả thông báo",
          "common": {
            "read": "Đánh dấu tất cả đã đọc",
          },
          "type": {
            "request": "Yêu cầu",
            "tranfer": "Bàn giao",
            "report": "Báo cáo kiểm kê",
            "incident": "Báo cáo hỏng",
          }
        },
        "errors": {
          "common": {
            "title": "Lỗi",
            "toHome": "Trở về trang chủ"
          },
          "400": {
            "code": "400",
            "name": "Bad Request",
            "description": ""
          },
          "401": {
            "code": "401",
            "name": "Unauthorized",
            "description": ""
          },
          "403": {
            "code": "403",
            "name": "Forbidden",
            "description": ""
          },
          "404": {
            "code": "404",
            "name": "Not Found",
            "description": "Trang web không tồn tại."
          },
          "500": {
            "code": "500",
            "name": "Internal Server Error",
            "description": ""
          },
          "503": {
            "code": "503",
            "name": "Service Unavailable",
            "description": ""
          }
        }
      }
}
