import { initializeApp } from 'firebase/app'
import { getAuth } from 'firebase/auth'

export default (context, inject) => {
    const firebaseConfig = {
        apiKey: "AIzaSyBAm0Ka32tC2LVgmE5kc9-fsrxtdIV94f8",
        authDomain: "twitter-app-1b0d9.firebaseapp.com",
        projectId: "twitter-app-1b0d9",
        storageBucket: "twitter-app-1b0d9.firebasestorage.app",
        messagingSenderId: "119235605003",
        appId: "1:119235605003:web:5637e804f649489de00d0e"
    };
    const app = initializeApp(firebaseConfig)
    const auth = getAuth(app)

    inject('firebaseApp', app)
    inject('firebaseAuth', auth)
}


