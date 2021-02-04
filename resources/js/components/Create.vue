<template>
    <div class="container w-1/2  flex justify-between m-auto">
        <form
            class="bg-white w-full my-8 p-4 border border-gray-300 rounded-md shadow-md"
            @submit.prevent="createLink">
            <div>
                <label for="link">Введите ссылку</label>
                <div>
                    <input
                        v-model="link"
                        :class="[error ? 'border-red-700' : 'border-blue-500' ]"
                        class="mt-3 px-2 w-full h-8 border  rounded focus:ring-2 text-gray-500"
                        id="link"
                        type="text"
                        @input="clearError">
                    <span v-if="error" class="text-red-700 py-4">{{ error }}</span>
                </div>
            </div>
            <button
                class="bg-green-300 hover:bg-green-400 my-5  font-semibold w-1/5 h-10 px-3 flex-1  text-white  flex justify-center items-center rounded"
                type="submit">
                Создать
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data(){
            return {
                link:'',
                error:''
            }
        },
        methods:{
            clearError(){
                this.error = ''
            },
            async createLink(){
                try {
                    const response = await axios.post('/api/link/store', { link: this.link })
                    if (response.data.status){
                        this.link = ''
                        this.$router.push('profile')
                    } else {
                        this.error = response.data.message
                    }

                } catch(e){
                    throw e
                }

            }
        }
    }
</script>

<style scoped>

</style>
