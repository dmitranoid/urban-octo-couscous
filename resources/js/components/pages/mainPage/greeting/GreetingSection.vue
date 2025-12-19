<template>
  <section class="greeting">
    <div class="container">
      <div class="greeting__info">
          <h2><slot name="title">Wide selection of industrial automation and electronics components.</slot></h2>
          <p><slot name="content">We are your reliable partner for solving problems in the field of industrial automation.</slot></p>
      </div>
    </div>
    <div class="greeting__banner">
      <div class="greeting__line greeting__line--green">
        <div class="greeting__line-block"></div>
      </div>
      <div class="greeting__line greeting__line--blue">
        <div class="greeting__line-block"></div>
      </div>
      <div class="greeting__banner-image">
        <picture>
          <slot name="banner">
            <img class="desktop" src="@/assets/images/greeting-banner.jpg" alt="greeting-banner" loading="lazy" />
            <img class="mobile" src="@/assets/images/greeting-banner_mobile.jpg" alt="greeting-banner" loading="lazy" />
          </slot>
        </picture>
      </div>
      <div class="greeting__search">
        <div class="container">
          <search-block></search-block>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import SearchBlock from "@/components/ui/SearchBlock.vue";

export default {
  components: { SearchBlock },
};
</script>

<style scoped>
.greeting__banner-image .mobile {
  display: none;
}

.greeting__info {
  padding-top: 73px;
  padding-bottom: 65px;
}
.greeting__info h2 {
  font-size: 46px;
  line-height: 100%;
  margin-bottom: 32px;
  max-width: 560px;
}
.greeting__info p {
  font-size: 18px;
  line-height: 100%;
  max-width: 700px;
}
.greeting__banner {
  position: relative;
}
.greeting__line {
  position: absolute;
}
.greeting__line--green {
  bottom: calc(100% - 74px);
  right: 0;
  width: 30%;
  height: 300px;
}
.greeting__line--blue {
  bottom: 100%;
  right: 0;
  width: 13%;
  height: 262px;
}
.greeting__line-block {
  position: relative;
  width: 100%;
  height: 100%;
}
.greeting__line--blue .greeting__line-block::before,
.greeting__line--blue .greeting__line-block::after {
  background-color: #6083c0;
}
.greeting__line--blue .greeting__line-block::after {
  left: -100%;
}
.greeting__line--green .greeting__line-block::before,
.greeting__line--green .greeting__line-block::after {
  background-color: #7bcfb7;
  left: 0;
  top: 0;
}
.greeting__line-block::before {
  position: absolute;
  content: "";
  height: 100%;
  width: 18px;
}
.greeting__line-block::after {
  position: absolute;
  content: "";
  height: 18px;
  width: 100%;
}
.greeting__search {
  position: absolute;
  bottom: -43px;
  left: 0;
  right: 0;
  width: 100%;
}
.greeting__banner-image {
  height: 450px;
  width: 100%;
  overflow: hidden;
}
.greeting__banner img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.desktop {
  object-fit: fill !important;
}

@media (max-width: 1199px) {
  .greeting__banner-image .mobile {
    display: inline;
  }

  .greeting__banner-image .desktop {
    display: none;
  }

  .greeting__line--green {
    width: 15%;
  }
  .greeting__line--blue {
    width: 6.5%;
  }
}
@media (max-width: 990px) {
  .greeting__info p {
    max-width: 400px;
  }
}
@media (max-width: 767px) {

  .greeting__banner-image {
    height: 200px;
  }

  .greeting__info {
    padding-top: 36px;
    padding-bottom: 25px;
  }
  .greeting__info h2 {
    max-width: 270px;
    font-size: 26px;
    line-height: 100%;
    margin-bottom: 16px;
  }
  .greeting__info p {
    font-size: 14px;
    line-height: 140%;
    max-width: 192px;
  }
  .greeting__line--blue {
    height: 130px;
    width: 37px;
  }
  .greeting__line--green {
    width: 73px;
    height: 142px;
    bottom: calc(100% - 52px);
  }
  .greeting__line-block::after {
    height: 8px;
  }
  .greeting__line-block::before {
    width: 8px;
  }
  .greeting__search {
    bottom: -28px;
  }
}
@media (max-width: 500px) {
  .greeting__banner img {
    width: 527px;
  }
}
</style>
