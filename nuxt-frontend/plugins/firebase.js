import { initializeApp } from 'firebase/app'
import { getAuth } from 'firebase/auth'

export default (context, inject) => {
    const firebaseConfig = {
        apiKey: "",
        authDomain: "",
        projectId: "",
        storageBucket: "",
        messagingSenderId: "",
        appId: ""
    };
    const app = initializeApp(firebaseConfig)
    const auth = getAuth(app)

    inject('firebaseApp', app)
    inject('firebaseAuth', auth)
}


