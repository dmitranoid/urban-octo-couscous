<template>
  <div class="not-found">
    <div class="container">
      <h1>Page not found</h1>
      <button>
        Go to main page
        <router-link class="block-overlay" to="/"></router-link>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    window.scrollTo({
      top: 1,
      behavior: "smooth",
    });
  },
};
</script>

<style scoped>
.not-found {
  padding-top: 30px;
  min-height: 50vh;
}
button {
  position: relative;
  width: 284px;
  height: 50px;
  background: #6083c0;
  margin-top: 30px;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 130%;
  color: #ffffff;
}
</style>
