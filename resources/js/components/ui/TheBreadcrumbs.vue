<template>
  <div class="block-breadcrumbs">
    <div class="block-breadcrumbs__wrapper">
      <router-link to="/"><span class="block-breadcrumbs__span">E-Trade</span></router-link>
      <div class="block-breadcrumbs__link" v-for="(item, idx) in arrayUrl" :key="item">
        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="none">
          <g clip-path="url(#a)" opacity=".5">
            <path
              fill="#272930"
              d="M1.573 1.49a.25.25 0 0 0 0 .353L3.73 3.999 1.573 6.156a.25.25 0 0 0 0 .353l1.084 1.084a.25.25 0 0 0 .353 0l3.417-3.417a.248.248 0 0 0 0-.353L3.01.406a.25.25 0 0 0-.353 0L1.573 1.489Z"
            />
          </g>
          <defs>
            <clipPath id="a"><path fill="#fff" d="M0 8V0h8v8z" /></clipPath>
          </defs>
        </svg>
        <div class="block-breadcrumbs__link-block">
          <router-link
            :to="
              idx < arrayUrl.length - 1 && idx > 0
                ? `/${arrayUrl.filter((el, index) => index <= idx).join('/')}`
                : `/${item}`
            "
            class="block-overlay"
            v-if="idx !== arrayUrl.length - 1"
          ></router-link>
          <span
            :class="['block-breadcrumbs__span', { 'block-breadcrumbs__span--active': idx === arrayUrl.length - 1 }]"
            >{{ item.charAt(0).toUpperCase() + item.slice(1) }}</span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      arrayUrl: this.$route.path.split("/").filter((item) => item !== ""),
    };
  },
  watch: {
    $route(to, from) {
      this.arrayUrl = this.$route.path.split("/").filter((item) => item !== "");
    }
  }
};
</script>

<style scoped>
.block-breadcrumbs__wrapper {
  display: flex;
  align-items: center;
}
.block-breadcrumbs__link {
  display: flex;
  align-items: center;
}
.block-breadcrumbs__link-block {
  position: relative;
}
.block-breadcrumbs {
  display: flex;
  align-items: center;
}
.block-breadcrumbs svg {
  margin-right: 11.5px;
}
.block-breadcrumbs__span {
  display: block;
  font-size: 16px;
  line-height: 100%;
  opacity: 0.5;
  color: #272930;
  margin-right: 10px;
}
.block-breadcrumbs__span--active {
  opacity: 1;
}
@media (max-width: 767px) {
  .block-breadcrumbs__span {
    font-size: 12px;
    line-height: 100%;
  }
}
@media (max-width: 400px) {
  .block-breadcrumbs {
    width: 100%;
    overflow-x: auto;
    padding-bottom: 10px;
  }
  .block-breadcrumbs__wrapper {
    width: 90%;
  }
}
</style>