<template>
    <div class="container-fluid">
        <div class="row">
            <h3 class="text-center">Edit ToDo Item</h3>
            <div class="col-10 mx-auto">
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
                        <p>Attachment </p>
                        <label v-if="item.attachment">Downloaded: {{ item.attachment }}</label>
                        <img :src="item.attachment_path" alt="" height="95px" width="95px" class="img-attachment">
                        <input type="file" class="form-control" name="attachment"
                               @change="handleFileUpload($event.target.files)"/>
                    </div>
                    <div class="form-group">
                        <label>Expiration date</label>
                        <input type="datetime-local" class="form-control" v-model="item.expiration_date"
                               name="expiration_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import moment from 'moment';

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
    async mounted() {
        await this.$store.dispatch('fetchItem', this.$route.params.id);
        let dateTime = moment(this.item.expiration_date).format()
        dateTime = dateTime.slice(0, 16)
        this.item.expiration_date = dateTime
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
.img-attachment {
    border-radius: 5px;
    margin: 10px;
    margin-top: unset;
}
</style>
