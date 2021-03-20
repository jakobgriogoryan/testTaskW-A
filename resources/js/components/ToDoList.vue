<template>
    <div>
        <h2 class="text-center">ToDo List</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>Attachment</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.body }}</td>
                <td>{{ item.attachment }}</td>
                <td>{{ item.expiration_date }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: item.id }}" class="btn btn-success">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteProduct(item.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "ToDoList",
    data() {
        return {}
    },
    computed: {
        ...mapGetters([
            'items',
        ]),
    },
    async mounted() {
        await this.$store.dispatch('fetchItems');
    },
    methods: {
        async deleteProduct(id) {
            await this.$store.dispatch('removeItem', id);
        }
    }
}
</script>

<style scoped>

</style>
