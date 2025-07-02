<template>
<validation-observer ref="observer" v-slot="{ invalid, reset}">
    <aside class="sidenav">
        <img src="/img/logo.png" alt="ロゴ" class="logo">
        <nav class="menu">
           <nuxt-link to="/" class="menu-item"><img src="/img/home.png" alt="ホーム" class="">ホーム</nuxt-link>
            <button @click="logout" class="menu-item"><img src="/img/logout.png" alt="ログアウト">ログアウト</button>
        </nav>
        <div class="share-box">
            <h2>シェア</h2>
           <ValidationProvider name="投稿" rules="required|max:120" v-slot="{ errors }"> 
            <textarea v-model="message"></textarea>
            <div class="error">{{ errors[0]}}</div>
            </ValidationProvider>
            <button :disabled="invalid" class="share-button" @click="() => { share(); reset(); }">シェアする</button>
             
        </div>
    </aside>
  </validation-observer>
</template>
<script>


export default {
    data() {
        return {
            message: ''
        }
    },
    methods: {
        async share() {
     try {
        const user = this.$firebaseAuth.currentUser
        if (!user) {
        alert('ユーザー情報が取得できません')
        return
        }
            
        const idToken = await user.getIdToken()
            

            await this.$axios.post('http://localhost:8000/api/posts', {
                 username: user.displayName, 
                body: this.message
            }, {
                headers: {
                    Authorization: `Bearer ${idToken}`
                }
            })
        
           this.message =''
           this.$refs.observer.reset() 
           this.$emit('refreshPosts')
        } catch (err) {
            console.error('投稿失敗:', err)
            alert('投稿失敗しました')
        }
        },
        logout() {
            this.$firebaseAuth.signOut()
            this.$router.push('/login')
        }
    }
}
</script>


<style scoped>
.sidenav {
    color: white;
    padding: 1rem;
    width: 350px;
    height: 100vh;
    background-color: black;
    display: flex;
    flex-direction: column;
    justify-content: start;
    border-right: 1px solid white;
    
}
.logo {
    width: 50%;
}
 .menu{ 
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin: 2rem 0;
}
.menu-item {
  display: flex;
  align-items: center;
  gap: 1.5rem; 
  color: white;
  text-decoration: none;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}
 .menu img {
    width: 30px;
    height: 30px;
 }

.share-box {
    margin-top: 10px;
    font-size: 1.5rem;
}
textarea {
    width: 100%;
    height: 120px;
    margin: 0.5rem 0 ;
    border-radius: 6px;
    padding: 0.5rem;
    border: 1px solid white;
    color: white;

}
.share-button {
    width: 40%;
    background-color: blueviolet; 
   color: white;
   padding: 0.5rem 0;
   border: none;
   border-radius: 25px;
   font-weight: bold;
   font-size: 1rem;
   margin-left: 180px;
}
.error {
    color: red;
}
</style>