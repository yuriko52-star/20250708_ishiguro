<template>
    <aside class="sidenav">
        <img src="img/logo.png" alt="ロゴ" class="logo">
        <nav class="menu">
           <nuxt-link to="/" class="menu-item"><img src="/img/home.png" alt="ホーム" class="">ホーム</nuxt-link>
            <button @click="logout" class="menu-item"><img src="/img/logout.png" alt="ログアウト">ログアウト</button>
        </nav>
        <div class="share-box">

            <h2>シェア</h2>
            <textarea v-model="message"></textarea>
            <button class="share-button" @click="share">シェアする</button>
        </div>
    </aside>
   
</template>
<script>


export default {
    data() {
        return {
            message: ''
        }
    },
    methods: {
        share() {
           console.log("投稿", this.message)
           this.message =''
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

 .menu{ 
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin: 2rem 0;
}
.menu-item {
  display: flex;
  align-items: center;
  gap: 1.5rem; /* 画像と文字の間のスペース */
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
</style>