<template>
  <header class="header">
    <div class="container">
      <div class="header__wrapper">
        <div class="header__logo">
          <router-link to="/" class="block-overlay"></router-link>
          <div class="header__logo-left">
            <picture>
              <img src="@/assets/images/logo-header-1.svg" alt=""/>
            </picture>
          </div>
          <div class="header__logo-right">
            <picture>
              <img src="@/assets/images/logo-header-2.svg" alt=""/>
            </picture>
          </div>
        </div>
        <div
            :class="['header__button', { 'header__button--active': isButtonProductsActive }]"
            @click="toggleProductMenu"
        >
          <div class="header__button-overlay block-overlay"></div>
          <div class="header__button-block">
            <div class="header__button-line">
              <div class="header__button-wrapper">
                <div></div>
                <div></div>
              </div>
              <span class="header__button-name">Products</span>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6">
              <path
                  d="M1.42.088a.312.312 0 0 1 .433 0L4.5 2.676 7.147.088a.312.312 0 0 1 .434 0l1.33 1.3c.119.117.119.307 0 .424l-4.194 4.1a.31.31 0 0 1-.434 0L.09 1.812a.295.295 0 0 1 0-.424l1.33-1.3Z"
              />
            </svg>
          </div>
        </div>
        <nav class="header__nav">
          <nav-list :navItems="navListItem" :isMobile="false" :class="'header-nav'"></nav-list>
        </nav>
        <div class="header__control">
          <div class="header__phone">
            <div class="header__phone-top">
              <a class="" :href="`tel: ${designSettings?.phone ?? ''}`">{{ designSettings?.phone ?? '' }}</a>
              <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6" fill="none">
                <path
                    fill="#374061"
                    d="M1.42.088a.312.312 0 0 1 .433 0L4.5 2.676 7.147.088a.312.312 0 0 1 .434 0l1.33 1.3c.119.117.119.307 0 .424l-4.194 4.1a.31.31 0 0 1-.434 0L.09 1.812a.295.295 0 0 1 0-.424l1.33-1.3Z"
                />
              </svg>
            </div>

            <span class="header__phone-description">For all questions</span>
          </div>
          <div class="header__localizaton">
            <span>Eng</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6" fill="none">
              <path
                  fill="#374061"
                  d="M1.42.088a.312.312 0 0 1 .433 0L4.5 2.676 7.147.088a.312.312 0 0 1 .434 0l1.33 1.3c.119.117.119.307 0 .424l-4.194 4.1a.31.31 0 0 1-.434 0L.09 1.812a.295.295 0 0 1 0-.424l1.33-1.3Z"
              />
            </svg>
          </div>

          <div class="header__basket">
            <router-link to="/basket" class="block-overlay"></router-link>
            <picture>
              <img src="@/assets/images/basket.svg" alt="basket"/>
            </picture>
          </div>

          <div @click="showMobileMenu" class="header__burger">
            <div :class="['header__burger-block', { 'header__burger-block--active': isShowMobileMenu }]"></div>
          </div>
        </div>
      </div>
    </div>

    <div v-click-outside="onClickOutside" :class="['header__mobile', { 'header__mobile--visible': isShowMobileMenu }]">
      <div class="header__mobile-block">
        <div class="header__mobile-search">
          <input placeholder="Search by part number" type="text"/>
          <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" fill="none">
              <path
                  fill="#fff"
                  d="M-.002 6.692c0 3.706 3.045 6.692 6.825 6.692 3.78 0 6.825-2.986 6.825-6.692S10.603 0 6.823 0C3.043 0-.002 2.986-.002 6.692Zm6.825-4.118c2.31 0 4.2 1.853 4.2 4.118 0 2.265-1.89 4.118-4.2 4.118-2.31 0-4.2-1.853-4.2-4.118 0-2.265 1.89-4.118 4.2-4.118Z"
              />
              <path fill="#fff" d="M12.283 9.211 18 14.816 15.773 17l-5.717-5.605 2.227-2.184Z"/>
            </svg>
          </button>
        </div>
        <nav class="header__mobile-products">
          <nav-list :navItems="navMoibleMenuItems" @closeMenu="showMobileMenu"></nav-list>
        </nav>
        <nav class="header__mobile-nav">
          <nav-list :navItems="navListItem" :isMobile="true" @closeMenu="showMobileMenu"></nav-list>
        </nav>
        <div class="header__mobile-contacts">
          <a class="header__mobile-phone" :href="`tel: ${designSettings?.phone ?? ''}`">
              {{designSettings?.phone ?? ''}}</a>
          <p>{{ designSettings?.address ?? '' }}</p>
          <a class="header__mobile-mail" href="mailto:{{designSettings?.email??''}}">
            {{designSettings?.email ?? ''}}</a>
        </div>
        <div class="header__mobile-localization">
          <ul>
            <the-localization :dataLocalization="dataLocalization"></the-localization>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <product-menu :isVisibleProductMenu="isVisibleProductMenu" @closeMenu="closeProductMenu"
                @toggleMenu="toggleProductMenu"></product-menu>
