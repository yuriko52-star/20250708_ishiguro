<template>
<div class="index-layout">
    <SideNav @refreshPosts="fetchPosts"/>
      <main class="main-content">
      <h2>ホーム</h2>
      <div v-if="posts.length === 0">投稿がありません</div>
      <Message 
        v-for="post in posts"
        :key="post.id + '-' + post.likes_count"
        :post="post"
        @deleted="fetchPosts"
        @liked="fetchPosts"/>
    </main>
  </div>
</template>

<script>
import SideNav from '~/components/SideNav.vue'
import Message from '~/components/Message.vue'
import { onAuthStateChanged } from 'firebase/auth'

export default {
  components: {
    SideNav,
    Message
  },
  data() {
    return {
      posts: [],
      
    }
  },
   
  methods: {
    async fetchPosts() {
      console.log('fetchPosts start')
  try {
      const idToken = await this.$firebaseAuth.currentUser.getIdToken()
      const res = await this.$axios.get('http://localhost:8000/api/posts', {
        headers: {
          Authorization: `Bearer ${idToken}`
        }
      })
      console.log('fetchPosts response:', res.data)
      this.posts = res.data
      } catch (error) {
        console.error('投稿取得エラー:', error)
  }
  }

},
async mounted() {
  const auth = this.$firebaseAuth
  onAuthStateChanged(auth, async (user) => {
      if (user) {
        console.log('ログイン中のユーザー:', user)
        await this.fetchPosts()
        console.log('fetch done.')
      } else {
        console.warn('ユーザーが未ログイン')
      }
    })
  }
}
</script>
<style scoped>
.index-layout {
  display: flex;
  height: 100vh;
  background-color: black;
  margin: 0;
  padding: 0;
}
.sidenav {
  width: 350px;
  height: 100vh;
  background-color: black;
  padding: 1rem;
  box-sizing: border-box;
}
.main-content {
  flex: 1;
  height: 100vh;
  overflow: auto;
  padding: 1.5rem;
  color: white;
  background-color: black;

}
</style>

