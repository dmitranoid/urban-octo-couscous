<template>
  <section class="product">
    <div class="container">
      <div class="product__wrapper">
        <div class="product__head">
          <the-breadcrumbs></the-breadcrumbs>
        </div>
        <div class="product__block">
          <div class="product__info">
            <div class="product__info-title">
              <ContentLoader v-if="!dataProduct.name"
                             style="margin-right: 10px"
                             :width="300"
                             :height="30"
              ></ContentLoader>
              <h2 v-else >{{ dataProduct.sku }}</h2>
              <span>New Sealed</span>
            </div>
            <p class="product__info-description">
              <ContentLoader v-if="!dataProduct.name"
                :width="300"
                :height="20"
              ></ContentLoader>
              <template v-else>{{ dataProduct.name }}</template>
            </p>
            <div class="product__content">
              <div class="product__availability">
                <div class="product__availability-logo">
                  <img v-if="'manufacturer' in dataProduct" :src="dataProduct.manufacturer.image" alt="logo-product"/>
                </div>
                <div class="product__availability-info">
                  <h3>Availability:</h3>
                  <ContentLoader v-if="!dataProduct.name"
                                 :width="100"
                                 :height="20"
                  ></ContentLoader>
                  <template v-else>
                    <p v-if=" Math.floor(dataProduct.stock) === 0" >Out of stock </p>
                    <p v-else >More than {{ Math.floor(dataProduct.stock) }} in stock</p>
                  </template>
                </div>
              </div>
              <div class="product__content-image">
                <div>
                  <ContentLoader v-if="!dataProduct.image" view-box="0 0 500 500"
                    :width="280"
                    :height="280"
                    :animate=true
                  >
                    <path d="M484.52,64.61H15.65C7.1,64.61.17,71.2.17,79.31V299.82c0,8.12,6.93,14.7,15.48,14.7H484.52c8.55,0,15.48-6.58,15.48-14.7V79.31C500,71.2,493.07,64.61,484.52,64.61Zm-9,204.34c0,11.84-7.14,21.44-15.94,21.44H436.39L359.16,171.52c-7.1-10.92-19.67-11.16-27-.51L258.64,277.94C253.78,285,245.73,286,240,280.2l-79.75-80.62c-6-6.06-14.33-5.7-20,.88L62.34,290.39H40.63c-8.8,0-15.94-9.6-15.94-21.44V110.19c0-11.84,7.14-21.44,15.94-21.44H459.54c8.8,0,15.94,9.6,15.94,21.44Z" />
                    <ellipse cx="120" cy="140" rx="28" ry="28" />
                  </ContentLoader>
                  <img v-else :src="dataProduct.image" :alt="dataProduct.name"/>
                </div>
              </div>

              <CodeLoader v-if="!dataProduct.description" :width="500" :height="90"> </CodeLoader>
              <p v-else class="product__content-description" v-html="dataProduct.description"></p>
              <p class="product__content-description2">
                The image is purely indicative, it may not fully reflect the product and it may show accessories not
                included.
              </p>
              <template v-if="dataProduct.files">
                <ul>
                <template v-for="file in dataProduct.files" :key="file.relativeUrl">
                  <li><a class="product__content-download" :href="file.relativeUrl" download>
                    <img src="@/assets/images/PDF.svg" alt="datasheet"/>
                    <span>Technical Data Sheet</span>
                  </a>
                  </li>
                </template>
                </ul>
              </template>
            </div>
          </div>
          <div class="product__order">
            <div class="product__order-block product__order-block--test">
              <div class="product__order-line product__order-line--green"></div>
              <div class="product__order-line product__order-line--blue"></div>
              <h3 class="product__order-title">Get a price on request</h3>
              <p class="product__order-description">Ask for quote</p>
              <div class="product__count">
                <block-count
                    v-on:change-product-qty="changeProductQty"
                >
                </block-count>
              </div>
              <button
                  @click="toggleModalForm"
                  class="product__button product__button-feedback product__button-feedback--test"
              >
                <div class="product__button-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14">
                    <path
                        d="M1.854 13.98c-.4 0-.752-.154-1.06-.462-.307-.307-.461-.66-.461-1.06V1.543c0-.4.154-.752.461-1.06.308-.307.66-.461 1.06-.461h14.291c.4 0 .753.154 1.06.461.308.308.461.66.461 1.06v10.916c0 .4-.153.753-.46 1.06-.308.308-.662.461-1.06.461H1.853ZM9 7.603 1.854 2.98v9.48h14.291v-9.48L9 7.604Zm0-1.479 7.145-4.583H1.875L9 6.125ZM1.77 2.98V1.542v10.916V2.98Z"
                    />
                  </svg>
                  <span>Quick request</span>
                  <!-- <span>Quick Request</span> -->
                </div>
              </button>
              <button @click="toggleModalProduct" class="product__button product__button-request">
                <div class="product__button-block">
                  <div class="product__button-circle"></div>
                  <span>Add to request list</span>
                </div>
              </button>
              <ul class="product__list">
                <li v-if="dataProduct.features?.warranty?.isActive" class="product__list-item">
                  <div class="product__list-image">
                    <img src="@/assets/images/feedback-svg-1.svg" alt="feedback-svg"/>
                  </div>
                  <span>12-month warranty</span>
                </li>
                <li v-if="dataProduct.features?.delivery?.isActive" class="product__list-item">
                  <div class="product__list-image">
                    <img src="@/assets/images/feedback-svg-2.svg" alt="feedback-svg"/>
                  </div>
                  <span>Global delivery</span>
                </li>
                <li v-if="dataProduct.features?.dispatch?.isActive" class="product__list-item">
                  <div class="product__list-image">
                    <img src="@/assets/images/feedback-svg-3.svg" alt="feedback-svg"/>
                  </div>
                  <span>Immediate dispatch</span>
                </li>
              </ul>
            </div>
          </div>
          <div class="product__consultation">
            <h3>Need consultation?</h3>
            <p>Ask our team now</p>
            <div class="product__consultation-contacts">
              <a class="product__consultation-phone" href="tel:+48786434232">+48 786 434 232</a>
              <span></span>
              <a class="product__consultation-mail" href="mailto:info@etrade-ag.com">info@etrade-ag.com</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="related__wrapper">
    <div class="container">
      <related-section title="Related products" :isRelated="true" :dataProducts="dataRelated"></related-section>
    </div>
  </div>
  <questions-section></questions-section>
  <feedback-block></feedback-block>
  <modal-form v-if="isVisibleModalForm" @toggle-modal="toggleModalForm"
              :product-name="dataProduct.name"
              :product-sku="dataProduct.sku"
              :qty="requestQty" >
  </modal-form>
  <modal-product 
    v-if="isVisibleModalProduct"
    :related-products="dataRelated"
    :manufacturer-product="$route.params.manufacturer"
    :product-info="dataProduct"
    :product-qty="requestQty"
    @toggle-modal="toggleModalProduct"
    >
  </modal-product>