</template>

<script setup>
import ProductMenu from "./ProductMenu.vue";
import NavList from "./NavList.vue";
import TheLocalization from "./TheLocalization.vue";
import useSWRV from "swrv";
import {urlSettings} from "@/functions/urlgen";
import {getDataFetcher, getSWRVOptions} from "@/functions/utils";
import {ref, watch} from "vue";

let isVisibleProductMenu = ref(false);
let isButtonProductsActive = ref(false);
let isShowMobileMenu = ref(false);
const navListItem = [
  {name: "All manufacturers", path: "/manufacturers", svg: true},
  {name: "About", path: "/about", svg: false},
//        {name: "Services", path: "/services", svg: false},
  {name: "Shipping", path: "/shipping", svg: false},
  {name: "FAQ", path: "/faq", svg: false},
  {name: "Contacts", path: "/contacts", svg: false},
];
const navMoibleMenuItems = [
  {name: "Siemens", path: "/manufacturers/siemens"},
  {name: "Omron", path: "/manufacturers"},
  {name: "Pilz", path: "/manufacturers"},
  {name: "Keyence", path: "/manufacturers"},
  {name: "Pepperl+Fuchs", path: "/manufacturers"},
  {name: "Allen-Bradley", path: "/manufacturers"},
];
const dataLocalization = [
  {name: "Eng", isActive: true},
  {name: "Pl", isActive: false},
  {name: "Ua", isActive: false},
];

let designSettings = ref(null);

const {data: designSettingsResp} = useSWRV(urlSettings('general-design'), getDataFetcher(), getSWRVOptions())

watch(designSettingsResp, () => {
  if (designSettingsResp.value) {
    designSettings.value = designSettingsResp.value.data;
  } else {
    designSettings.value = null;
  }
}, {deep: true, immediate: true});

function toggleProductMenu() {
  isVisibleProductMenu.value = !isVisibleProductMenu.value;
  isButtonProductsActive.value = !isButtonProductsActive.value;
  isVisibleProductMenu.value
      ? document.body.classList.add("body-overlay")
      : document.body.classList.remove("body-overlay");
}

function closeProductMenu() {
  isVisibleProductMenu.value = false;
  isButtonProductsActive.value = false;
  document.body.classList.remove("body-overlay");
}

function openMobileMenu() {
  if (!isShowMobileMenu) {
    isShowMobileMenu.value = true;
    document.body.classList.add("body-overlay");
  }
}

function showMobileMenu() {
  isShowMobileMenu.value = !isShowMobileMenu.value;
  if (isShowMobileMenu.value) {
    setTimeout(() => {
      document.body.classList.add("body-overlay");
    }, 100);

  } else if (!isShowMobileMenu.value) {
    setTimeout(() => {
      document.body.classList.remove("body-overlay");
    }, 100);
  }
}

