<template>
    <div class="showMainLayout ? 'layout' : ''">
        <AuthHeader v-if="showHeader"/>

        <aside v-if="showMainLayout">
            <SideNav/>
        </aside>
        <main>
            <Message v-if="showMainLayout"/>
            <Nuxt/>
        </main>
    </div>
    
</template>

<script>
import AuthHeader from '~/components/AuthHeader.vue'
import SideNav from '~/components/SideNav.vue'
import Message from '~/components/Message.vue'
import { onAuthStateChanged } from 'firebase/auth'

export default {
    components: {
        AuthHeader,
        SideNav,
        Message

    },
    data() {
        return  {
            currentUser: null
        }
    },
    computed: {
        showHeader() {
            const route = this.$route.path
            return route === '/login' || route === '/register'
        },
        showMainLayout() {
            const route = this.$route.path
            return route === '/' || route.startsWith('/post/')
        }
    },
    mounted() {
        onAuthStateChanged(this.$firebaseAuth,(user) => {
            if (user) {
                this.currentUser = user
                console.log("ログイン中のユーザー:", user)
            } else {
                this.currentUser = null
                console.log("ログアウト中") 
            }
        })
    }
}
</script>
<style scoped>
    .layout {
    display: flex;
    height: 100vh;
    }
   /* main {
       flex:1;
       padding: 1.5rem; 
    }
    */
</style>

