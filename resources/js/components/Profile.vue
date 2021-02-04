<template>
<div class="container w-1/2  flex justify-between m-auto">
        <div   class="bg-white w-full my-8 p-4 border border-gray-300 rounded-md shadow-md">
            <router-link class="bg-green-300 hover:bg-green-400 my-5 float-right font-semibold w-1/5 h-10 px-3 flex-1  text-white  flex justify-center items-center rounded"
                         to="/create">Создать ссылку
            </router-link>
            <table class="w-full ">
                <thead class="">
                    <tr>
                        <th>№</th>
                        <th>Оригинальная ссылка</th>
                        <th>Сокращенная ссылка</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(link, index) in links" :key="index" class="h-12 border-b font-light hover:bg-green-200">
                        <Link :link="link" :index="index"  v-on:itemchanged="getList"  />
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import Link from './Link'
    export default {
        name: "Profile",
        components: {
            Link
        },
        data(){
            return{
                links:{

                }
            }
        },
         mounted(){
             this.getList()
        },
        methods:{
            async getList(){
                try {
                    const response = await axios.get('api/links')
                    this.links = response.data.data
                } catch (e) {
                    throw e
                }

            }
        }
    }
</script>

<style scoped>

</style>