function onClickOutside(e) {
  if (!(e.target.classList.contains("header__burger") || e.target.classList.contains("header__burger-block") && !isShowMobileMenu.value)
      && !(e.target.classList.contains("header__burger") || e.target.classList.contains("header__burger-block") && isShowMobileMenu.value)
      && !isVisibleProductMenu.value
  ) {
    isShowMobileMenu.value = false;
    document.body.classList.remove("body-overlay");
  }
  // if(!e.target.classList.contains("header__button")&&
  //   isVisibleProductMenu) {
  //   isVisibleProductMenu = false;
  // }
  // }, 100);
}
</script>

<style lang="scss" scoped>
.overlay {
  position: fixed;
  z-index: 98;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  width: 100vw;
  height: 100vh;
}

.header {
  position: relative;
  z-index: 51;
  border-bottom: 1px solid #f4f4f5;
}

.header__wrapper {
  padding-top: 27.15px;
  padding-bottom: 27.15px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, max-content)) 1fr minmax(0, max-content);
}

.header__logo {
  position: relative;
  display: flex;
  align-items: center;
  margin-right: 59px;
}

.header__logo-left {
  margin-right: 15px;
  width: 53px;
  height: 53px;
}

.header__logo-right {
  width: 103px;
  height: 35px;
}

.header__logo-left img,
.header__logo-right img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

.header__button {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 17px 20px;
  background-color: #f8f8f9;
  cursor: pointer;
  transition: 0.5s ease;
}

.header__button svg {
  fill: #374061;
  transition: 0.5s ease;
  position: relative;
  transform: rotate(0);
}

.header__button--active svg {
  fill: #fff;
  transition: 0.5s ease;
  transform: rotate(-180deg);
}

.header__button--active {
  background-color: #6083c0;
  transition: 0.5s ease;
}

.header__button::before {
  z-index: -1;
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #7bcfb7;
  bottom: 0;
  left: 0;
  transition: 0.5s ease;
}

.header__button--active::before {
  left: -5px;
  bottom: -5px;
  transition: 0.5s ease;
}

.header__button-block {
  display: flex;
  align-items: center;
}

.header__button-line {
  display: flex;
  align-items: center;
  margin-right: 55px;
}

.header__button-name {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  transition: 0.5s ease;
}

.header__button--active {
  color: #fff;
  transition: 0.5s ease;
}

.header__button-wrapper {
  display: flex;
  flex-direction: column;
  width: 25px;
  margin-right: 11px;
}

.header__button-wrapper div {
  width: 20px;
  height: 3px;
  background-color: #6083c0;
  margin-bottom: 3px;
  margin-left: 5px;
  transition: 0.5s ease;
}

.header__button--active .header__button-wrapper div {
  background-color: #fff;
  transition: 0.5s ease;
}

.header__button-wrapper div:last-child {
  margin-left: 0;
  margin-bottom: 0;
  background-color: #7bcfb7;
  transition: 0.5s ease;
}

.header__button--active .header__button-wrapper div:last-child {
  background-color: #fff;
  opacity: 0.5;
  transition: 0.5s ease;
}

