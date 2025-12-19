<template>
  <section class="basket">
    <div class="container">
      <div class="basket__wrapper">
        <div v-if="dataBasket.length" @click="clearAll" class="basket__clear">
          <div class="basket__clear-block"></div>
          <span>Clear all</span>
        </div>
        <div class="basket__head">
          <h2>Quote list</h2>
          <the-breadcrumbs></the-breadcrumbs>
        </div>
        <div class="basket__container">
          <div class="basket__block" v-if="dataBasket.length">
            <basket-product
                v-for="item in dataBasket"
                :key="item.id"
                :dataProduct="item"
                @remove-product="removeProduct"
                @change-count="changeCount"
            ></basket-product>
          </div>
          <div v-else>No products. please add to basket</div>
          <div class="basket__info">
            <div v-if="dataBasket.length" class="basket__info-block">
              <h3 class="basket__info-title">Get price for {{ dataBasket.length }} products</h3>
              <span class="basket__info-span">Ask for quote</span>

              <div class="basket__info-fields">
                <div class="basket__info-field">
                  <h3>Name<span>*</span></h3>
                  <input type="text" v-model="orderName" ref="orderName">
                </div>
                <div class="basket__info-field">
                  <h3>Company<span>*</span></h3>
                  <input type="text" v-model="orderCompany" ref="orderCompany">
                </div>
                <div class="basket__info-field">
                  <h3>Email<span>*</span></h3>
                  <input type="text" v-model="orderEmail" ref="orderEmail">
                </div>
              </div>

              <button @click="handlerBasketRequest" class="basket__info-button basket__info-button--list">
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="13" fill="none">
                    <path
                        fill="#fff"
                        d="M3.667 12.73.52 9.582l1.063-1.062 2.083 2.062 3.729-3.729 1.063 1.083-4.792 4.792Zm0-6.668L.52 2.917l1.063-1.063 2.083 2.063L7.396.187l1.063 1.084-4.792 4.792Zm6.062 5.021v-1.52H17.5v1.52H9.73Zm0-6.666V2.896H17.5v1.52H9.73Z"
                    />
                  </svg>
                  <span>Make Request</span>
                </div>
              </button>
              <p class="basket__text-agree">I accept the General Term and Conditions and confirm that i have read the <a
                  href="">Privacy Policy</a></p>
            </div>
            <div class="basket__consultation">
              <h3>Need consultation?</h3>
              <span class="basket__consultation-span">Ask our team now</span>
              <div class="basket__contacts">
                <a class="basket__contacts-phone" :href="`tel:${designSettings?.phone ?? ''}`">{{ designSettings?.phone ?? '' }}</a>
                <span></span>
                <a class="basket__contacts-mail" :href="`mailto:${designSettings?.email??''}`">{{ designSettings?.email ?? '' }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import BasketProduct from "./BasketProduct.vue";
import axios from "axios";
import {ref, watch} from "vue";
import useSWRV from "swrv";
import {urlSettings} from "@/functions/urlgen";
import {getDataFetcher, getSWRVOptions} from "@/functions/utils";

export default {
  setup() {
    const designSettings = ref([]);

    const {data: designSettingsResp} = useSWRV(urlSettings('general-design'), getDataFetcher(), getSWRVOptions())

    watch(designSettingsResp, () => {
      if (designSettingsResp.value) {
        designSettings.value = designSettingsResp.value.data;
      } else {
        designSettings.value = null;
      }
    }, {deep: true, immediate: true});

    return {
      designSettings,
    }
  },
  components: {TheBreadcrumbs, BasketProduct},
  data() {
    return {
      orderName: '',
      orderCompany: '',
      orderEmail: '',
      dataBasket: [
        // {
        //   image: "catalog-product-1.svg",
        //   name: "Siemens",
        //   model: "6ES7331-7KF02-0AB1",
        //   id: 1,
        // },
      ],
    };
  },
  mounted() {
    if (localStorage.getItem("busketProducts")) {
      const dataBasketProductsLocalStorage = localStorage.getItem("busketProducts");
      let arrayBasketProducts = [];
      try {
        arrayBasketProducts = JSON.parse(dataBasketProductsLocalStorage);
      } catch (e) {
        console.log('basket bad json');
      }
      const arrayParseBasketProducts = arrayBasketProducts.map((item) => JSON.parse(item));
      arrayParseBasketProducts.forEach((item) => {
        this.getProduct(item);
      });
    }
  },
  methods: {
    changeCount(productId, count) {
      this.dataBasket.forEach((item) => {
        if (item.id === productId) {
          item.count = count;
        }
      });
      this.updateBasketDataInLocalStorage(productId, 'update', count);
    },
    async handlerBasketRequest() {
      let products = [];
      this.dataBasket.forEach((item) => products.push({
            sku: item.sku,
            price: item.price,
            qty: item.count,
          })
      );

      //console.log(products);
      const postData = {
        author: this.orderCompany + ' - ' + this.orderName,
        contact: this.orderEmail,
        message: `order from ${this.orderCompany}`,
        products: products
      }
      const response = await axios.post("/api/messages/pricerequest", postData);
      if (response.data.data) {
        Promise.resolve(response)
            .then((response) => {
              this.clearAll();
              this.$router.push('/thanks?code=' + response.data.data.code);
            })
      } else {
        Promise.resolve(response)
            .then((response) => {
              console.log('error when sending request')
              console.log(response.data);
            })
      }
    },
    clearAll() {
      this.dataBasket = [];
      localStorage.removeItem("busketProducts");
    },
    async getProduct(productData) {
      const response = await axios.get(`/api/products/${productData.id}`);
      this.dataBasket.push(Object.assign(response.data.data, productData));
    },
    removeProduct(id) {
      this.dataBasket = this.dataBasket.filter((item) => item.id !== id);
      this.updateBasketDataInLocalStorage(id, 'delete');
    },
    updateBasketDataInLocalStorage(productId, action, count) {
      const dataBasketProductsLocalStorage = localStorage.getItem("busketProducts");
      const arrayBasketProducts = JSON.parse(dataBasketProductsLocalStorage);
      const arrayParseBasketProducts = arrayBasketProducts.map((item) => JSON.parse(item));
      if (productId && count && action === 'update') {
        arrayParseBasketProducts.forEach((item) => {
          if (item.id === productId) {
            item.count = count;
          }
        })
        const arrayStringifyBasketProducts = arrayParseBasketProducts.map((item) => JSON.stringify(item));
        const jsonBasketProducts = JSON.stringify(arrayStringifyBasketProducts);
        localStorage.setItem("busketProducts", jsonBasketProducts);

      } else if (productId && action === 'delete') {
        const newArrayBasketProducts = arrayParseBasketProducts.filter((item) => item.id !== productId);
        const arrayStringifyBasketProducts = newArrayBasketProducts.map((item) => JSON.stringify(item));
        const jsonBasketProducts = JSON.stringify(arrayStringifyBasketProducts);
        localStorage.setItem("busketProducts", jsonBasketProducts)
      }
    }
  },


};
</script>

<style scoped>
.basket__text-agree {
  margin-top: 27px;
  color: rgba(39, 41, 48, 0.40);
  font-family: Circe;
  font-size: 14px;
  font-style: normal;
  font-weight: 400;
  line-height: 120%;
}

.basket__text-agree a {
  color: rgba(39, 41, 48, 0.40);
  text-decoration: underline;
}

.basket__info-field h3 {
  font-family: "Circe";
  font-size: 14px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}

.basket__info-field h3 span {
  color: #EA4335;
}

.basket__info-field {
  margin-bottom: 20px;
}

.basket__info-field input {
  width: 100%;
  padding-top: 6px;
  padding-bottom: 12px;
  border-bottom: 1px solid rgba(39, 41, 48, 0.1);
  transition: 0.5s ease;
}

.basket__info-field input:focus {
  border-bottom: 1px solid #6083C0 !important;
  transition: 0.5s ease;
}

.basket__info-field:last-of-type {
  margin-bottom: 33px !important;
}

.basket__consultation {
  background: #ffffff;
  box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
  padding: 36px 55px 36px 40px;
}

.basket__consultation h3 {
  font-size: 22px;
  line-height: 100%;
  margin-bottom: 4px;
}

.basket__consultation-span {
  display: block;
  font-size: 18px;
  line-height: 140%;
  opacity: 0.6;
  margin-bottom: 21px;
}

.basket__contacts {
  display: flex;
  align-items: center;
}

.basket__contacts span {
  height: 18px;
  width: 2px;
  background: #272930;
  opacity: 0.1;
}

.basket__contacts a {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
}

.basket__contacts-phone {
  margin-right: 15px;
  color: #6083c0;
}

.basket__contacts-mail {
  margin-left: 15px;
  color: #61ad98;
}

.basket__info-block {
  background: #ffffff;
  box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
  padding: 41px 40px 36px 40px;
  margin-bottom: 12px;
}

.basket__info-title {
  font-size: 22px;
  line-height: 100%;
  margin-bottom: 5px;
}

.basket__info-span {
  display: block;
  font-size: 16px;
  line-height: 110%;
  color: rgba(39, 41, 48, 0.6);
  margin-bottom: 28px;
}

.basket__info-list {
  margin-bottom: 29px;
}

.basket__info-item {
  display: flex;
  align-items: center;
}

.basket__info-item span {
  font-size: 18px;
  line-height: 100%;
}

.basket__info-image {
  width: 36px;
  height: 36px;
  margin-right: 10px;
}

.basket__info-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.basket__info-button {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 60px;
  width: 100%;
  padding: 0;
}

.basket__info-button--mail {
  border: 2px solid rgba(39, 41, 48, 0.1);
  margin-bottom: 6px;
}

.basket__info-button div {
  display: flex;
  align-items: center;
}

.basket__info-button--mail {
  background: transparent;
  color: #6083c0;
}

.basket__info-button--mail:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #ffffff;
  color: #fff;
}

