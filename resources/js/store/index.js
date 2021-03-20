import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        item: {},
        items: [],
    },
    mutations: {
        FETCH_ITEMS(state, items) {
            return state.items = items
        },
        ADD_ITEM(state, item) {
            state.items.push(item.item);
        },
        SET_ITEM(state, item) {
            state.item = item;
        },
        UPDATE_ITEM(state, item) {
            // state.items = state.items.map((singleItem) => {
            //     return (item.id === singleItem.id) ? item : singleItem;
            // });
        },
        REMOVE_ITEM(state, item) {
            let index = state.items.findIndex(data => data.id == item)
            state.items.splice(index, 1);
        },
    },
    getters: {
        items: (state) => state.items,
        item: (state) => state.item,
    },
    actions: {
        async fetchItems({commit}) {
            await axios
                .get('api/items/')
                .then(response => {
                    commit('FETCH_ITEMS', response.data)
                })
                .catch(err => {
                    console.log(err)
                });
        },
        async fetchItem({commit}, payload) {
            await axios
                .get(`/api/items/${payload}`)
                .then((response) => {
                    commit('SET_ITEM', response.data)
                });
        },
        async storeItem({commit}, payload) {
            await axios
                .post('/api/items', payload)
                .then(response => (
                    commit('ADD_ITEM', response.data)
                ))
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },
        async updateItem({commit}, payload) {
            await axios
                .post(`/api/items/${payload[0]}`, payload[1])
                .then((response) => {
                    commit('UPDATE_ITEM', response);
                });
        },
        async removeItem({commit}, id) {
            await axios
                .delete(`api/items/${id}`)
                .then(response => {
                    commit('REMOVE_ITEM', id)
                });
        }

    }
})
