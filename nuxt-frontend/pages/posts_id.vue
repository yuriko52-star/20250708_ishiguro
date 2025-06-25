<template>
    <div class="index-layout">
        
        <SideNav @refreshPosts="fetchPosts"/>
        <main class="main-content">
            <h2>コメント</h2>
            <Message 
                :post="post" :showDetailLink="false"
                @deleted="fetchPosts"
                @liked="fetchPosts"/>
    
                <div class="comment-content">
                <h3>コメント</h3>
                <div v-for="comment in post.comments" :key="comment.id" class="comment-item">
                    <p class="username">{{comment.username}}</p>
                    <p class="comment-body">{{ comment.comment}}</p>
                </div>
            </div>
            <div class="comment-input">
                <input v-model="newComment" class="input">
            </div>
            <div class="btn">
                <button @click="submitComment" class="comment-btn">コメント</button>
            </div>
            
        </main>
    </div>
</template>

<script>
import SideNav from '~/components/SideNav.vue'
import Message from '~/components/Message.vue'

export default {
    components: {
        SideNav,
        Message
    },
    data() {
        return {
            posts:{},
            newComment: '',
            username: '',
            
        }
    },
    async fetch() {
    await this.fetchPost()
  },
    methods: {
    async fetchPost() {
      const id = this.$route.params.id
      const idToken = localStorage.getItem('idToken')
      const res = await this.$axios.get(`http://localhost:8000/api/posts/${id}`, {
        headers: {
          Authorization: `Bearer ${idToken}`
        }
      })
      this.post = res.data
    },
    async submitComment() {
      const idToken = localStorage.getItem('idToken')
      try {
        await this.$axios.post('http://localhost:8000/api/comments', {
          post_id: this.post.id,
          username: this.username,
          comment: this.newComment
        }, {
          headers: {
            Authorization: `Bearer ${idToken}`
          }
        })
        this.newComment = ''
        await this.fetchPost()
      } catch (e) {
        alert('コメント送信エラー')
      }
    }
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
.comment-content {
  border-top: 1px solid #fff;
  margin-top: 1rem;
  padding-top: 1rem;
}
.comment-item {
  border-bottom: 1px solid #555;
  padding: 0.5rem 0;
}
.username {
  font-weight: bold;
}
.comment-input {
  display: flex;
  margin-top: 1rem;
}
.input {
  flex: 1;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  margin-right: 0.5rem;
}
.comment-btn {
  background-color: blueviolet;
  color: white;
  border: none;
  border-radius: 25px;
  padding: 0.5rem 1rem;
}
</style>
