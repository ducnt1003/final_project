export const state = {
    user: {},
    student: {},
}

export const getters = {
    user:(state)=>state.user,
    student:(state)=>state.student,
}

export const mutations = {
    SET_USER(state,user){
        state.user = user
    },
    SET_STUDENT(state,student){
        state.student = student
    },
}

export const actions = {
    setUser({commit},data){
        commit('SET_USER',data.user);
        commit('SET_STUDENT',data.user.student);
    },
}