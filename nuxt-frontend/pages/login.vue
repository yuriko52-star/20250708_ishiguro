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

                const idToken = await userCredential.user.getIdToken()

                await this.$axios.post('http://localhost:8000/api/auth/register', {
                idToken: idToken
                })
                localStorage.setItem('idToken', idToken)
                this.$router.push('/')
                console.log('Laravel側にもユーザー登録完了')

                const res = await this.$axios.get('http://localhost:8000/api/auth/me', {
                    headers: {
                        Authorization: `Bearer ${idToken}`
                    }
                })
                console.log('ログイン中のユーザー:', res.data.user)
console.log('ルーター遷移前')
                this.$router.push("/")
                console.log('ルーター遷移後') 
            } catch (error) {
console.error('ログイン処理でエラー:', error)
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
