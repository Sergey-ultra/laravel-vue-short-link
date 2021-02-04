import { createRouter, createWebHistory } from "vue-router";
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import Create from '../components/Create.vue'
import Profile from '../components/Profile.vue'

const history = createWebHistory()

const router =  createRouter({
    history,
    base: '/localhost',
    routes: [
        {path: '/login', name: 'Login', component: Login},
        {path: '/create', name: 'Create', component: Create},
        {path: '/register', name: 'Register', component: Register},
        {path: '/profile', name: 'Profile', component: Profile},
        {
            path:'/go/:code',
            beforeEnter: async (to, from, next) => {
                try {
                    console.log('redirect')
                    const response = await axios.post('/api/go', { short_link: to.path })
                    if (response.status == 200){
                        window.location.href = response.data
                        //next()
                    }
                } catch (e){
                    throw e
                }
            }
        }


    ],
})
let isAuth
if(JSON.parse(localStorage.getItem('userData'))){
     isAuth = true
}


router.beforeEach(async (to, from, next) => {
    if (to.name !== 'Login' && to.name !== 'Register' && !isAuth) next({name: 'Login'})
    else next()
})

export default router
