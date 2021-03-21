<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">ToDo List</router-link>
                    <router-link to="/create" class="nav-item nav-link">Create Item</router-link>
                </div>
            </div>
            <button type="button" class="btn btn-primary" @click="logout">Logout</button>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'App',
    methods: {
        logout() {
            axios.post('/logout')
                .then(response => {
                    this.$router.push("/login")
                    location.reload();
                }).catch(error => {
                location.reload();
            });
        }
    }
}
</script>