</template>

<script>
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import RelatedSection from "./RelatedSection.vue";
import QuestionsSection from "@/components/pages/mainPage/questions/QuestionsSection.vue";
import FeedbackBlock from "@/components/pages/mainPage/feedback/FeedbackBlock.vue";
import ModalForm from "./ModalForm.vue";
import ModalProduct from "./ModalProduct.vue";
import BlockCount from "@/components/ui/BlockCount.vue";
import axios from "axios";
import {CodeLoader, ContentLoader} from "vue-content-loader";


export default {
  created() {
  },
  
  mounted() {

    window.scrollTo({
      top: 1,
      behavior: "smooth",
    });

    this.loadData(
        this.$route.params.manufacturer,
        this.$route.params.submanufacturer,
        this.$route.params.product
    );
  },
  computed: {
    pathDocument() {
      return {
        ...this.dataProduct,
        doc: this.dataProduct && "/doc.pdf",
//        doc: this.dataProduct && require(`${this.dataProduct.doc}`),
      };
    },
    pathImage() {
      return {
        ...this.dataProduct,
        image: this.dataProduct && this.dataProduct.image,
      };
    },
  },
  components: {
    CodeLoader,
    ContentLoader,
    TheBreadcrumbs, RelatedSection, QuestionsSection, FeedbackBlock, ModalForm, ModalProduct, BlockCount},
  data() {
    return {
      dataProduct: {},
      isVisibleModalForm: false,
      isVisibleModalProduct: false,
      requestQty: 1,
      dataRelated: [
        // {
        //   name: "6EP1961-2BA11",
        //   description:
        //     "SITOP PSE200U 3 A Selectivity module 4-channel input: 24 V DC/12 A output: 24 V DC/4x 3 A threshold value adjustable 0.5-3 A with common signaling contact *Ex approval no longer available*",
        //   image: "siemens/6EP1961-2BA11.jpg",
        //   path: "/manufacturers/siemens/s7-200/6EP1961-2BA11",
        //   doc: "@/assets/documents/6EP1961-2BA11.pdf",
        // },
      ],
      dataManufacturer: {},
      dataCategory: {},
    };
  },
  watch: {
    $route() {
      const nameProduct = this.$route.path
          .split("/")
          .filter((item) => item !== "")
          .at(-1);
      this.dataProduct = this.dataRelated.filter((item) => item.slug === nameProduct)[0];
      this.loadData(this.dataProduct.slug);

      window.scrollTo({
        top: 1,
        behavior: "smooth",
      });
    },
  },
  provide() {
    return {
      dataProducts: this.dataRelated,
    };
  },

  methods: {
    getImgUrl() {
      return "/assets/images/" + this.dataProduct.image;
    },

    toggleModalForm() {
      this.isVisibleModalForm = !this.isVisibleModalForm;
      this.isVisibleModalForm
          ? document.body.classList.add("body-overlay")
          : document.body.classList.remove("body-overlay");
    },
    toggleModalProduct() {
      this.isVisibleModalProduct = !this.isVisibleModalProduct;
      this.isVisibleModalProduct
          ? document.body.classList.add("body-overlay")
          : document.body.classList.remove("body-overlay");
    },

    async loadData(manufacturer, category, slug) {
      this.dataProduct = await this.getProduct(slug);
      this.dataRelated = await this.getProductRelated(this.dataProduct.id);
    },

    async getProduct(slug) {
      const response = await axios.get("/api/products/byslug/" + slug);
      return response.data.data;
    },
    async getProductRelated(product_id) {
      const response = await axios.get("/api/products/" + product_id + "/related");
      return response.data.data;
    },
    changeProductQty(value) {
      this.requestQty = value;
    }

  },
};
</script>

