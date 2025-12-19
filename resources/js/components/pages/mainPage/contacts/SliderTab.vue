<template>
  <swiper :slidesPerView="'auto'" :space-between="22" class="slider-tab">
    <swiper-slide v-for="(item, idx) in dataContacts" :key="item.name" @click="$emit('setActiveIdx', idx)">
      <div :class="['slider-tab__wrapper', { 'slider-tab__wrapper--active': activeIdx === idx }]">
        <span>{{ item.name }}</span>
      </div>
    </swiper-slide>
  </swiper>
</template>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";

import "swiper/css";
// import { defineEmits } from "vue";

export default {
  emits: ["setActiveIdx"],
  props: {
    dataContacts: Array,
    activeIdx: Number,
  },
  components: {
    Swiper,
    SwiperSlide,
  },
};
</script>
<style>
.slider-tab {
  width: 100%;
}
.slider-tab .swiper-slide {
  width: auto;
}
.slider-tab__wrapper {
  cursor: pointer;
}
.slider-tab__wrapper {
  cursor: pointer;
  position: relative;
  font-size: 18px;
  line-height: 100%;
  padding-bottom: 4px;
}

.slider-tab__wrapper::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  width: 0;
  height: 2px;
  background-color: #6083c0;
  transition: 0.5s ease;
}
.slider-tab__wrapper--active::after {
  width: 100%;
  transition: 0.5s ease;
}
@media (max-width: 767px) {
  .slider-tab__wrapper {
    font-size: 12px;
    line-height: 100%;
  }
  .slider-tab {
    padding-right: 18px;
  }
}
</style>
