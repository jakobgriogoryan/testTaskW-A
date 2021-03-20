<template>
    <div>
        <h3 class="text-center">Edit ToDo Item</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateItem">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="item.title" name="title">
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <input type="text" class="form-control" v-model="item.body" name="body">
                    </div>
                    <div class="form-group">
                        <label>Attachment</label>
                        <input type="file" class="form-control" name="attachment"
                               @change="handleFileUpload($event.target.files)"/>
                    </div>
                    <div class="form-group">
                        <label>Expiration date</label>
                        <input type="date" class="form-control" v-model="item.expiration_date" name="expiration_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "EditItem",
    data() {
        return {
            //
        }
    },
    computed: {
        ...mapGetters([
            'item',
        ]),
    },
    async created() {
        await this.$store.dispatch('fetchItem', this.$route.params.id);
    },
    methods: {
        async updateItem() {
            const formData = new FormData();
            formData.append('title', this.item.title);
            formData.append('body', this.item.body);
            formData.append('attachment', this.item.attachment);
            formData.append('expiration_date', this.item.expiration_date);
            formData.append("_method", "put");

            try {
                await this.$store.dispatch('updateItem', [this.$route.params.id, formData]);
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