<style scoped>
.related__wrapper {
  padding-bottom: 30px;
}

.product__list {
  display: flex;
  align-items: center;
}

.product__list-item {
  padding-left: 41px;
  padding-right: 45px;
  border-right: 2px solid #f4f4f5;
}

.product__list-item:first-child {
  padding-left: 0;
  padding-right: 28px;
}

.product__list-item:last-child {
  border-right: none;
  padding-right: 0;
}

.product__list-item span {
  display: block;
  font-size: 18px;
  line-height: 100%;
  max-width: 79px;
}

.product__wrapper {
  padding-top: 37px;
  padding-bottom: 110px;
}

.product__head {
  margin-bottom: 37px;
}

.product__block {
  display: grid;
  grid-template-columns: minmax(0, 730px) 1fr;
  column-gap: 20px;
}

.product__info {
  padding-top: 33px;
}

.product__info-title {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.product__info-title h2 {
  font-size: 32px;
  line-height: 100%;
  margin-right: 12px;
}

.product__info-title span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  color: #61ad98;
  padding: 6px 5px;
  background-color: rgba(123, 207, 183, 0.3);
}

.product__info-description {
  font-size: 17.5px;
  line-height: 130%;
  opacity: 0.5;
  margin-bottom: 38px;
}

.product__availability {
  display: flex;
  align-items: center;
  padding-bottom: 32px;
  border-bottom: 2px solid rgba(244, 244, 245, 1);
  margin-bottom: 32px;
}

.product__availability-logo {
  width: 131px;
  height: 82px;
  border: 2px solid rgba(244, 244, 245, 1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-right: 33px;
}

.product__availability-info {
  font-size: 18px;
  line-height: 110%;
}

.product__availability-info h3 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
}

.product__availability-info p {
  color: rgba(39, 41, 48, 0.6);
}

.product__availability-logo img {
  width: 76px;
  height: 50px;
  object-fit: scale-down;
}

.product__content {
  display: grid;
  grid-template-columns: 1fr minmax(0, max-content);
  grid-template-rows: repeat(3, minmax(0, max-content));
  column-gap: 17px;
}

.product__order {
  grid-column: 2 / 3;
  grid-row: 1 / 3;
}

.product__info {
  grid-column: 1 / 2;
  grid-row: 1 / 2;
}

.product__content-image {
  grid-column: 2 / 3;
  grid-row: 1 / 4;
}

.product__content-image div {
  width: 238px;
  height: 238px;
}

.product__content-image div img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

.product__content-description {
  font-size: 17.5px;
  line-height: 130%;
  opacity: 0.5;
  border-bottom: 2px solid rgba(244, 244, 245, 1);
  margin-bottom: 18px;
  padding-bottom: 18px;
}

