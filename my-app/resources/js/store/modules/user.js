export const state = {
  selectedUser: {},
  isGettingUser: false,
};

export const getters = {
  selectedUser: (state) => state.selectedUser,
  isGettingUser: (state) => state.isGettingUser,
};

export const mutations = {
  SET_SELECTED_USER(state, user) {
    state.selectedUser = user;
  },
  SET_IS_GETTING_USER(state, status) {
    state.isGettingUser = status;
  },
};

export const actions = {
  setSelectedUser({ commit }, user) {
    commit("SET_SELECTED_USER", user);
  },
  setIsGettingUser({ commit }, payload) {
    commit("SET_IS_GETTING_USER", payload);
  },
};
