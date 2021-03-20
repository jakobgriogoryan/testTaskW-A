<template>
    <div>
        <h3 class="text-center">Create ToDo item</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addItem">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" v-model="item.title">
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <input type="text" class="form-control" name="body" v-model="item.body">
                    </div>
                    <div class="form-group">
                        <label>Upload an attachment</label>
                        <input type="file" class="form-control" name="attachment"
                               @change="handleFileUpload($event.target.files)"/>
                    </div>
                    <div class="form-group">
                        <label>Expiration date</label>
                        <input type="date" class="form-control" name="expiration_date" v-model="item.expiration_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "CreateItem.vue",
    data() {
        return {
            item: {
                title: '',
                body: '',
                attachment: '',
                expiration_date: ''
            },
        }
    },
    computed: {
        ...mapGetters([
            'items',
        ]),
    },
    methods: {
        async addItem() {
            const formData = new FormData();
            formData.append('title', this.item.title);
            formData.append('body', this.item.body);
            formData.append('attachment', this.item.attachment);
            formData.append('expiration_date', this.item.expiration_date);

            try {
                await this.$store.dispatch('storeItem', formData);
                await this.$router.push({name: 'home'})
            } catch (e) {
                console.log(e)
            }

        },
        handleFileUpload(fileList) {
            this.item.attachment = fileList[0];
        }
    }
}
</script>

<style scoped>

</style>