.header__nav {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.header__control {
  position: relative;
  display: flex;
  align-items: center;
}

.header__phone {
  display: flex;
  flex-direction: column;
  margin-right: 50px;
}

.header__phone-top {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.header__phone-top a {
  color: rgb(39, 41, 48);
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 20px;
  line-height: 100%;
  text-transform: uppercase;
  display: block;
  margin-right: 6px;
}

.header__phone-description {
  font-size: 16px;
  line-height: 140%;
  opacity: 0.5;
}

.header__localizaton {
  padding: 15px 0;
  margin-right: 50px;
  display: flex;
  align-items: center;
  cursor: pointer;
}

.header__localizaton span {
  display: block;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-right: 11px;
}

.header__basket {
  position: relative;
  cursor: pointer;
  width: 31px;
  height: 27px;
}

.header__basket img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

.header__burger {
  display: none;
}

.header__mobile {
  display: none;
}

@media (max-width: 1800px) {
  .header__logo {
    margin-right: 30px;
  }
  .header__phone {
    margin-right: 25px;
  }
  .header__localizaton {
    margin-right: 25px;
  }
}

@media (max-width: 1500px) {
  .header__logo {
    margin-right: 15px;
  }
  .header__button-line {
    margin-right: 30px;
  }
  .header__phone {
    margin-right: 15px;
  }
  .header__localizaton {
    margin-right: 15px;
  }
}

@media (max-width: 1199px) {
  .header__wrapper {
    padding-top: 27.5px;
    padding-bottom: 27.5px;
  }
  .header__button,
  .header__phone,
  .header__nav,
  .header__localizaton {
    display: none;
  }
  .header__burger {
    position: relative;
    z-index: 100;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 10px 0;
  }
  .header__burger-block {
    position: relative;
    width: 30px;
    height: 12px;
    margin-left: 20px;
  }
  .header__burger-block::before {
    position: absolute;
    content: "";
    top: 0;
    width: 100%;
    height: 3px;
    background-color: #272930;
    transition: 0.5s ease;
  }
  .header__burger-block--active::before {
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    transition: 0.5s ease;
  }
  .header__burger-block::after {
    position: absolute;
    content: "";
    bottom: 0;
    width: 100%;
    height: 3px;
    background-color: #272930;
    transition: 0.5s ease;
  }
  .header__burger-block--active::after {
    bottom: 50%;
    transform: translateY(50%) rotate(-45deg);
    transition: 0.5s ease;
  }
  .header__wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .header__mobile {
    display: block;
    z-index: 99;
    position: fixed;
    top: 109px;
    right: -100%;
    opacity: 0;
    width: 320px;
    height: calc(100vh);
    background-color: #fff;
    transition: 0.5s ease;
    box-shadow: 4px 4px 17px rgba(16, 25, 57, 0.15);
  }
  .header__mobile--visible {
    opacity: 1;
    right: 0;
    transition: 0.5s ease;
  }
  .header__mobile-block {
    padding: 16px 18px;
    height: 80%;
    overflow-y: auto;
  }

  .header__mobile-search {
    height: 46px;
    display: grid;
    grid-template-columns: 1fr minmax(0, max-content);
    box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
    margin-bottom: 20px;
  }
  .header__mobile-search input {
    height: 100%;
    font-size: 14px;
    line-height: 100%;
    padding: 0 16px;
    color: rgba(39, 41, 48, 0.4);
  }
  .header__mobile-search button {
    background-color: #6083c0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 46px;
    padding: 0;
  }
  .header__mobile-contacts {
    margin-bottom: 50px;
  }
  .header__mobile-contacts p {
    font-size: 12px;
    line-height: 100%;
    color: #272930;
    opacity: 0.5;
    margin-bottom: 10px;
  }
  .header__mobile-phone {
    display: block;
    font-family: "Circe-Bold";
    font-style: normal;
    font-weight: 700;
    font-size: 20px;
    line-height: 100%;
    color: #6083c0;
    margin-bottom: 16px;
  }
  .header__mobile-mail {
    font-family: "Circe-Bold";
    font-style: normal;
    font-weight: 700;
    font-size: 12px;
    line-height: 100%;
    text-decoration-line: underline !important;
    color: #6083c0;
  }
  .header__mobile-localization ul {
    display: flex;
    align-items: center;
  }
}

@media (max-width: 767px) {
  .header__logo-left {
    width: 37px;
    height: 37px;
    margin-right: 11px;
  }
  .header__logo-right {
    width: 73px;
    height: 24px;
  }
  .header__basket {
    width: 28px;
    height: 24px;
  }
  .header__wrapper {
    padding-top: 21.5px;
    padding-bottom: 21.5px;
  }
  .header__mobile {
    top: 81px;
  }
}

@media (max-width: 600px) {
  .header__mobile {
    width: 100%;
    box-shadow: 0 0 0 rgba(255, 255, 255, 0);
  }
}
</style>