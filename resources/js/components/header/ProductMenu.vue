<template>
  <div @click="$emit('toggleMenu')" v-if="isVisibleProductMenu" class="overlay"></div>
  <div v-click-outside="onClickOutside" :class="['menu', { 'menu--visible': isVisibleProductMenu }]">
    <div class="container">
      <div class="menu__wrapper">
        <div class="menu__search">
          <search-block></search-block>
        </div>
        <div class="menu__content">
          <ul class="menu__list">
            <li
                v-for="(item, idx) in dataMenuProduct"
                :class="['menu__item', { 'menu__item--hover': idx === activeIdx }]"
                :key="item.name"
                @mouseover="setActiveIdx(idx)"
            >
              <div class="menu__line">
                <div class="menu__line-block"></div>
              </div>
              <span>{{ item.name }}</span>
            </li>
            <li class="menu__item menu__item--all">
              <router-link @click="$emit('toggleMenu')" to="/manufacturers"
                           class="block-overlay"></router-link>
              <span>All manufacturers</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none">
                <path
                    fill="#6083C0"
                    fill-rule="evenodd"
                    d="M1.182 0h10.636C12.471 0 13 .53 13 1.182v10.636h-2.364V4.035l-8.22 8.22-1.67-1.672 8.219-8.22H1.182V0Z"
                    clip-rule="evenodd"
                />
              </svg>
            </li>
          </ul>
          <div class="menu__container" v-if="activeManufacturer">
            <div class="menu__block">
              <div class="menu__card">
                <router-link
                    @click="$emit('toggleMenu')"
                    :to="{ name: 'manufacturer', params: { manufacturer: activeManufacturer.slug } }"
                    class="block-overlay"
                ></router-link>
                <div class="menu__card-logo">
                  <picture>
                    <img :src=activeManufacturer.image alt="logo"/>
                  </picture>
                </div>
                <span>View all</span>
              </div>
              <div class="menu__card" v-for="item in activeManufacturer.categories" :key="item">
                <router-link
                    :to="{ name: 'category', params: { manufacturer: item.manufacturer.slug, submanufacturer: item.slug}}"
                    @click.native="$emit('toggleMenu')"
                    class="block-overlay">
                </router-link>
                <div class="menu__card-image">
                  <picture><img :src=item.image alt="logo"/></picture>
                </div>
                <span>{{ item.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import SearchBlock from "@/components/ui/SearchBlock.vue";
import useSWRV from "swrv";
import LocalStorageCache from "swrv/esm/cache/adapters/localStorage";
import {axiosFetcher} from "@/functions/dataload";
import {urlManufacturersMenu} from "@/functions/urlgen";
import {getSWRVOptions} from "@/functions/utils";

const emits = defineEmits(["toggleMenu", "closeMenu"])
const props = defineProps({
  isVisibleProductMenu: Boolean,
})

let activeIdx = 0;
let dataMenuProduct = ref(null);
let activeManufacturer = ref(null);

const {data: respManufacturers} = useSWRV(
    urlManufacturersMenu(5, 20),
    axiosFetcher,
    getSWRVOptions()
)

watch(respManufacturers, () => {
      if (respManufacturers.value) {
        dataMenuProduct.value = respManufacturers.value.data;
        setActiveIdx(activeIdx );
      } else {
        dataMenuProduct.value = null;
      }
    },
    {deep: true, immediate: true}
)

function setActiveIdx(idx) {
  activeIdx = idx;
  const manufacturers = dataMenuProduct.value ? dataMenuProduct.value.filter((item, i) => i === activeIdx) : [];
  activeManufacturer.value = manufacturers.shift();
}

function onClickOutside(e) {
  if (!e.target.classList.contains("header__button-overlay")) {
    emits('closeMenu');
  }
}

function getImgUrl(pic) {
  return "/assets/images/" + pic;
}

</script>

<style scoped>
.menu__card-image {
  width: 107px;
  height: 107px;
}

.menu__card-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

.menu .container {
  height: 100%;
}

.menu__container {
  height: 479px;
}

.menu__block {
  height: 100%;
  overflow-y: auto;
  padding-right: 41px;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
}

.menu__card {
  position: relative;
  width: 100%;
  height: 237px;
  border: 1px solid #f4f4f5;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.menu__card span {
  position: absolute;
  font-size: 14px;
  line-height: 100%;
  bottom: 27px;
  left: 50%;
  transform: translateX(-50%);
}

.menu__item--hover .menu__line {
  opacity: 1;
  transition: 0.9s ease;
}

.menu__line {
  opacity: 0;
  pointer-events: none;
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 25px;
  height: 9px;
}

.menu__line-block {
  width: 100%;
  height: 100%;
  position: relative;
}

.menu__line-block::before {
  position: absolute;
  content: "";
  top: 0;
  right: 0;
  width: 20px;
  height: 3px;
  background: #6083c0;
}

.menu__line-block::after {
  position: absolute;
  content: "";
  bottom: 0;
  left: 0;
  width: 20px;
  height: 3px;
  background: #7bcfb7;
}

.overlay {
  position: fixed;
  width: 100vw;
  height: 100vh;
  left: 0;
  top: 124px;
  right: 0;
  bottom: 0;
  z-index: 49;
  background: #272930;
  opacity: 0.2;
}

.menu {
  opacity: 0;
  pointer-events: none;
  position: fixed;
  top: 100px;
  left: 0;
  right: 0;
  width: 100vw;
  height: 715px;
  background-color: #fff;
  z-index: 50;
  transition: 0.5s ease;
}

.menu--visible {
  opacity: 1 !important;
  pointer-events: auto !important;
  top: 124px !important;
  transition: 0.5s ease;
}

.menu__wrapper {
  padding-top: 43px;
}

.menu__search {
  margin-bottom: 44px;
}

.menu__content {
  display: grid;
  grid-template-columns: minmax(0, 344px) 1fr;
}

.menu__list {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding-top: 31px;
}

.menu__item {
  position: relative;
  display: flex;
  align-items: center;
  cursor: pointer;
  margin-bottom: 28px;
}

.menu__item--hover {
  padding-left: 0px;
  transition: 0.5s ease;
}

.menu__item--hover {
  padding-left: 41px;
  transition: 0.5s ease;
}

.menu__item:nth-last-child(-2n + 2) {
  margin-bottom: 99px;
}

.menu__item:last-child {
  margin-bottom: 0;
}

.menu__item span {
  font-size: 26px;
  line-height: 100%;
}

.menu__item--all {
  padding-left: 0;
}

.menu__item--all span {
  color: #5b78aa;
  display: block;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-right: 9px;
}

@media (max-width: 1400px) {
  .menu__content {
    grid-template-columns: minmax(0, 239px) 1fr;
  }
}
</style>