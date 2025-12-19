<template>
  <div @click="$emit('toggle-modal')" class="overlay"></div>
  <div class="modal-product">
    <div class="modal-product__wrapper">
      <div>
        <div class="modal-product__head">
          <div class="modal-product__head-block">
            <div class="modal-product__ok">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="none">
                <path
                  fill="#61AD98"
                  fill-rule="evenodd"
                  d="M3.001 4.584 6.258.8l1.474 1.162L3.225 7.2.265 4.723l1.259-1.376L3 4.584Z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <h3 class="modal-product__title">Product has been added to request list</h3>
          </div>
          <div @click="$emit('toggle-modal')" class="modal-product__close"></div>
        </div>
        <div class="modal-product__info">
          <div class="modal-product__block">
            <div class="modal-product__image">
              <img :src="productInfo.image" :alt="productInfo.sku" />
            </div>
            <div class="modal-product__container">
              <div class="modal-product__name">
                <h3>{{manufacturer}}</h3>
                <span>New Saled</span>
              </div>
              <span class="modal-product__model">{{ productInfo.sku }}</span>
              <block-count @change-product-qty="changeProductQty" :count-product="qty"></block-count>
            </div>
          </div>
          <div class="modal-product__control">
            <button @click="addProductToBasket(false)" class="modal-product__control-listing">
              Continue listing
            </button>
            <button @click="addProductToBasket(true)" class="modal-product__control-request">
              Make request
            </button>
          </div>
        </div>
      </div>
      <div class="modal-related">
        <related-section title="You may need" :isModalProduct="true" :dataProducts="relatedProducts"></related-section>
      </div>
    </div>
  </div>
</template>

<script>
import BlockCount from "@/components/ui/BlockCount.vue";
import RelatedSection from "./RelatedSection.vue";
export default {
  data() {
    return{
      qty: this.productQty,
      manufacturer: this.manufacturerProduct.charAt(0).toUpperCase() + this.manufacturerProduct.slice(1),
    }
  },
  methods: {
    changeProductQty(count) {
      this.qty = count;
    },
    addProductToBasket(routeToBasket = false) {
      
      const productData = {
        id: this.productInfo.id,
        count: this.qty,
        manufacturer: this.manufacturer,
        model: this.productInfo.slug,
      };
      if(!localStorage.getItem("busketProducts")) {
        localStorage.setItem("busketProducts", JSON.stringify([JSON.stringify(productData)]));
      } else if(localStorage.getItem("busketProducts")) {
        const dataBasketProductsLocalStorage = localStorage.getItem("busketProducts");
        let arrayBasketProducts = [];
        try {
          arrayBasketProducts = JSON.parse(dataBasketProductsLocalStorage);
        } catch (e) {
          console.log('basket bad json');
        }
        const arrayParseBasketProducts = arrayBasketProducts.map((item)=>JSON.parse(item));
        if(!arrayParseBasketProducts.some((item)=>item.id === this.productInfo.id)) {
          arrayBasketProducts.push(JSON.stringify(productData));
          localStorage.setItem("busketProducts", JSON.stringify(arrayBasketProducts));
        }
        // arrayBasketProducts.push(JSON.stringify(productData));
        // if(!dataBasketProductsLocalStorage.includes(this.productInfo.id,0)) {
        //   localStorage.setItem("busketProducts", [`${dataBasketProductsLocalStorage},${this.productInfo.id}`]);
        // }
      }
      if (routeToBasket) {
        this.$router.push('/basket');
      } else {
        this.$emit('toggle-modal');
      }
    }
  },
  components: { RelatedSection, BlockCount },
  inject: ["dataProducts"],
  props: ["productInfo", "manufacturerProduct", "relatedProducts", "productQty"],
  emits: {
    "toggle-modal": null,
  },
};
</script>

