export default {
    state: () => ({
        sidebarVisible: '',
    }),
    getters: {
        sidebarVisible(state) {
            return state.sidebarVisible
        },
    },
    mutations: {
        toggleSidebar(state) {
            state.sidebarVisible = !state.sidebarVisible
        },
        updateSidebarVisible(state, payload) {
            state.sidebarVisible = payload.value
        },
    },
    actions: {
        toggleSidebar(context) {
            return context.commit('toggleSidebar')
        },
        updateSidebarVisible(context, payload) {
            return context.commit('updateSidebarVisible', {
                ...payload,
            })
        },
    },
}
