<template>
    <header class="header">
        <img src="img/logo.png" alt="ロゴ" class="logo">
        <nav class="nav">
            <nuxt-link to="/register">新規登録</nuxt-link>
            <nuxt-link to="/login">ログイン</nuxt-link>
        </nav>
    </header>
</template>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items:center ;
    padding: 1rem 2rem;
    background-color: black;
    margin: 0;
    border: none;
    
}
.logo {
    height: 50px;
}
.nav a {
    margin-left: 1rem;
    color: white;
    text-decoration: none;
    font-weight: bold;
}
</style>