<style scoped>
.modal-product__count-arrow {
  display: none;
}
.modal-related {
  padding: 0 58px;
}
.overlay {
  position: fixed;
  width: 100vw;
  height: 100vh;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  z-index: 98;
  background: #272930;
  opacity: 0.2;
}
.modal-product {
  position: fixed;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index: 999;
  width: 1174px;
  min-height: 571px;
  background: #ffffff;
  box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
}
.modal-product__close {
  position: relative;
  cursor: pointer;
  width: 12px;
  height: 12px;
}
.modal-product__close::before,
.modal-product__close::after {
  position: absolute;
  content: "";
  width: 100%;
  height: 3px;
  background-color: rgba(39, 41, 48, 0.5);
  top: 50%;
  left: 50%;
}
.modal-product__close::before {
  transform: translate(-50%, -50%) rotate(45deg);
}
.modal-product__close::after {
  transform: translate(-50%, -50%) rotate(-45deg);
}
.modal-product__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 24px 41px 21px 58px;
  border-bottom: 2px solid #f4f4f5;
  margin-bottom: 33px;
}
.modal-product__head-block {
  display: flex;
  align-items: center;
}
.modal-product__title {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 22px;
  line-height: 100%;
}
.modal-product__ok {
  width: 32px;
  height: 32px;
  border: 2px solid #e9eaea;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 11px;
}
.modal-product__info {
  padding: 0 58px;
  margin-bottom: 48px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-product__block {
  display: flex;
  align-items: center;
}
.modal-product__image {
  width: 178px;
  height: 178px;
  margin-right: 30px;
}
.modal-product__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.modal-product__name {
  display: flex;
  align-items: center;
  margin-bottom: 6px;
}
.modal-product__name h3 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 26px;
  line-height: 100%;
  margin-right: 11px;
}
.modal-product__name span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  color: #61ad98;
  padding: 7px 5px;
  background-color: rgba(123, 207, 183, 0.3);
}
.modal-product__model {
  display: block;
  font-size: 18px;
  line-height: 27px;
  opacity: 0.5;
  margin-bottom: 16px;
}
.modal-product__control {
  display: flex;
  flex-direction: column;
  width: 236px;
}
.modal-product__control button {
  position: relative;
  width: 100%;
  height: 60px;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  transition: 0.5s ease;
}
.modal-product__control-listing {
  border: 2px solid rgba(39, 41, 48, 0.1);
  background: transparent;
  color: #6083c0;
  margin-bottom: 6px;
}
.modal-product__control-listing:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #ffffff;
  color: #ffff;
  transition: 0.5s ease;
}
.modal-product__control-listing:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #ffffff;
  color: #ffff;
  transition: 0.5s ease;
}
.modal-product__control-request:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
  transition: 0.5s ease;
}
.modal-product__control-request:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #ffffff;
  transition: 0.5s ease;
}
.modal-product__control-request {
  border: 2px solid rgba(39, 41, 48, 0.1);
  background: #6083c0;
  color: #ffff;
}
@media (max-width: 1199px) {
  .modal-product {
    position: fixed;
    left: 0;
    top: 0%;
    right: 0;
    bottom: 0;
    transform: translate(0, 0);
    z-index: 999;
    width: 100vw;
    min-height: 100vh;
    background: #ffffff;
    box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
    overflow-y: auto;
  }
  .modal-product__wrapper {
    height: 99%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
}
@media (max-width: 990px) {
  .modal-product__head,
  .modal-product__info,
  .modal-related {
    padding-left: 18px;
    padding-right: 18px;
  }
}
@media (max-width: 767px) {
  .modal-related {
    padding: 0;
  }
  .modal-product__title {
    max-width: 162px;
    font-size: 16px;
    line-height: 100%;
  }
  .modal-product__info {
    flex-direction: column;
    align-items: flex-start;
  }
  .modal-product__image {
    width: 82px;
    height: 82px;
    margin-right: 14px;
  }

  .modal-product__name h3 {
    font-size: 18px;
    line-height: 100%;
    margin-right: 10px;
  }
  .modal-product__name span {
    font-size: 12px;
    line-height: 100%;
    padding: 3px;
    padding-bottom: 1px;
  }
  .modal-product__model {
    font-size: 14px;
    line-height: 21px;
    margin-bottom: 8px;
  }
  .modal-product__block {
    margin-bottom: 30px;
  }
  .modal-product__control {
    width: 100%;
  }
  .modal-product__control button {
    height: 50px;
    font-size: 14px;
    line-height: 100%;
  }
  .modal-product__info {
    margin-bottom: 50px;
  }
}
</style>