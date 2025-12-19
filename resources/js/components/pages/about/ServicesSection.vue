<template>
  <section class="services">
    <div class="container">
      <div class="services__wrapper">
        <div class="services__block">
          <div class="services__block-title">
            <block-line></block-line>
            <h2>Services</h2>
          </div>
          <ul class="services__list">
            <li
                class="services__item"
                v-for="(item, idx) in dataServices"
                :key="item.name"
                @mouseover="hoverService(idx)"
            >
              <div :class="['services__item-head', { 'services__item-head--active': idx === activeService }]">
                <div @click="showMobileTab" class="services__item-overlay block-overlay"></div>
                <span>{{ item.name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" fill="none">
                  <path
                      d="M1.104.073a.23.23 0 0 1 .337 0l2.06 2.157L5.558.073a.23.23 0 0 1 .337 0L6.93 1.157a.258.258 0 0 1 0 .353L3.67 4.927a.231.231 0 0 1-.338 0L.07 1.51a.258.258 0 0 1 0-.353L1.104.073Z"
                  />
                </svg>
                <div class="services__item-line"></div>
              </div>
              <div class="services__item-content">
                <div class="services__item-image">
                  <picture>
                    <img src="@/assets/images/about-scheme.svg" alt="about-scheme"/>
                  </picture>
                </div>
                <h3>{{ item.content.title }}</h3>
                <h4>Service includes</h4>
                <ul>
                  <li v-for="elem in item.content.list" :key="elem">
                    <div class="dot">
                      <div></div>
                    </div>
                    <span>{{ item.content.list[elem] }}</span>
                  </li>
                </ul>
                <button>
                  <router-link to="/contacts" class="block-overlay"></router-link>
                  Contact Us
                </button>
              </div>
            </li>
          </ul>
        </div>
        <div class="services__content">
          <!-- .filter((_, idx) => idx === activeService) -->
          <div
              v-for="(item, idx) in dataServices"
              :class="['services__content-block', { 'services__content-block--visible': idx === activeService }]"
              :key="item.name"
          >
            <div class="services__content-wrapper">
              <div class="services__content-image">
                <picture><img src="@/assets/images/about-scheme.svg" alt="about-scheme"/></picture>
              </div>
              <h3 v-html="item.content.title"></h3>
              <h4>Service includes</h4>
              <ul>
                <li v-for="elem in item.content.list" :key="elem">
                  <div class="dot">
                    <div></div>
                  </div>
                  <span>{{ elem }}</span>
                </li>
              </ul>
              <button>
                <router-link to="/contacts" class="block-overlay"></router-link>
                Contact Us
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import {getPageInfo, getPageBlocks, getParam, paramsToArray} from "../../../functions/dataload";
import BlockLine from "@/components/ui/BlockLine.vue";

export default {
  components: {BlockLine},
  data() {
    return {
      activeService: 0,
      dataBlocks: [],
      dataServices: [],
      // {
      //   name: "Express repair 24/7",
      //   content: {
      //     title:
      //       "Our engineers can test servo motors, rewind PMSM, BLDC, DC motors, replace commutators in DC motors, etc.",
      //     list: [
      //       "Engine diagnostics",
      //       "Maintenance of wear parts",
      //       "Changing Lubricants",
      //       "Collection of components",
      //       "Engine diagnostics",
      //       "Maintenance of wear parts",
      //     ],
      //   },
      // },
    };
  },
  mounted() {
    this.loadData('about-services')
        .then(() => {
          this.dataServices = [];
          for (const i in this.dataBlocks) {
            this.dataServices.push(this.mapServicesBlock(this.dataBlocks[i]));
          }
        });

  },
  methods: {
    showMobileTab(e) {
      e.target.parentNode.parentNode.classList.toggle("services__item--active");
    },
    hoverService(idx) {
      if (window.innerWidth > 990) {
        this.activeService = idx;
      }
    },
    async loadData(pagename) {
      this.dataBlocks = await getPageBlocks(pagename);
    },
    mapServicesBlock(block) {
      return {
        name: block.name,
        content:
            {
              title: block.content,
              list: paramsToArray(block.params),
            }
      }
    }
  },
};
</script>

<style scoped>
.services__item-overlay {
  display: none;
}

.services__block-title {
  display: flex;
  align-items: center;
  margin-bottom: 82px;
}

.services__block-title h2 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
}

.services__block {
  background-color: #f8f8f9;
  padding: 50px 0 150px 69px;
}

.services__wrapper {
  position: relative;
  display: grid;
  grid-template-columns: minmax(0, 553px) 1fr;
  column-gap: 90px;
  padding-bottom: 68px;
}

.services__item-head {
  cursor: pointer;
}

.services__content-block {
  max-width: 733px;
  top: 10%;
  opacity: 0;
  position: absolute;
  pointer-events: none;
  transition: 0.5s ease;
}

.services__content-block--visible {
  opacity: 1;
  pointer-events: auto;
  transition: 0.5s ease;
}

.services__item {
  margin-bottom: 42px;
}

.services__item:last-child {
  margin-bottom: 0;
}

.services__item-head {
  position: relative;
}

.services__item-line {
  position: absolute;
  right: 0%;
  top: 50%;
  transform: translate(50%, -50%);
  width: 113px;
  height: 2px;
  background: #6083c0;
  opacity: 0;
  pointer-events: none;
  transition: 0.5s ease;
}

.services__item-head span {
  font-size: 28px;
  line-height: 100%;
  opacity: 0.3;
  transition: 0.5s ease;
}

.services__item-head--active span {
  opacity: 1;
  transition: 0.5s ease;
  color: #6083c0;
}

.services__item-head--active .services__item-line {
  opacity: 1;
  transition: 0.5s ease;
}

.services__content {
  position: relative;
}

.services__content-wrapper {
  position: relative;
}

.services__content-image {
  position: absolute;
  right: 0;
  bottom: -40px;
  width: 307px;
  height: 855px;
}

.services__content-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.services__content-block h3 {
  font-size: 36px;
  line-height: 100%;
  margin-bottom: 47px;
}

.services__content-block h4 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-bottom: 17px;
}