.product__content-description2 {
  font-size: 14px;
  line-height: 100%;
  opacity: 0.5;
  margin-bottom: 18px;
}

.product__content-download {
  cursor: pointer;
  display: flex;
  align-items: center;
  padding-bottom: 28px;
  border-bottom: 2px solid rgba(244, 244, 245, 1);
  margin-bottom: 55px;
}

.product__content-download img {
  width: 36px;
  height: 36px;
  object-fit: scale-down;
  margin-right: 9px;
}

.product__content-download span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 110%;
  color: #6083c0;
}

.product__consultation h3 {
  font-size: 22px;
  line-height: 100%;
  margin-bottom: 4px;
}

.product__consultation p {
  font-size: 18px;
  line-height: 140%;
  opacity: 0.6;
  margin-bottom: 25px;
}

.product__consultation-contacts {
  display: flex;
  align-items: center;
  padding-bottom: 57px;
  border-bottom: 2px solid rgba(244, 244, 245, 1);
}

.product__consultation-contacts a {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
}

.product__consultation-contacts span {
  width: 2px;
  height: 22px;
  background: #272930;
  opacity: 0.1;
}

.product__consultation-phone {
  color: #6083c0;
  margin-right: 15px;
}

.product__consultation-mail {
  margin-left: 15px;
  color: #61ad98;
}

.product__order {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  padding-right: 20px;
}

.product__order-block {
  position: relative;
  width: 567px;
  min-height: 529px;
  box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
  background-color: #fff;
  padding: 50px 60px 60px 60px;
}

.product__order-block--test {
  min-height: 440px;
}

.product__order-line {
  position: absolute;
  width: 50px;
  height: 50px;
  z-index: 2;
}

.product__order-line--green {
  top: -20px;
  left: -20px;
}

.product__order-line--green::before,
.product__order-line--green::after {
  background-color: #7bcfb7;
  top: 0;
  left: 0;
}

.product__order-line--blue {
  bottom: -20px;
  right: -20px;
}

.product__order-line--blue::before,
.product__order-line--blue::after {
  background-color: #6083c0;
  bottom: 0;
  right: 0;
}

.product__order-line::before {
  position: absolute;
  content: "";
  width: 100%;
  height: 8px;
}

.product__order-line::after {
  position: absolute;
  content: "";
  height: 100%;
  width: 8px;
}

.product__order-title {
  font-size: 28px;
  line-height: 100%;
  margin-bottom: 4px;
}

.product__order-description {
  font-size: 18px;
  line-height: 110%;
  color: rgba(39, 41, 48, 0.6);
  margin-bottom: 33px;
}

.product__count {
  display: flex;
  align-items: center;
  margin-bottom: 35px;
}

.product__button {
  width: 100%;
  height: 60px;
  border: 2px solid rgba(39, 41, 48, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 0;
  transition: 0.5s ease;
}

.product__button-feedback {
  margin-bottom: 6px;
}

.product__button-block {
  display: flex;
  align-items: center;
}

.product__button-feedback svg {
  margin-right: 9px;
  fill: none;
}

.product__button-feedback svg path {
  fill: #6083c0;
  transition: 0.5s ease;
}

.product__button-feedback span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: #6083c0;
  transition: 0.5s ease;
}

.product__button-feedback {
  background: transparent;
}

.product__button-feedback:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #ffffff;
  color: #fff;
  transition: 0.5s ease;
}

.product__button-feedback:hover span {
  color: #fff;
}

.product__button-feedback:hover svg path {
  fill: #fff;
  transition: 0.5s ease;
}

.product__button-feedback--test {
  margin-bottom: 36px;
  background: #6083c0;
}

.product__button-feedback--test span {
  color: #fff;
}

.product__button-feedback--test svg path {
  fill: #fff;
  transition: 0.5s ease;
}

.product__button-request {
  background: #6083c0;
  margin-bottom: 36px;
}

.product__button-request:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
}

.product__button-request:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
}

/*  */
.product__button-circle {
  position: relative;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 2px solid #fff;
  margin-right: 11px;
}

.product__button-request span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: #fff;
}

.product__button-circle::before,
.product__button-circle::after {
  position: absolute;
  content: "";
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
}

.product__button-circle::before {
  width: 8px;
  height: 1.25px;
}

.product__button-circle::after {
  height: 8px;
  width: 1.25px;
}

.product__list-image {
  width: 36px;
  height: 36px;
  margin-bottom: 16px;
}

