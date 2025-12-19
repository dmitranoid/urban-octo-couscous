<template>
  <the-header></the-header>
  <main>
    <router-view></router-view>
  </main>
  <the-footer></the-footer>
</template>

<script>
import TheHeader from "./components/header/TheHeader.vue";
import TheFooter from "./components/TheFooter.vue";

export default {
  name: "App",

  components: {
    TheHeader,
    TheFooter,
    // MainPage,
  },
};
</script>

<style></style>
