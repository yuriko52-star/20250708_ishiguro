<template>
	<div class="index-layout">
        <SideNav />
        <main class="main-content">
            <h2>コメント</h2>
             <Message 
                v-if="post.id"
                :key="post.id + '-' + post.likes_count" 
                :post="post" :showDetailLink="false"
                @deleted="handleDeleted"
                @liked="handleLiked"/> 
                
    
                <div  v-if="post.comments" class="comment-content">
                <h3>コメント</h3>
                <div v-for="comment in post.comments" :key="comment.id" class="comment-item">
                    <p class="username">{{comment.username|| '名無しの権瓶'}}</p>
                    <p class="comment-body">{{ comment.comment}}</p>
                </div>
            </div>
			<validation-observer ref="obs" v-slot="{ invalid , reset}">
            <div class="comment-input">
				<validation-provider name="コメント" rules="required|max:120" v-slot="{ errors }">
                <input v-model="newComment" class="input" >
				 <div class="error">{{ errors[0] }}</div>
				 </validation-provider>
            </div>
            <div class="btn">
                <button :disabled="invalid" @click="() => { submitComment(); reset(); }" class="comment-btn">コメント</button>
                <!-- <p v-if="commentError" class="error">{{ commentError}}</p> -->
            </div>
            </validation-observer>
        </main>
    </div>
</template>

<script>
import SideNav from '~/components/SideNav.vue'
import Message from '~/components/Message.vue'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
export default {
    components: {
        SideNav,
        Message,
		ValidationObserver, 
		ValidationProvider 
    },
    data() {
        return {
            post:{},
            newComment: '',
            commentError: '',
        }
    },
     async fetch() {
    await this.fetchPost()
  	},
  
    methods: {
    async fetchPost() {
       const id = this.$route.params.id
      const idToken = localStorage.getItem('idToken')
	  console.log('fetchPost idToken:', idToken);
      if (!idToken) {
        console.warn('トークンがありません。ログインしてください。')
        return null
    }
    try {
		
      	const res = await this.$axios.get(`http://localhost:8000/api/posts/${id}`, {
            headers: { Authorization: `Bearer ${idToken}` }
          })
          
    
		  	// console.log('fetchPost received post:', res.data);
    		//    console.log('post.comments length:', res.data.comments.length);
      		// console.log('post.comments:', res.data.comments);
      		// res.data.comments.forEach(c => console.log('comment item:', c));
          this.post = Object.assign({},res.data)
         return res.data
          // this.post.comments.forEach(c => console.log(`再代入後 comment[${i}]:`, c))
        } catch (e) {
        	console.error('取得エラー', e.response?.status, e.response?.data)
        	return null
      	}
    },
    
    async submitComment() {
		const isValid = await this.$refs.obs.validate()
      	if (!isValid) return
       const idToken = localStorage.getItem('idToken')
	   console.log('submitComment idToken:', idToken);
     this.commentError = ''
      try {
        const res =  await this.$axios.post('http://localhost:8000/api/comments', {
          post_id: this.post.id,
         
          comment: this.newComment
        }, {
          headers: {
            Authorization: `Bearer ${idToken}`
          }
        })
		console.log('Comment POST response:', res.data);
    	console.log('post.comments:', this.post.comments);

        this.newComment = ''
		
        await this.fetchPost()
        console.log('updated post.comments:', this.post.comments)
      } catch (error) {
         console.error('コメント送信失敗:', error);
        // this.commentError = error.response?.data.message || '自分の投稿にコメントを送信できません'
      }
      
    },
    
  	async handleLiked() {
		console.log('処理: likeボタン押された');
      await this.fetchPost()
	  console.log('fetchPost 後の post:', this.post);
    },
    async handleDeleted() {
          this.post = {}
          this.$router.push('/')
  	},
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
width: 1500px;
  padding: 1rem;
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
.error {
	color: red;
}
</style>
