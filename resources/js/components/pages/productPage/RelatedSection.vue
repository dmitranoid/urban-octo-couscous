<template>
  <section :class="[{ related: isRelated }, { recomended: !isRelated }]">
    <div class="head-block">
      <h2>{{ title }}</h2>
      <div class="control-block">
        <button ref="next" class="control-block__button control-block__button--next">
          <img src="@/assets/images/related-arrow-prev.svg" alt="arrow" />
        </button>
        <button ref="prev" class="control-block__button control-block__button--prev">
          <img src="@/assets/images/related-arrow-next.svg" alt="arrow" />
        </button>
      </div>
    </div>
    <swiper
      :navigation="{ nextEl: prev, prevEl: next, disabledClass: 'control-block__disabled' }"
      :breakpoints="{
        1200: { slidesPerView: 4 },
        990: { slidesPerView: 3 },
        320: {
          slidesPerView: 2,
        },
      }"
      :modules="modules"
      class="swiper-block"
    >
      <swiper-slide v-for="item in dataProducts" :key="item.name">
        <card-product :dataProduct="item" :isModalProduct="isModalProduct"></card-product>
      </swiper-slide>
    </swiper>
  </section>
</template>

<script>
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation } from "swiper";

import CardProduct from "@/components/ui/CardProduct.vue";

import "swiper/css/navigation";
import "swiper/css";
export default {
  props: {
    title: String,
    dataProducts: Array,
    isRelated: {
      type: Boolean,
      default: false,
    },
    isModalProduct: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    Swiper,
    SwiperSlide,
    CardProduct,
  },
  setup() {
    const prev = ref(null);
    const next = ref(null);

    return {
      modules: [Navigation],
      prev,
      next,
    };
  },
};
</script>
<style scoped>
.recomended .head-block {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 30px;
}
.recomended .head-block h2 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 22px;
  line-height: 100%;
}
.recomended .swiper-block {
  padding-bottom: 47px;
}
.control-block__button {
  opacity: 1;
  transition: 0.5s ease;
}
.control-block__disabled {
  opacity: 0.5;
  transition: 0.5s ease;
}
.related .swiper-block {
  padding-bottom: 80px;
}
.related .head-block h2 {
  font-size: 36px;
  line-height: 100%;
}
.related .head-block {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 48px;
}
@media (max-width: 767px) {
  .recomended .head-block h2 {
    font-size: 16px;
    line-height: 100%;
  }
  .recomended .head-block {
    margin-bottom: 22px;
    padding: 0 18px;
  }
  .related .swiper-block {
    padding-bottom: 0px;
  }
  .related .head-block h2 {
    font-size: 22px;
    line-height: 100%;
  }
  .related .head-block {
    padding: 0 18px;
    margin-bottom: 28px;
  }
}
</style>