.basket__info-button--mail:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
  color: #fff;
}

.basket__info-button--mail svg path {
  fill: #6083c0;
}

.basket__info-button--mail:hover svg path,
.basket__info-button--mail:active {
  fill: #fff;
}

.basket__info-button--list {
  background: #6083c0;
  border: 2px solid transparent;
  color: #fff;
}

.basket__info-button--list:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
}

.basket__info-button--list:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
}

.basket__info-button--list svg {
  margin-right: 11.5px;
}

.basket__info-button--mail svg {
  margin-right: 6px;
}

.basket__info-button span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
}

.basket__block {
  border: 2px solid #f4f4f5;
  border-bottom: none;
}

.basket__clear {
  cursor: pointer;
  position: absolute;
  bottom: 40px;
  left: 0;
  display: flex;
  align-items: center;
}

.basket__clear span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: #272930;
  opacity: 0.5;
}

.basket__clear-block {
  position: relative;
  width: 12px;
  height: 12px;
  margin-right: 7px;
}

.basket__clear-block::before,
.basket__clear-block::after {
  content: "";
  position: absolute;
  width: 100%;
  height: 3px;
  background-color: #272930;
  top: 50%;
  left: 50%;
  opacity: 0.3;
}

.basket__clear-block::before {
  transform: translate(-50%, -50%) rotate(-45deg);
}

