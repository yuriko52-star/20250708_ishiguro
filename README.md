# Twitter-app  
## 概要  
複雑な機能がないので老若男女が楽しめる、ちょっとつぶやいてみたい時に最適なアプリです。   
## 画像  （メインページ）  
![index.vue](./images/index.vue.png)
  
## 作成した目的  
トランプ大統領も書き込んでは炎上しているtwitter（現：X）なるものを自分でもやってみようと  
試したものの使い方が複雑、なぜか自分のアカウントも凍結されてしまいました。  
slackのコミュニティで発信し、反応をいただくことに快感を覚えたこともあり、ちょっとしたつぶやきで  
簡単にコミュニケーションできないかとこのアプリを作成してみました。
## アプリケーションURL  
 新規登録  http://localhost:3000/register  
 ログイン  http://localhost:3000/login  


## 他のリポジトリ  
  バックエンド 20250708_ishiguro/laravel-backend  
  フロントエンド 20250708_ishiguro/nuxt-frontend  
## 機能一覧  
- 新規登録機能  
- ログイン機能  
- 投稿機能  
- いいね機能  
- コメント機能  

## 使用技術（実行環境）  
  laravel 8.83.29  
  nuxt v2.18.1  
  php  v8.1.2  
    
## テーブル設計  
![テーブル構成](./images/table1.png)  
![テーブル構成２](./images/table2.png)  

  
## ER図  
![ER図](./images/erd3.png) 

## Firebase 事前準備  
  Firebaseを使用するために、以下の設定を先に行ってください。  
  公式サイトのURL：https://firebase.google.com  
   1. Firebaseプロジェクトを新規作成（Firebase Consoleから）  
   2. 以下の機能を有効化：  
    - Firebase Authentication  
    - Cloud Firestore  
   3. 秘密鍵（サービスアカウントキー）の取得方法：  
    - Firebase Console → 「プロジェクト設定」→「サービスアカウント」→「新しい秘密鍵の生成」  
    - ダウンロードされたJSONファイルを laravel-backend/firebase-adminsdk.json にリネームして配置  


## 環境構築  (クローン編)  
　　
※提出者向け操作です  

1. クローンしたいところに移動  
2. git clone git@github.com:yuriko52-star/20250708_ishiguro.git  
3. mv 20250708_ishiguro 任意のフォルダー名  
4. 任意のフォルダー名の リポジトリ作成  
5. cd  任意のフォルダー名  
6. git remote set-url origin git@github.com:yuriko52-star/任意のフォルダー名.git  
7. git remote -v  
8. git add .  
9. git commit -m "コメント"  
10. git push origin main  


### laravel側のセットアップ  
1. cd laravel-backend  
2. composer install  
3. データベースの作成  
    mysql -u root -p  
    CREATE DATABASE  お好きな名前（小文字で。ハイフンは✖ _なら〇）  
    名前はtwitter, twitter_app ,twitter_app_clone, twitter_app2以外でお願いします  
  (php artisan migrateができなくなるため)     
     
4. cp .env.example .env  
5. .envに環境変数を追加  
    DB_DATABASE= 3で作成した名前  
    DB_USERNAME=root  
    DB_PASSWORD=root  
6. php artisan key:generate  
7. php artisan migrate  
#### Firebase SDKと設定ファイルの準備  
8. Firebaseライブラリのインストール：  
    composer require kreait/laravel-firebase:^3.0 -W  
9. Firebase設定ファイルの生成：  
    php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider" --tag=config
10. laravel-backend/firebase-adminsdk.jsonを作成し、Firebaseからダウンロー ドした秘密鍵ファイルを保存   
11. .envに以下を記載  
    FIREBASE_CREDENTIALS=/absolute/path/to/laravel-backend/firebase-adminsdk.json  
12. config/firebase.php に以下のようにパスを設定：  
    'credentials' => [
                
                'file' => '/absolute/path/to/laravel-backend/firebase-adminsdk.json',  
        ]    
13. php artisan serve  

### nuxt側のセットアップ  
1. cd nuxt-frontend  
2. yarn install  
3. yarn add firebase　　
####  Firebase プラグインの作成（plugins/firebase.js） 
4. plugins/firebase.js を作成し、以下のように設定（例）：  
    import { initializeApp } from 'firebase/app'  

    import { getAuth } from 'firebase/auth'

    export default (context, inject) => {  

      const firebaseConfig = {  

        apiKey: "YOUR_API_KEY",  

        authDomain: "YOUR_PROJECT.firebaseapp.com",  

        projectId: "YOUR_PROJECT_ID",  

        storageBucket: "",  

        messagingSenderId: "",  

        appId: ""  

      };  

    const app = initializeApp(firebaseConfig)  

    const auth = getAuth(app)

    inject('firebaseApp', app)  

    inject('firebaseAuth', auth)  

  }  

 ※　FirebaseのAPIキーなどは Firebase Console から取得してください。  

5. yarn dev  
※　firebase.jsとfirebase-adminsdk.jsonは.gitignoreに追加済みです  

    
  
  
  
  
 
  
   






