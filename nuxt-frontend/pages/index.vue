<template>
  <div class="index-layout">
    
      <SideNav />
    
    <main class="main-content">
      <h2>ホーム</h2>
      <Message />
    </main>
  </div>
</template>

<script>
 import SideNav from '~/components/SideNav.vue'
import Message from '~/components/Message.vue'


export default {
  components: {
    SideNav,
    Message
  }

}
</script>
<style scoped>
.index-layout {
  display: flex;
  height: 100vh;
  background-color: black;
  margin: 0;
  padding: 0;
}
.sidenav {
  width: 350px;
  height: 100vh;
  background-color: black;
  padding: 1rem;
  box-sizing: border-box;
}
.main-content {
  flex: 1;
  height: 100vh;
  overflow: auto;
  padding: 1.5rem;
  color: white;
  background-color: black;

}
</style>

