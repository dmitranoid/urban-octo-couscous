<template>
  <div :class="['card', { 'card--modal-product': isModalProduct }]">
    <div class="card__block">
      <div v-if="!isModalProduct" class="card__stickers">
        <div v-if="dataProduct.features?.warranty?.isActive" class="card__stickers-svg card__stickers-svg--shield">
          <img src="@/assets/images/catalog-product-svg-1.svg" alt="product-svg" />
        </div>
        <div v-if="dataProduct.features?.delivery?.isActive" class="card__stickers-svg card__stickers-svg--geography">
          <img src="@/assets/images/catalog-product-svg-2.svg" alt="product-svg" />
        </div>
        <div v-if="dataProduct.features?.dispatch?.isActive" class="card__stickers-svg card__stickers-svg--time">
          <img src="@/assets/images/catalog-product-svg-3.svg" alt="product-svg" />
        </div>
      </div>
      <div class="card__image">
        <router-link
            :to="{name: 'product', params: {
                manufacturer : dataProduct.manufacturer.slug,
                submanufacturer: dataProduct.category.slug,
                product: dataProduct.slug,
            }}"
            class="block-overlay">
        </router-link>
        <picture>
          <img :src="dataProduct.image" :alt="dataProduct.name" />
        </picture>
      </div>
      <div class="card__info">
        <span class="card__info-new">New Sealed</span>
        <h3 class="card__info-name">{{ dataProduct?.sku }}</h3>
        <p v-if="!isModalProduct" class="card__info-description">{{ dataProduct?.name }}</p>
        <div v-if="!isModalProduct" class="card__info-availability">
          <div class="card__info-logo">
            <img :src="dataProduct.manufacturer?.image" alt="logo-product" />
          </div>
          <div class="card__info-block">
            <h3>Availability:</h3>
            <p v-if="Math.floor(dataProduct.stock) === 0">Out of stock</p>
            <p v-else >More than {{ Math.floor(dataProduct?.stock) }} in stock</p>
            </div>
        </div>
      </div>
      <button class="card__button">
        <router-link :to="{ name: 'product', params: {
            manufacturer: dataProduct.manufacturer.slug,
            submanufacturer: dataProduct.category.slug,
            product: dataProduct.slug,
        }}" class="block-overlay"></router-link>
        Add to request list
      </button>
      <!-- <button class="card__button">Add to quote</button> -->
<!--      <div v-if="!isModalProduct" class="card__wish">-->
<!--        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none">-->
<!--          <path-->
<!--            fill="#6083C0"-->
<!--            d="M4.55 11.35 7 9.883l2.466 1.484L8.8 8.6l2.166-1.883-2.85-.25L7 3.833 5.9 6.45l-2.85.25 2.166 1.867-.666 2.783Zm-1.834 2.534L3.85 9.017.066 5.733l5-.416L7 .717l1.95 4.6 4.983.416-3.783 3.284 1.133 4.867L7 11.3l-4.284 2.583Z"-->
<!--          />-->
<!--        </svg>-->
<!--        <span>Quick request</span>-->
<!--      </div>-->
      <div v-if="!isModalProduct" class="card__quote">
        <div class="card__quote-block" @click="toggleModalForm(this.dataProduct.sku, this.dataProduct.name, 1)">
          <svg class="card__quote-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="20" fill="none">
            <path
              fill="#61AD98"
              d="M2.71 19.073c-.52 0-.978-.2-1.378-.6-.4-.4-.6-.858-.6-1.377V2.904c0-.518.2-.977.6-1.377.4-.4.859-.6 1.378-.6h18.579c.518 0 .977.2 1.377.6.4.4.6.859.6 1.377v14.192c0 .519-.2.978-.6 1.378-.4.4-.859.6-1.377.6H2.709ZM12 10.786 2.71 4.773v12.323h18.579V4.773l-9.29 6.013Zm0-1.923 9.289-5.959H2.737l9.262 5.959ZM2.6 4.773V2.904v14.192V4.773Z"
            />
          </svg>
          <svg class="card__quote-hover" xmlns="http://www.w3.org/2000/svg" width="24" height="20" fill="none">
            <path fill="#61AD98" d="M12 10.786 2.71 4.773v12.323h18.579V4.773l-9.29 6.013Z" />
            <path fill="#61AD98" d="m12 8.863 9.289-5.959H2.737l9.262 5.959Z" />
            <path
              fill="#61AD98"
              fill-rule="evenodd"
              d="M1.332 18.474c.4.4.859.6 1.378.6h18.579c.518 0 .977-.2 1.377-.6.4-.4.6-.86.6-1.378V2.904c0-.518-.2-.977-.6-1.377-.4-.4-.859-.6-1.377-.6H2.709c-.518 0-.977.2-1.377.6-.4.4-.6.859-.6 1.377v14.192c0 .519.2.978.6 1.378Zm1.378-1.378V4.773l.027-1.869h18.552v14.192H2.709Z"
              clip-rule="evenodd"
            />
          </svg>
          <span>Quick request</span>
        </div>
      </div>
    </div>
  </div>
  <modal-form v-if="isVisibleModalForm"
              :product-name = "selectedName"
              :product-sku = "selectedSku"
              :qty = "selectedQty"
              @toggle-modal="toggleModalForm()"></modal-form>
