<template>
    <div class="message">
        <div class="message-header">
            <h2 >{{ post.username}}</h2>
            <button @click="like"><img src="/img/heart.png" class="img-btn"></button>
            <p >{{ post.likes_count }}</p>
            <button @click="remove"><img src="/img/cross.png"  class="img-btn"></button>
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
    methods: {
        async like() {
            const idToken = await this.$firebaseAuth.currentUser.getIdToken()
            await this.$axios.post('http://localhost:8000/api/likes', {
                post_id: this.post.id
            }, {
                headers: {
                    Authorization: `Bearer ${idToken}`
                }
            })
            this.$emit('liked')
        },
        async remove() {
            const idToken = await this.$firebaseAuth.currentUser.getIdToken()
            await this.$axios.delete(`http://localhost:8000/api/posts/${this.post.id}`, {
                headers: {
                    Authorization: `Bearer ${idToken}`
                }
            })
            this.$emit('deleted')
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
</style>