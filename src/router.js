import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

function importComponent(path) {
    return () => import(`./components/${path}.vue`)
}

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: importComponent('DashboardLayout'),
            children: [
                //Dashboard
                {
                    path: "/",
                    name: "Root",
                    component: importComponent('Dashboard'),
                },
                // To do list
                {
                    path: "/gd",
                    name: "Guided",
                    component: importComponent('TodoList/List'),
                },
                {
                    path: "/UGD",
                    name: "UGD",
                    component: importComponent('TodoList/ListUGD'),
                },
                {
                    path: "/Tugas",
                    name: "Tugas",
                    component: importComponent('TodoList/ListTugas'),
                },
            ]
        },
    ]
});

export default router;