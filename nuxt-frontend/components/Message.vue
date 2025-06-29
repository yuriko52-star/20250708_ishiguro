<template>
    <div class="message">
        <div class="message-header">
            <h2 v-if="post.username">{{ post.username}}</h2>
            <button @click="like"><img src="/img/heart.png" class="img-btn"></button>
            <p v-if="likeError" class="error">{{ likeError }}</p>
            <p v-if="post.likes_count !== undefined">{{ post.likes_count }}</p>
            <button @click="remove"><img src="/img/cross.png"  class="img-btn"></button>
            <p v-if="deleteError" class="error">{{ deleteError }}</p>
            <nuxt-link v-if="showDetailLink" :to="`/posts/${post.id}`"><img src="/img/detail.png"  class="img-btn">
            </nuxt-link>
        </div>
        <div   class="message-content">
        {{ post.body}}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        post: {
            type: Object,
            required: true
        },
            showDetailLink: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            likeError: '',
            deleteError: ''
        };
    },
    methods: {
        async like() {
            const idToken = await this.$firebaseAuth.currentUser.getIdToken();
           
            try {
            const res = await this.$axios.post('http://localhost:8000/api/likes/toggle', {
                post_id: this.post.id
            }, {
                headers: {
                    Authorization: `Bearer ${idToken}`
                }
            });
            
            console.log(res.data.message);
            this.$emit('liked');

            } catch(err) {
                this.likeError = err.response?.data.message || 'いいねできません';
                console.log(this.likeError)
                console.error('いいね処理エラー:', err);
            }
            
        },
        async remove() {
            const idToken = await this.$firebaseAuth.currentUser.getIdToken()
            try {
            await this.$axios.delete(`http://localhost:8000/api/posts/${this.post.id}`, {
                headers: {
                    Authorization: `Bearer ${idToken}`
                }
            })
             console.log('投稿削除成功、deleted イベントを emit します')  
            this.$emit('deleted')
            } catch(err) {
                this.deleteError = err.response?.data.message || '削除できません';
            }
        }
    }
}
</script>

<style scoped>
    .message {
        width: 100%;
        box-sizing: border-box;
        background-color: black;
        color: white;
       padding: 20px ;
       margin-bottom: 1rem;
       border:1px solid white;
       margin: 20px 0;
       
    }
    .message-header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 1rem;
    }
    .img-btn {
        width: 30px;
        height: 30px;
    }
    .message-content {
        padding: 20px 10px;
    }
    .error {
        color: red;
        font-size: 0.9rem;
        
    }
</style>