<template>
  <div class="slider__catalog">
    <swiper
      :slides-per-view="'auto'"
      :freeMode="true"
      :scrollbar="{
        draggable: true,
      }"
      :breakpoints="{
        768: {
          spaceBetween: 0,
        },
        320: {
          spaceBetween: 6,
        },
      }"
      :modules="modules"
      class="mySwiper"
    >
      <swiper-slide v-for="item in dataSlideCatalog" :key="item.name">
        <div class="slider__catalog-block">
          <router-link
              :to="{
                  name: 'category',
                  params: {
                      manufacturer: item.manufacturer.slug,
                      submanufacturer: item.slug
                  }
              }"
              class="block-overlay">
          </router-link>
          <div class="slider__catalog-image">
            <picture>
              <img :src="getImgUrl(item.image)" :alt="item.name" />
            </picture>
          </div>
          <h3 class="slider__catalog-name">{{ item.name }}</h3>
          <div class="slider__catalog-line"></div>
        </div>
      </swiper-slide>
    </swiper>
  </div>
</template>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/scrollbar";
import { Scrollbar, FreeMode } from "swiper";

export default {
  props: {
    dataSlideCatalog: Array,
  },
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    return {
      modules: [Scrollbar, FreeMode],
    };
  },
};
</script>
<style>
.slider__catalog {
  padding-left: 12.1%;
  margin-bottom: 43px;
}
.slider__catalog .swiper-slide {
  width: 208px;
  height: 237px;
  border: 2px solid #f4f4f5;
  border-right: none;
  padding-top: 27px;
}
.slider__catalog-block {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.slider__catalog .swiper-slide:last-child {
  border-right: 2px solid #f4f4f5;
}
.slider__catalog-image {
  width: 107px;
  height: 107px;
  margin-bottom: 42px;
}
.slider__catalog-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
.slider__catalog-name {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-bottom: 6px;
  height: 18px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
}
.slider__catalog .swiper-scrollbar {
  pointer-events: none;
  opacity: 0;
}
.slider__catalog-line {
  position: relative;
  width: 32px;
  height: 9px;
}
.slider__catalog-line::after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  width: 26px;
  height: 3px;
  background-color: #6083c0;
}
.slider__catalog-line::before {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 26px;
  height: 3px;
  background-color: #7bcfb7;
}
@media (max-width: 1400px) {
  .slider__catalog {
    padding-left: 6.1%;
  }
}
@media (max-width: 767px) {
  .slider__catalog {
    margin-bottom: 27px;
    padding-left: 16px;
  }
  .slider__catalog .swiper {
    padding-bottom: 23px;
  }
  .slider__catalog .swiper-slide {
    width: 114px;
    height: 127px;

    border-right: 2px solid #f4f4f5;
    padding-top: 13px;
  }
  .slider__catalog-image {
    width: 61px;
    height: 61px;
    margin-bottom: 12px;
  }
  .slider__catalog-name {
    font-size: 14px;
    line-height: 100%;
    margin-bottom: 6px;
    height: 14px;
  }
  .slider__catalog .swiper-scrollbar {
    pointer-events: auto;
    opacity: 1;
    bottom: 0px;
    width: calc(100vw - 100px);
    height: 3px;
  }
  .swiper-scrollbar-drag {
    background-color: #7bcfb7;
    border-radius: 0;
  }
}
@media (max-width: 400px) {
  .slider__catalog .swiper-scrollbar {
    width: 284px;
  }
}
</style>