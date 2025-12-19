<template>
  <ul :class="[{ 'nav-header': !isMobile }, { 'nav-mobile': isMobile }]">
    <li v-for="item in arrayItems" :key="item" @click="closeMenu">
      <router-link :to="item.path" class="block-overlay"></router-link>
      <span>{{ item.name }}</span>
      <svg v-if="item.svg" xmlns="http://www.w3.org/2000/svg" width="9" height="9" fill="none">
        <path
          fill="#272930"
          fill-rule="evenodd"
          d="M.818 0h7.364C8.634 0 9 .366 9 .818v7.364H7.364V2.793l-5.69 5.69L.515 7.328l5.69-5.69H.819V0Z"
          clip-rule="evenodd"
          opacity=".3"
        />
      </svg>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    navItems: Array,
    isMobile: Boolean,
  },
  data() {
    return {
      arrayItems: !this.isMobile ? this.navItems.filter((item) => item.name !== "All manufacturers") : this.navItems,
    };
  },
  methods: {
    closeMenu() {
      this.$emit("closeMenu");
    },
  },
};
</script>

<style lang="scss" scoped>
li {
  position: relative;
}
.nav-header {
  display: flex;
  align-items: center;
}
.nav-header li {
  padding: 25px;
}
.nav-header li span {
  cursor: pointer;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  color: #272930;
}
@media (max-width: 1800px) {
  .nav-header li {
    padding-left: 12.5px;
    padding-right: 12.5px;
  }
}
@media (max-width: 1400px) {
  .nav-header li:first-child {
    padding-left: 0;
  }
  .nav-header li:last-child {
    padding-right: 0;
  }
}
@media (max-width: 1199px) {
  .nav-header {
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 10px;
  }
  .nav-header li {
    padding-left: 0;
    padding-right: 0;
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .nav-mobile {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  .nav-mobile li {
    padding-left: 0;
    padding-right: 0;
    font-size: 20px;
    padding-top: 8px;
    padding-bottom: 8px;
  }
  .nav-mobile li svg {
    margin-left: 8px;
  }
  .nav-mobile li span {
    font-size: 14px;
    line-height: 100%;
    color: #272930;
    opacity: 0.6;
  }
  .nav-mobile {
    margin-bottom: 42px;
  }
}
</style>
