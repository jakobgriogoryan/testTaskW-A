import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import ToDoList from "./components/ToDoList";
import CreateItem from "./components/CreateItem";
import EditItem from "./components/EditItem";

const routes = [
    {
        name: 'home',
        path: '/home',
        component: ToDoList
    },
    {
        name: 'home',
        path: '/',
        component: ToDoList
    },
    {
        name: 'create',
        path: '/create',
        component: CreateItem
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditItem
    }
]

export default new VueRouter({
    mode: "history",
    routes
})
