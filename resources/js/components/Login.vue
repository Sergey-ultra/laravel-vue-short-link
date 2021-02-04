<template>
<div class="container w-1/4  flex justify-between m-auto">
    <form   class=" bg-white w-full my-8 p-4 border border-gray-300 rounded-md shadow-md" @submit.prevent="login">
        <h2 class="flex justify-center  text-xl font-semibold">Логин</h2>
        <span v-if="note" class="text-red-700"><strong>{{ note }}</strong></span>
        <div class="  mb-3">
            <label for="email" class="  text-md-right text-gray-500"> E-Mail </label>
            <div class="">
                <input
                    class="w-full h-8 px-2 border border-blue-500 rounded focus:ring-2 text-gray-500"
                    v-model.trim="email" id="email" name="email" type="email"

                >
                <span v-if="errors.email" class="text-red-700">{{ errors.email[0] }}</span>
            </div>
        </div>

        <div class="  mb-3">
            <label for="password" class="text-md-right text-gray-500"> Password </label>
            <div class="">
                <input v-model.trim="password" id="password" type="password"
                       class="w-full h-8 px-2 border border-blue-500 rounded focus:ring-2"
                       name="password" autocomplete="new-password">
                <span v-if="errors.password" class="text-red-700">{{ errors.password[0] }}</span>
            </div>
        </div>



        <div class="h-10 flex justify-between   my-5">
            <button  type="submit" class="flex items-center justify-center h-full bg-indigo-600 text-white hover:bg-indigo-700  rounded w-1/2   mr-2">Войти</button>
            <router-link to="/register" class="flex items-center justify-center h-full bg-green-400  text-white  hover:bg-green-500 rounded w-1/2   ml-2">Регистрация</router-link>
        </div>
    </form>
</div>
</template>

<script>
    export default {
        name: "Login",
        data(){
            return {
                email:'',
                password:'',
                errors:[],
                note:''
            }
        },
        methods:{
            async login(){
                let formData = new FormData()
                formData.append('email', this.email)
                formData.append('password', this.password)
                try {
                    const response = await axios.post('/api/login', formData)
                    if (response.data.status) {
                        this.email = ''
                        this.password = ''
                        localStorage.setItem('userData', JSON.stringify({
                            user_name: response.data.user_name,
                            token: response.data.token
                        }))
                        this.$emit('loginApp')
                    } else {
                        this.note = response.data.message
                    }
                } catch (error) {
                    this.errors = error.response.data.errors
                }
            }
        }
    }
</script>

<style scoped>

</style>