.dot {
  width: 22px;
  height: 22px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-right: 6px;
}

.dot div {
  width: 6px;
  height: 6px;
  background: #6083c0;
}

.services__content-block ul {
  margin-bottom: 65px;
}

.services__content-block li {
  display: flex;
  align-items: center;
  margin-bottom: 6px;
}

.services__content-block li:last-child {
  margin-bottom: 0;
}

.services__content-block li span {
  font-size: 16px;
  line-height: 140%;
}

.services__content-block button {
  position: relative;
  z-index: 2;
  width: 211px;
  height: 64px;
  color: #fff;
  background: #6083c0;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 130%;
}

.services__content-block button:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
}

.services__content-block button:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
}

.services__item-head svg,
.services__item-content {
  display: none;
}

@media (max-width: 1400px) {
  .services__block {
    padding-left: 30px;
  }

  .services__wrapper {
    grid-template-columns: minmax(0, 500px) 1fr;
  }
}

@media (max-width: 1199px) {
  .services__content-block h3 {
    font-size: 30px;
    line-height: 100%;
    margin-bottom: 20px;
  }

  .services__block {
    padding-bottom: 100px;
  }

  .services__item-line {
    width: 60px;
  }

  .services__wrapper {
    column-gap: 50px;
    grid-template-columns: minmax(0, 430px) 1fr;
  }

  .services__item-head span {
    font-size: 23px;
  }

  .services__item {
    margin-bottom: 35px;
  }

  .services__content-block {
    top: 5%;
  }

  .services__content-image {
    bottom: 0%;
    width: 271px;
    height: 761px;
  }
}

@media (max-width: 990px) {
  .services__item-overlay {
    display: block;
  }

  .services__block-title h2 {
    font-size: 14px;
    line-height: 100%;
  }

  .services__item--active .services__item-content {
    display: block;
  }

  .services__item--active .services__item-head svg {
    opacity: 1;
    transform: rotate(-180deg);
    transition: 0.5s ease;
  }

  .services__item--active .services__item-head svg path {
    fill: #6083c0 !important;
    transition: 0.5s ease;
  }

  .services__item--active .services__item-head span {
    color: #6083c0 !important;
    transition: 0.5s ease;
  }

  .services__item-content {
    position: relative;
  }

  .services__item-image {
    right: 0;
    bottom: 95px;
    position: absolute;
    width: 171px;
    height: 100%;
  }

  .services__item-image img {
    width: 100%;
    height: 100%;
    object-fit: scale-down;
  }

  .services__item-content button {
    position: relative;
    width: 100%;
    height: 52px;
    background: #6083c0;
    font-family: "Circe";
    font-style: normal;
    font-weight: 700;
    font-size: 14px;
    line-height: 130%;
    color: #ffffff;
    margin-top: 49px;
  }

  .services__item-content {
    padding: 18px 18px 23px 18px;
  }

  .services__item:last-child .services__item-content {
    padding-bottom: 0;
  }

  .services__item-content h3 {
    position: relative;
    z-index: 2;
    font-size: 18px;
    line-height: 100%;
    margin-bottom: 26px;
    max-width: 600px;
  }

  .services__item-content h4 {
    font-family: "Circe-Bold";
    font-style: normal;
    font-weight: 700;
    font-size: 14px;
    line-height: 100%;
    margin-bottom: 14px;
  }

  .services__item-content li {
    display: flex;
    align-items: center;
  }

  .dot {
    width: 17px;
    height: 17px;
  }

  .dot div {
    width: 5px;
    height: 5px;
  }

  .services__item-content li span {
    font-size: 12px;
    line-height: 140%;
  }

  .services__block {
    background-color: transparent;
    padding-left: 0;
    padding-bottom: 0;
  }

  .services__content,
  .services__item-line {
    display: none;
  }

  .services__wrapper {
    grid-template-columns: 1fr;
  }

  .services__block-title {
    margin-bottom: 17px;
  }

  .services__item-head span {
    font-size: 18px;
    line-height: 100%;
    opacity: 1;
  }

  .services__item-head--active span {
    color: #272930;
    opacity: 1;
  }

  .services__item-head {
    background-color: #f8f8f9;
  }

  .services__item {
    margin-bottom: 6px;
  }

  .services__item-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 27px 20px 18px;
  }

  .services__item-head svg {
    display: block;
    opacity: 0.3;
    transition: 0.5s ease;
    position: relative;
    transform: rotate(0);
  }

  .services__item-head svg path {
    fill: #374061;
    transition: 0.5s ease;
  }
}

@media (max-width: 767px) {
  .services__item-head {
    position: relative;
    z-index: 2;
  }

  .services__block-title {
    padding: 0 18px;
  }

  .services .container {
    padding: 0;
  }

  .services__item-head span {
    max-width: 252px;
  }
}

@media (max-width: 600px) {
  .services__item-content h3 {
    max-width: 252px;
  }
}
</style>