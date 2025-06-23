<template>
    <div class="register-page">
        <div class="register-box">
            <h2>新規登録</h2>
            <input v-model="username" type="text" placeholder="ユーザーネーム">
            <input v-model="email" type="email" placeholder="メールアドレス">
            <input v-model="password" type="password" placeholder="パスワード">
        
            <button @click="register">新規登録</button>
        </div>
    </div>
</template>

<script>
import { createUserWithEmailAndPassword, updateProfile } from 'firebase/auth'

export default {
    data() {
        return  {
            username: '',
            email: '',
            password: ''
        }
    },
    methods: {
        async register() {
            try {
                const userCredential = await createUserWithEmailAndPassword(
                    this.$firebaseAuth,
                    this.email,
                    this.password 
                )
                await updateProfile(userCredential.user, {
                    displayName: this.username
                })
                console.log('登録成功:',userCredential.user)

                const idToken = await userCredential.user.getIdToken()

                await this.$axios.post('http://localhost:8000/api/auth/register', {
                    idToken: idToken
                })
                console.log('Laravel登録完了')
                this.$router.push('/login')

            } catch (error) {
                alert('登録エラー: ' + error.message)
            }
        }
    }
}
</script>

<style scoped>
.register-page {
    background-color: black;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.register-box {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    width: 400px;

}
.register-box h2 {
    text-align: center;
    margin-bottom: 1rem;
}
.register-box input {
       
        width: 100%;
        margin-bottom: 1rem;
        padding: 0.6rem;
        border-radius: 8px;
        border: 1px solid black;
}
.register-box button {
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