.basket__clear-block::after {
  transform: translate(-50%, -50%) rotate(45deg);
}

.basket__wrapper {
  position: relative;
  min-height: 50vh;
  padding-top: 60px;
  padding-bottom: 90px;
}

.basket__wrapper h2 {
  font-size: 46px;
  line-height: 100%;
  margin-bottom: 16px;
}

.basket__head {
  margin-bottom: 60px;
}

.basket__container {
  display: grid;
  grid-template-columns: 1fr minmax(0, 403px);
  column-gap: 47px;
}

@media (max-width: 1199px) {
  .basket__wrapper {
    padding-top: 36px;
  }

  .basket__head {
    margin-bottom: 30px;
  }

  .basket__container {
    grid-template-columns: 1fr minmax(0, 306px);
    column-gap: 20px;
  }

  .basket__info-block {
    padding: 21px 16px 16px 16px;
  }

  .basket__consultation {
    padding: 19px 16px 18px 16px;
  }

  .basket__contacts {
    flex-direction: column;
    align-items: flex-start;
  }

  .basket__contacts span {
    margin-top: 10px;
    margin-bottom: 10px;
    width: 100%;
    height: 2px;
  }

  .basket__contacts-mail {
    margin-left: 0;
  }
}

@media (max-width: 767px) {
  .basket .container {
    padding: 0;
  }

  .basket__wrapper {
    padding-bottom: 42px;
  }

  .basket__head {
    padding: 0 18px;
  }

  .basket__info {
    margin-left: 18px;
    margin-right: 18px;
  }

  .basket__container {
    grid-template-columns: 1fr;
    row-gap: 18px;
  }

  .basket__clear {
    display: none;
  }

  .basket__wrapper h2 {
    font-size: 26px;
    line-height: 100%;
    margin-bottom: 12px;
  }

  .basket__head {
    margin-bottom: 15px;
  }

  .basket__info-title {
    font-size: 18px;
    line-height: 100%;
    margin-bottom: 7px;
  }

  .basket__info-span {
    font-size: 12px;
    line-height: 110%;
    margin-bottom: 15px;
  }

  .basket__info-image {
    width: 22px;
    height: 22px;
    margin-right: 7px;
  }

  .basket__info-item {
    margin-bottom: 7px;
  }

  .basket__info-item:last-child {
    margin-bottom: 0;
  }

  .basket__info-item span {
    font-size: 14px;
    line-height: 100%;
  }

  .basket__info-list {
    margin-bottom: 25px;
  }

  .basket__info-button {
    height: 50px;
  }

  .basket__info-button span {
    font-size: 14px;
    line-height: 100%;
  }

  .basket__info-button--list svg {
    margin-right: 7.5px;
  }

  .basket__contacts {
    flex-direction: row;
    align-items: center;
  }

  .basket__contacts span {
    width: 2px;
    height: 16px;
  }

  .basket__contacts a {
    font-size: 14px;
    line-height: 100%;
  }

  .basket__contacts-phone {
    margin-right: 11px;
  }

  .basket__contacts-mail {
    margin-left: 11px;
  }

  .basket__consultation h3 {
    font-size: 18px;
    line-height: 100%;
  }

  .basket__consultation-span {
    font-size: 12px;
    line-height: 140%;
    margin-bottom: 20px;
  }
}
</style>