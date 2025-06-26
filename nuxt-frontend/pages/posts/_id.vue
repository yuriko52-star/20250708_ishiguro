<template>
    <div class="index-layout">
        
        <SideNav @refreshPosts="fetchPost"/>
        <main class="main-content">
            <h2>コメント</h2>
            <Message 
                v-if="post.username"
                :post="post" :showDetailLink="false"
                @deleted="handleDeleted"
                @liked="handleLiked"/>
    
                <div  v-if="post.comments" class="comment-content">
                <h3>コメント</h3>
                <div v-for="comment in post.comments" :key="comment.id" class="comment-item">
                    <p class="username">{{comment.user.username}}</p>
                    <p class="comment-body">{{ comment.comment}}</p>
                </div>
            </div>
            <div class="comment-input" v-if="post">
                <input v-model="newComment" class="input">
            </div>
            <div class="btn" vi-if="post">
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
            post:{},
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
      if (!idToken) {
        console.warn('トークンがありません。ログインしてください。')
        return
    }
    try {
    const res = await this.$axios.get(`http://localhost:8000/api/posts/${id}`,{
        headers: {
          Authorization: `Bearer ${idToken}`
        }
      })
      console.log('取得したpost:', res.data)
      this.post = res.data
      console.log('post:', this.post)
      } catch (e) {
        console.error('コメント投稿画面取得でエラー:', e.response?.status, e.response?.data)
      }
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
      } catch  {
        alert('コメント送信エラー')
      }
    },
    async handleDeleted() {
      await this.fetchPost()
    },
    async handleLiked() {
      await this.fetchPost()
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
h3 {
  text-align: center;
}
.comment-item {
  border-bottom: 1px solid #555;
  border-top: 1px solid #555;
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
  color: white;
}
.btn {
  text-align: right;
  margin-top: 1rem;
}
.comment-btn {
  background-color: blueviolet;
  color: white;
  border: none;
  border-radius: 25px;
  padding: 0.5rem 1rem;
  font-weight: bold;
  
}
</style>
