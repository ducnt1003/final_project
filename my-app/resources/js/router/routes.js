import { h, resolveComponent } from "vue";
import i18n from "@/i18n/i18n";

const { t } = i18n.global;

const routes = [
    {
        /** Full page layout routes */
        path: "/",
        name: "Home",
        component: () => import("@/layouts/DefaultLayout.vue"),
        redirect: { name: "Dashboard" },
        meta: {
            title: t("home.title"),
        },
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: () => import("@/views/Dashboard.vue"),
                meta: {
                    title: "Dashboard",
                },
            },
            {
                path: "/courses",
                name: "Course",
                //   component: () => import('../views/course/CourseList.vue'),
                component: {
                    render() {
                        return h(resolveComponent("router-view"));
                    },
                },
                meta: {
                    title: "Khóa học",
                },
                redirect: { name: 'CourseList'},
                children: [
                    {
                        path: "",
                        name: "CourseList",
                        component: () =>
                            import("../views/course/CourseList.vue"),
                        meta: {
                            title: "Danh sách khóa học",
                        },
                    },
                    {
                        path: ":courseId",
                        name: "CourseDetail",
                        component: () =>
                            import("../views/course/CourseDetail.vue"),
                        meta: {
                            title: "Chi tiết khóa học",
                        },
                    },
                    {
                        path: "create",
                        name: "CourseCreate",
                        component: () =>
                            import("../views/course/CourseForm.vue"),
                        meta: {
                            title: "Tạo khóa học",
                        },
                    },
                    {
                        path: ":courseId/edit",
                        name: "CourseEdit",
                        component: () =>
                            import("../views/course/CourseForm.vue"),
                        meta: {
                            title: "Chỉnh sửa khóa học",
                        },
                    },
                    {
                        path: "upload/:courseId/:partId",
                        name: "CourseUpload",
                        component: () =>
                            import("../views/course/DocumentForm.vue"),
                        meta: {
                            title: "Upload tài liệu",
                        },
                    },
                ],
            },
            {
                path: "/categories",
                name: "Category",
                component: {
                    render() {
                        return h(resolveComponent("router-view"));
                    },
                },
                meta: {
                    title: "Danh mục",
                },
                redirect: { name: 'CategoryList'},
                children: [
                    {
                        path: "",
                        name: "CategoryList",
                        component: () => import("@/views/category/CategoryList.vue"),
                        meta: {
                            title: "Danh sách danh mục",
                        },
                    },
                    {
                        path: "create",
                        name: "CategoryCreate",
                        component: () => import("@/views/category/CategoryForm.vue"),
                        meta: {
                            title: "Tạo danh mục",
                        },
                    },
                    {
                        path: ":categoryId/edit",
                        name: "CategoryEdit",
                        component: () => import("@/views/category/CategoryForm.vue"),
                        meta: {
                            title: "Chỉnh sửa danh mục",
                        },
                    },
                ]
            },
            {
                path: "/directions",
                name: "Direction",
                //   component: () => import('../views/course/CourseList.vue'),
                component: {
                    render() {
                        return h(resolveComponent("router-view"));
                    },
                },
                meta: {
                    title: "Định hướng",
                },
                redirect: { name: 'DirectionList'},
                children: [
                    {
                        path: "",
                        name: "DirectionList",
                        component: () =>
                            import("../views/direction/DirectionList.vue"),
                        meta: {
                            title: "Danh sách định hướng",
                        },
                    },
                    {
                        path: "create",
                        name: "DirectionCreate",
                        component: () =>
                            import("../views/direction/DirectionForm.vue"),
                        meta: {
                            title: "Tạo định hướng",
                        },
                    },
                    {
                        path: "edit/:directionId",
                        name: "DirectionEdit",
                        component: () =>
                            import("../views/direction/DirectionForm.vue"),
                        meta: {
                            title: "Chỉnh sửa định hướng",
                        },
                    },
                    {
                        path: ":directionId",
                        name: "DirectionDetail",
                        component: () =>
                            import("../views/direction/DirectionDetail.vue"),
                        meta: {
                            title: "Chi tiết định hướng",
                        },
                    },
                ]
            },
            {
                path: "/users",
                name: "User",
                component: {
                    render() {
                        return h(resolveComponent("router-view"));
                    },
                },
                meta: {
                    title: "Người dùng",
                },
                redirect: { name: 'UserList'},
                children: [
                    {
                        path: "",
                        name: "UserList",
                        component: () => import("@/views/user/UserList.vue"),
                        meta: {
                            title: "Danh sách người dùng",
                        },
                    },
                    {
                        path: "create",
                        name: "UserCreate",
                        component: () => import("@/views/user/UserForm.vue"),
                        meta: {
                            title: "Tạo người dùng",
                        },
                    },
                ]
            },
            {
                path: "/similar",
                name: "Similar",
                component: () => import("@/views/similar/SimilarList.vue"),
                meta: {
                    title: "Khóa học gợi ý",
                },
            },
        ],
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("@/views/auth/Login.vue"),
        meta: {
            title: t("auth.login.title"),
        },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "Error",
        component: () => import("@/views/error/Error.vue"),
        meta: {
            title: t("errors.common.title"),
        },
    },
];

export default routes;