.product__list-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

@media (max-width: 1800px) {
  .product__info-description {
    padding-right: 20px;
  }
}

@media (max-width: 1600px) {
  .product__order-block {
    width: 460px;
  }
}

@media (max-width: 1300px) {
  .product__order-block {
    width: 410px;
    padding: 25px 30px 30px 30px;
  }

  .product__list-item:first-child {
    padding-right: 14px;
  }

  .product__list-item {
    padding-left: 20px;
    padding-right: 22px;
  }
}

@media (max-width: 1199px) {
  .product__content-image div {
    width: 170px;
    height: 170px;
  }

  .product__availability-logo {
    margin-right: 15px;
  }
}

@media (max-width: 990px) {
  .product__info {
    padding-top: 0;
  }

  .product__block {
    grid-template-columns: 1fr;
  }

  .product__order {
    padding-right: 0;
    align-items: center;
    grid-column: 1 / 2;
    grid-row: 2 / 3;
    padding-bottom: 29px;
    margin-bottom: 29px;
    border-bottom: 2px solid rgba(244, 244, 245, 1);
  }
}

@media (max-width: 767px) {
  .product__wrapper {
    padding-top: 24px;
    padding-bottom: 33px;
  }

  .product__head {
    margin-bottom: 24px;
  }

  .product__info-title {
    flex-direction: column;
    align-items: flex-start;
  }

  .product__info-title h2 {
    font-size: 22px;
    line-height: 100%;
    margin-right: 0;
    margin-bottom: 7px;
  }

  .product__info-title span {
    font-size: 14px;
    line-height: 100%;
    padding: 3px 7px;
  }

  .product__info-description {
    padding-right: 0;
    font-size: 14px;
    line-height: 120%;
    margin-bottom: 14px;
  }

  .product__availability-logo {
    width: 74px;
    height: 47px;
  }

  .product__availability-logo img {
    width: 43px;
    height: 7px;
  }

  .product__availability-info {
    font-size: 12px;
    line-height: 110%;
  }

  .product__availability {
    padding-bottom: 18px;
    margin-bottom: 19px;
  }

  .product__content-image div {
    width: 100px;
    height: 100px;
  }

  .product__availability {
    grid-column: 1 / 3;
  }

  .product__content-image {
    grid-row: 2 / 4;
  }

  .product__content-description {
    font-size: 12px;
    margin-bottom: 12px;
  }

  .product__content-download img {
    margin-right: 7px;
  }

  .product__content-download span {
    font-size: 14px;
    line-height: 110%;
  }

  .product__order-block {
    width: 284px;
  }

  .product__order-line {
    width: 32px;
    height: 32px;
  }

  .product__order-line::before {
    height: 4px;
  }

  .product__order-line::after {
    width: 4px;
  }

  .product__order-line--green {
    top: -10px;
    left: -10px;
  }

  .product__order-line--blue {
    bottom: -10px;
    right: -10px;
  }

  .product__order-block {
    padding: 21px 16px 19px 16px;
    min-height: 336px;
  }

  .product__order-title {
    font-size: 18px;
    line-height: 100%;
    margin-bottom: 7px;
  }

  .product__order-description {
    font-size: 12px;
    line-height: 110%;
    margin-bottom: 19px;
  }

  .product__content-download {
    margin-bottom: 38px;
  }

  .product__count {
    margin-bottom: 23px;
  }

  .product__list-item span {
    font-size: 12px;
    line-height: 100%;
    max-width: 53px;
  }

  .product__button {
    height: 48px;
  }

  .product__button-feedback span,
  .product__button-request span {
    font-size: 14px;
    line-height: 100%;
  }

  .product__list-image {
    width: 32px;
    height: 32px;
    margin-bottom: 8px;
  }

  .product__consultation h3 {
    font-size: 18px;
    line-height: 100%;
    margin-bottom: 0;
  }

  .product__consultation p {
    font-size: 12px;
    line-height: 140%;
    margin-bottom: 20px;
  }

  .product__consultation-contacts a {
    font-size: 14px;
    line-height: 100%;
  }

  .product__consultation-phone {
    margin-right: 11px;
  }

  .product__consultation-mail {
    margin-left: 11px;
  }

  .product__consultation-contacts span {
    height: 16px;
  }

  .product__consultation-contacts {
    padding-bottom: 30px;
  }

  .related__wrapper {
    padding-bottom: 33px;
  }

  .related__wrapper .container {
    padding: 0;
  }
}
</style>