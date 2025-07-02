# Twitter-app   
## 画像  （メインページ）  
![index.vue](./images/index.vue.png)
  
## 作成した目的  
トランプ大統領も書き込んでは炎上しているtwitter（現：X）なるものを自分でもやってみようと  
試したものの使い方が複雑、なぜか自分のアカウントも凍結されてしまいました。  
slackのコミュニティで発信し、反応をいただくことに快感を覚えたこともあり、ちょっとしたつぶやきで  
簡単にコミュニケーションできないかとこのアプリを作成してみました。
## アプリケーションURL  
 新規登録  http://localgost:3000/register  
 ログイン  http://localhost:3000/login  


## 他のリポジトリ  
  バックエンド laravel-backend  
  フロントエンド nuxt-frontend  
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

## 環境構築  (クローン編)　　

1. クローンしたいところに移動  
2. git clone git@github.com:yuriko52-star/提出フォルダー名.git  
3. mv 提出フォルダー名 任意のフォルダー名  
4. 任意のフォルダー名の リポジトリ作成  
5. cd  任意のフォルダー名  
6. git remote set-url origin git@github.com:yuriko52-star/任意のフォルダー名.git  
7. git remote -v  
8. git add .  
9. git commit -m "コメント"  
10. git push origin main  

### laravel側  
11. cd laravel-backend  
12. composer install  
13. データベースの作成  
    mysql -u root -p  
    CREATE DATABASE  お好きな名前（小文字で。ハイフンは✖ _なら〇）   
     
14. .cp .env.example .env  
15. .envに環境変数を追加  
    DB_DATABASE= 13で作成した名前
    DB_USERNAME=root  
    DB_PASSWORD=root  
15. php artisan key:generate  
16. php artisan migrate
17. touch firebase-adminsdk.json   
18. cd firebase-adminsdk.json  
19. ファイルの中身をコピーする  
20. php artisan serve  

### nuxt側  
21. cd nuxt-frontend  
22. cd plugins  
23. touch firebase.js  
24. cd touch firebase.js  
25. ファイルの中身をコピーする  
26. yarn dev  

## 注意事項  
1. CREATE DATABASE  お好きな名前（小文字で。ハイフンは✖ _なら〇）  
  名前はtwitter_appやtwitter_app_clone以外でお願いします  
  (php artisan migrateができなくなるため)  
2. ユーザー認証はFirebase Authenticationを使用しています。  
  ご自身で公式サイトに入っていただき設定をお願いします。  
  公式サイトのURL：https://firebase.google.com  
  - Firebaseプロジェクトを新規作成（コンソールから）  
  - Firebase Authentication・Firestore など必要な機能を有効化 
  nuxt側の設定  
  - yarn add firebase
  - firebase.jsをnuxt-frontend/pluginsに作成（モジュラー構文で）   
  laravel側の設定  
  - composer require kreait/laravel-firebase:^3.0 -W  
  - php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider" --tag=config で設定ファイル生成  
  - .env に以下を記載  
    FIREBASE_CREDENTIALS=/absolute/path/to/laravel-backend/firebase-adminsdk.json  
  - 秘密鍵の取得  
     Firebaseコンソール-> プロジェクト設定-> サービスアカウント-> 新しい秘密鍵の生成で取得  
  - ダウンロードしたファイルをfirebase-adminsdk.jsonの名前でlaravel-backendに作成  
3. firebase.jsとfirebase-adminsdk.jsonは.gitignoreに入れてください  
  
   






