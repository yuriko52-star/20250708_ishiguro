<template>
    <div class="login-page">
        <div class="login-box">
            <h2>ログイン</h2>
            <input v-model="email" type="email" placeholder="メールアドレス">
            <input v-model="password" type="password" placeholder="パスワード">
        
            <button @click="login">ログイン</button>
        </div>
    </div>
</template>

<script>
import { signInWithEmailAndPassword} from 'firebase/auth'

export default {
    data() {
        return  {
            
            email: '',
            password: ''
        }
    },
    methods: {
        async login() {
            try {
                const userCredential = await signInWithEmailAndPassword(
                    this.$firebaseAuth,
                    this.email,
                    this.password 
                )
                console.log('ログイン成功:',userCredential.user)
                this.$router.push("/")
            } catch (error) {
            alert('ログイン失敗: ' + error.message)
            }
        }
    }
}
</script>

<style scoped>
.login-page {
    background-color: black;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.login-box {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    width: 400px;

}
.login-box h2 {
    text-align: center;
    margin-bottom: 1rem;
}
.login-box input {
       
    width: 100%;
    margin-bottom: 1rem;
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid black;
}
.login-box button {
   width: 100px;
   background-color: blueviolet; 
   color: white;
   padding: 0.6rem;
   border: none;
   border-radius: 25px;
   font-weight: bold;
   display: block;
   margin-left: 120px;
}
</style>
