<template>
    <div>
        <AuthHeader v-if="showHeader"/>
            <Nuxt/>
    </div>
</template>

<script>
import AuthHeader from '~/components/AuthHeader.vue'
import { onAuthStateChanged } from 'firebase/auth'

export default {
    components: {
        AuthHeader,
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
    overflow: hidden;
    }
   main {
flex: 1;
  overflow-y: auto;
  padding: 1rem;
  height: 100vh;
  width: 100vw;
}
</style>


