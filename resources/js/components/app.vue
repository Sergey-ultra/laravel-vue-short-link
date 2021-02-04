<template>
<div class="h-screen bg-gray-200">
    <nav class=" bg-green-300">
        <div   class="container lg flex justify-between m-auto h-12 items-center">
           <div class=" h-auto ">Сокращенные ссылки</div>
            <div v-if="isAuth" class="w-40 flex justify-between  h-full items-center">
                <div class="relative px-4 flex-1 h-full flex justify-center items-center   bg-green-400 hover:bg-green-500" @click="toggleLogout">
                    <svg class="mr-2" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" width=20 height=20 style="enable-background:new 0 0 20 20;" xml:space="preserve">
                            <g>
                                <path
                                    d="M256,0c-74.439,0-135,60.561-135,135s60.561,135,135,135s135-60.561,135-135S330.439,0,256,0z"/>
                                <path d="M423.966,358.195C387.006,320.667,338.009,300,286,300h-60c-52.008,0-101.006,20.667-137.966,58.195
                                C51.255,395.539,31,444.833,31,497c0,8.284,6.716,15,15,15h420c8.284,0,15-6.716,15-15
                                C481,444.833,460.745,395.539,423.966,358.195z"/>
                             </g>
                    </svg>
                    {{ userName }}
                    <div v-if="isShowLogout"
                         class="absolute top-full h-18 bg-white w-full px-6 mt-2 p-4 border border-gray-300 rounded-md shadow-md"
                    >
                        <router-link class=" flex-1 h-full flex items-center whitespace-nowrap hover:bg-green-400"
                                     to="/profile">Мой профиль
                        </router-link>
                        <div class=" hover:bg-green-400" @click="logout">Выйти</div>
                    </div>
                </div>
            </div>
            <div v-else class="w-1/7 flex justify-between  h-full items-center">
                <router-link class="px-3 flex-1 h-full flex items-center whitespace-nowrap hover:bg-green-500"
                                 to="/login">Логин
                </router-link>
                <router-link class="px-3 flex-1 h-full flex items-center whitespace-nowrap hover:bg-green-500"
                             to="/register">Регистрация
                </router-link>
            </div>
        </div>
    </nav>
    <div>
        <router-view :isAuth="isAuth" v-on:loginApp="loginApp"/>
    </div>
</div>
</template>

<script>
    export default {
        name: "app",
        data(){
            return {
                isAuth: '',
                userName:'',
                isShowLogout: false
            }
        },
        mounted(){
           this.getAuth()
        },
        methods: {
            getAuth(){
                const data = JSON.parse(localStorage.getItem('userData'))
                if(data){
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.token
                    this.userName = data.user_name
                    this.isAuth = true
                }
            },
            loginApp(){
                this.getAuth()
                this.$router.push('profile')
            },
            toggleLogout(){
               this.isShowLogout = !this.isShowLogout
            },
            async logout(){
                try {
                    const response = await axios.get('/api/logout')
                    if (response.data.status ){
                        this.$router.push('/login')
                        localStorage.removeItem('userData')
                        this.isAuth = false
                    }
                } catch (e){
                    throw e
                }
            }
        }
    }
</script>

<style scoped>


</style>
