<template>
  <div class="thanks">
    <div class="thanks__wrapper">
      <div class="thanks__info">
        <div class="thanks__info-block">
          <div class="thanks__info-ok">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" fill="none">
              <path
                fill="#61AD98"
                fill-rule="evenodd"
                d="M6.816 8.278 13.94 0l3.225 2.542L7.305 14 .832 8.58l2.752-3.01 3.232 2.708Z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
          <h2 class="thanks__info-title">Thank you for your trust!</h2>
          <span class="thanks__info-text">Your request number</span>
          <span class="thanks__info-number">{{code}}</span>
        </div>
      </div>
      <div class="thanks__wrapper-image">
        <picture>
          <img src="@/assets/images/thanks-page.jpg" alt="" />
        </picture>
      </div>
    </div>
  </div>
</template>

<script>
import router from "@/router";

export default {
  data() {
    return {
      code : this.$route.query.code
    }
  }
};
</script>

<style scoped>
.thanks__wrapper {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  /* min-height: 65vh; */
}
.thanks__wrapper-image {
  max-height: 660px;
  width: 100%;
}
.thanks__wrapper-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.thanks__info-ok {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  border: 2px solid #e9eaea;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
}
.thanks__info-title {
  font-size: 46px;
  line-height: 100%;
  margin-bottom: 34px;
  padding-right: 20px;
}
.thanks__info-text {
  display: block;
  margin-bottom: 9px;
  font-size: 18px;
  line-height: 100%;
  opacity: 0.5;
}
.thanks__info-number {
  font-size: 26px;
  line-height: 100%;
}
.thanks__info {
  position: relative;
}
.thanks__info-block {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  height: auto;
  left: 24.5%;
}
@media (max-width: 1400px) {
  .thanks__info-block {
    left: 12.5%;
  }
}
@media (max-width: 990px) {
  .thanks__wrapper {
    display: flex;
    flex-direction: column;
  }
  .thanks__info-block {
    position: static;
    transform: translateY(0%);
  }
  .thanks__wrapper-image {
    max-height: unset;
    height: 330px;
    order: -1;
    margin-bottom: 37px;
  }
  .thanks__info {
    padding-left: 18px;
    padding-right: 18px;
    padding-bottom: 49px;
  }
}
@media (max-width: 767px) {
  .thanks__info-ok {
    width: 50px;
    height: 50px;
    margin-bottom: 24px;
  }
  .thanks__info-ok svg {
    position: relative;
    transform: scale(0.7);
  }
  .thanks__info-title {
    font-size: 26px;
    line-height: 100%;
    margin-bottom: 20px;
    padding-right: 0;
  }
  .thanks__info-text {
    font-size: 14px;
    line-height: 100%;
    margin-bottom: 7px;
  }
  .thanks__info-number {
    font-size: 18px;
    line-height: 100%;
  }
}
@media (max-width: 500px) {
  .thanks__wrapper-image {
    height: 215px;
  }
}
</style>