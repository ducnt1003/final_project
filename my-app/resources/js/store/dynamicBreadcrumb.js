export default {
    state: () => ({
      dynamicBreadcrumbs: [],
    }),
    getters: {
      dynamicBreadcrumbs(state) {
        return Object.values(state.dynamicBreadcrumbs)
      },
    },
    mutations: {
      addDynamicBreadcrumbs(state, payload) {
        state.dynamicBreadcrumbs.push(payload)
      },
      cleanDynamicBreadcrumbs(state) {
        state.dynamicBreadcrumbs = []
      },
    },
    actions: {
      addDynamicBreadcrumbs(context, payload) {
        return context.commit('addDynamicBreadcrumbs', payload)
      },
      cleanDynamicBreadcrumbs(context) {
        return context.commit('cleanDynamicBreadcrumbs')
      },
    },
  }