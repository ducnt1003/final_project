export const state = {
    user: {},
    role: '',
}

export const getters = {
    user:(state)=>state.user,
    role:(state)=>state.role,
}

export const mutations = {
    SET_USER(state,user){
        state.user = user
    },
    SET_ROLE(state,role){
        state.role = role
    },
}

export const actions = {
    setUser({commit},data){
        commit('SET_USER',data.user);
        commit('SET_ROLE',data.user.role_id);
    },
}