</template>

<script>
import ModalForm from "@/components/pages/productPage/ModalForm.vue";
export default {
  components: {
    ModalForm,
  },
  props: {
    dataProduct: Object,
    isModalProduct: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    toggleModalForm(sku='', name='', qty='') {
      if (!this.isVisibleModalForm) {
        this.selectedSku = sku;
        this.selectedName = name;
        this.selectedQty = qty;
      }
      this.isVisibleModalForm = !this.isVisibleModalForm;
      this.isVisibleModalForm
        ? document.body.classList.add("body-overlay")
        : document.body.classList.remove("body-overlay");
    },
    getImgUrl(pic) {
      return "/assets/images/" + pic;
    },
  },
  data() {
    return {
      isVisibleModalForm: false,
      selectedSku: "",
      selectedQty: 1,
      selectedName: "",
    };
  },
  mounted() {
  }
};
</script>

<style scoped>
.card__wish {
  display: none;
}
.card__block {
  border: 1px solid #f4f4f5;
  position: relative;
  padding: 34px 32px;
  transition: 0.5s ease;
  background-color: #fff;
}
.card__stickers {
  position: absolute;
  display: flex;
  flex-direction: column;
  top: 14px;
  right: 14px;
  z-index: 5;
}
.card__stickers-svg {
  width: 36px;
  height: 36px;
}
.card__stickers-svg img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.card__image {
  position: relative;
  width: 175px;
  height: 175px;
  margin-bottom: 22px;
}
.card__image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
.card__info-new {
  padding: 3px 6px;
  display: inline-block;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 14px;
  line-height: 100%;
  color: #61ad98;
  background: rgba(123, 207, 183, 0.3);
  margin-bottom: 9px;
}
.card__info-name {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-bottom: 14px;
}
.card__info-description {
  font-size: 16px;
  line-height: 120%;
  opacity: 0.5;
  height: 56px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  margin-bottom: 19px;
}
.card__info-availability {
  display: flex;
  align-items: center;
}
.card__info-logo {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 94px;
  height: 59px;
  border: 1px solid #f4f4f5;
  margin-right: 14px;
}
.card__info-logo img {
  width: 55px;
  height: 30px;
  object-fit: scale-down;
}
.card__info-block h3 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 110%;
}
.card__info-block p {
  font-size: 16px;
  line-height: 110%;
  color: rgba(39, 41, 48, 0.6);
}
.card__button {
  position: relative;
  width: 100%;
  border: 2px solid rgba(39, 41, 48, 0.1);
  height: 60px;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: rgba(96, 131, 192, 1);
  margin-top: 22px;
  transition: 0.5s ease;
  background: transparent;
}

