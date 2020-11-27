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
            path: "/admin",
            component: importComponent('DashboardLayout'),
            children: [
                //Dashboard
                {
                    path: "/dashboard",
                    name: "Dashboard",
                    meta: { title: 'Dashboard', requiredAuth: true },
                    component: importComponent('Dashboard'),
                },
                // To do list
                {
                    path: "/peminjaman",
                    name: "Peminjaman",
                    meta: { title: 'Peminjaman', requiredAuth: true },
                    component: importComponent('Peminjaman'),
                },
                {
                    path: '/buku',
                    name: 'Buku',
                    meta: { title: 'Buku', requiredAuth: true },
                    component: importComponent('Buku'),
                },
                {
                    path: '/pegawai',
                    name: 'Pegawai',
                    meta: { title: 'Pegawai', requiredAuth: true },
                    component: importComponent('Pegawai'),
                },
                {
                    path: '/manajemen',
                    name: 'Manajemen Anggota',
                    meta: { title: 'Manajemen Anggota', requiredAuth: true },
                    component: importComponent('Anggota'),
                },
            ]
        },
        {
            path:'/',
            name: 'user',
            meta: { title: 'user' },
            component: importComponent('User/index'),
        },
        // Login
        {
            path: '/login',
            name: 'login',
            meta: { title: 'Login' },
            component: importComponent('Login'),
        },
        {
            path: '/profil',
            name: 'profil',
            meta: { title: 'Profil' },
            component: importComponent('User/profil'),
        },
        {
            path: '/katalog',
            name: 'katalog',
            meta: { title: 'Katalog' },
            component: importComponent('User/katalog'),
        },
        {
            path: '*',
            redirect: '/'
        },
    ]
});

// router.beforeEach((to, from, next) => {

//     if (to.matched.some(record => record.meta.requiredAuth)) {
//         if (localStorage.getItem('token')) {
//             //user is authenticated
//             next();
//         }
//         else {
//             //user is not authenticated
//             router.replace('/login')
//         }
//     } else {
//         next() // make sure to always call next()!
//         console.log('MASUK SINI')
//         console.log(to.matched.some(record => record.meta.requiredAuth))
//     }
// })

export default router;