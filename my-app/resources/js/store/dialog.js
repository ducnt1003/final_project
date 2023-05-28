import i18n from '../i18n/i18n'
const { t } = i18n.global

export default {
    state: () => ({
        dialogVisible: false,
        dialogContent: {
            message: t('common.confirmDeleteMessage'),
            callback: () => {},
            acceptColor: 'danger',
            acceptText: t('common.accept'),
            denyColor: 'light',
            denyText: t('common.deny'),
        },
    }),
    getters: {
        dialogVisible(state) {
            return state.dialogVisible
        },
        dialogContent(state) {
            return state.dialogContent
        },
    },
    mutations: {
        showDialog(state, payload) {
            state.dialogVisible = true
            state.dialogContent = {
                message: t('common.confirmDeleteMessage'),
                acceptColor: 'danger',
                acceptText: t('common.accept'),
                denyColor: 'light',
                denyText: t('common.deny'),
                ...payload,
            }
        },
        hideDialog(state) {
            state.dialogVisible = false
        },
    },
    actions: {
        showDialog(context, payload) {
            return context.commit('showDialog', payload)
        },
        hideDialog(context) {
            return context.commit('hideDialog')
        },
    },
}