.card__button:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #ffffff;
}
.card__quote {
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 84px;
  width: 100%;
  position: absolute;
  top: calc(100% - 32px);
  left: 0;
  right: 0;
  background-color: #fff;
  z-index: 5;
  opacity: 0;
  pointer-events: none;
  transition: 0.5s ease;
}
.card__quote-block {
  position: relative;
  display: flex;
  align-items: center;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  overflow: hidden;
  transition: 0.5s ease;
}

.card__quote-block:active {
  color: rgba(97, 173, 152, 0.5);
}

.card__quote-svg {
  position: relative;
  top: 0;
  margin-right: 11px;
  transition: 1.1s ease;
}
.card__quote-hover {
  position: absolute;
  left: 0;
  top: 150%;
  transform: translateY(-50%);
  transition: 0.3s ease;
}
.card--modal-product .card__block {
  padding: 26px 24px 27px 24px;
}
.card--modal-product .card__image {
  width: 126px;
  height: 126px;
  margin-bottom: 22px;
}
.card--modal-product .card__info-name {
  margin-bottom: 0;
}
@media (min-width: 1000px) {
  .card__quote-block:hover .card__quote-svg {
    top: -100%;
    transition: 0.3s ease;
  }
  .card__quote-block:hover {
    color: #61ad98;
    transition: 0.5s ease;
  }
  .card__quote-block:hover .card__quote-hover {
    top: 50%;
    transition: 1.1s ease;
  }
  .card__button:hover {
    background: linear-gradient(0deg, #83a3dc, #83a3dc), #ffffff;
    color: #ffffff;
    border: 2px solid transparent;
  }
  .card__block:hover {
    transform: scale(1.03);
    transition: 0.5s ease;
    box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
    z-index: 10;
  }
  .card__block:hover .card__quote {
    opacity: 1;
    pointer-events: auto;
    transition: 0.5s ease;
    box-shadow: 0px 8px 8px rgba(16, 25, 57, 0.15);
  }
}
@media (max-width: 990px) {
  .card__block {
    padding: 17px;
  }
}
@media (max-width: 767px) {
  .card--modal-product .card__block {
    padding: 18px;
  }
  .card--modal-product .card__image {
    width: 97px;
    height: 97px;
    margin-bottom: 14px;
  }
  .card--modal-product .card__button {
    margin-bottom: 0;
    margin-top: 11px;
  }
  .card__wish {
    cursor: pointer;
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    padding-left: 5px;
  }
  .card__wish svg {
    margin-right: 8.5px;
  }
  .card__wish span {
    font-family: "Circe-Bold";
    font-style: normal;
    font-size: 12px;
    line-height: 100%;
  }
  .card__info-block h3,
  .card__info-block p {
    font-size: 12px;
    line-height: 110%;
  }
  .card__info-availability {
    display: block;
  }
  .card__quote {
    position: static;
    opacity: 1;
    pointer-events: auto;
    height: auto;
    align-items: flex-start;
  }
  .card__quote-svg {
    position: relative;
    transform: scale(0.76);
    margin-right: 3px;
  }
  .card__quote-block span {
    font-size: 12px;
    line-height: 100%;
  }
  .card__image {
    width: 120px;
    height: 124px;
    margin-bottom: 17px;
  }
  .card__stickers-svg {
    width: 22px;
    height: 22px;
  }
  .card__info-new {
    font-size: 12px;
    line-height: 100%;
    padding: 3px;
    margin-bottom: 8px;
  }
  .card__info-name {
    font-size: 14px;
    line-height: 100%;
    margin-bottom: 18px;
  }
  .card__info-description,
  .card__info-logo {
    display: none;
  }
  .card__info-block {
    font-size: 12px;
    line-height: 110%;
  }
  .card__button {
    margin-top: 17px;
    font-size: 12px;
    line-height: 100%;
    height: 37px;
    margin-bottom: 11px;
  }
}
@media (max-width: 400px) {
  .card__info-name {
    max-width: 124px;
    word-wrap: break-word;
  }
}
</style>