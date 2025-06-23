<template>
    <div class="message">
        <div class="message-header">
            <h2 >ユーザー名</h2>
            <button ><img src="/img/heart.png" alt="" class="img-btn"></button>
            <p >0</p>
            <button ><img src="/img/cross.png" alt="" class="img-btn"></button>
            <nuxt-link to="/posts_id"><img src="/img/detail.png" alt="" class="img-btn">
            </nuxt-link>
        </div>
        <div   class="message-content">
        メッセージ
        </div>
    </div>
</template>

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