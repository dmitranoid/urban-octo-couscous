<template>
  <div class="card">
    <div @click="removeProduct" class="card__close">
      <div class="card__close-block"></div>
    </div>
    <div class="card__wrapper">
      <div class="card__image">

        <router-link :to="`/manufacturers/${dataProduct.manufacturer.charAt(0).toLowerCase() + dataProduct.manufacturer.slice(1)}/${dataProduct.category.slug}/${dataProduct.slug}`" class="block-overlay"></router-link>
        <img :src="dataProduct.image" alt="" />
      </div>
      <div class="card__block">
        <div class="card__info">
          <router-link :to="`/manufacturers/${dataProduct.manufacturer.charAt(0).toLowerCase() + dataProduct.manufacturer.slice(1)}/${dataProduct.category.slug}/${dataProduct.slug}`">
            <div class="card__info-block">
              <h3 class="card__info-name">{{ dataProduct.sku }}</h3>
              <span class="card__info-model">{{ dataProduct.name }}</span>
              <span class="card__info-new">New Saled</span>
            </div>
          </router-link>
        </div>
        <block-count @change-product-qty="changeCountProduct" :countProduct="dataProduct.count"></block-count>
      </div>
    </div>
  </div>
</template>

<script>
import BlockCount from "@/components/ui/BlockCount.vue";

export default {
  emits: ["remove-product", "change-count"],
  components: {
    BlockCount,
  },
  props: {
    dataProduct: Object,
  },
  methods: {
    changeCountProduct(count) {
      this.$emit("change-count", this.dataProduct.id, count);
    },
    getImgUrl(pic) {
      return require("@/assets/images/" + pic);
    },
    removeProduct() {
      this.$emit('remove-product', this.dataProduct.id);
    }
  },
  mounted() {
  }
};
</script>

<style scoped>
.card {
  position: relative;
  border-bottom: 2px solid #f4f4f5;
  padding: 25px 40px 25px 25px;
}
.card__close {
  cursor: pointer;
  position: absolute;
  top: 11px;
  right: 11px;
  width: 12px;
  height: 12px;
}
.card__close-block {
  width: 100%;
  height: 100%;
  position: relative;
}
.card__close-block::before,
.card__close-block::after {
  position: absolute;
  content: "";
  width: 100%;
  height: 3px;
  left: 50%;
  top: 50%;
  background-color: #272930;
  opacity: 0.2;
}
.card__close-block::before {
  transform: translate(-50%, -50%) rotate(-45deg);
}
.card__close-block::after {
  transform: translate(-50%, -50%) rotate(45deg);
}
.card__image {
  position: relative;
  width: 99px;
  height: 99px;
  margin-right: 22px;
}
.card__image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
.card__info {
  display: flex;
  align-items: center;
}
.card__info-block {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.card__info-name {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-bottom: 2px;
  color: rgba(39, 41, 48, 1) !important;
}
.card__info-model {
  font-size: 16px;
  line-height: 24px;
  opacity: 0.5;
  margin-bottom: 9px;
  color: rgba(39, 41, 48, 0.5) !important;
}
.card__info-new {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 14px;
  line-height: 100%;
  color: #61ad98;
  background-color: rgba(123, 207, 183, 0.3);
  padding: 3px 6px;
}
.card__wrapper {
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr;
}
.card__block {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
@media (max-width: 1199px) {
  .card__block {
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
  }
  .card__info-block {
    margin-bottom: 9px;
  }
  .card__image {
    margin-right: 14px;
  }
}
@media (max-width: 990px) {
  .card__image {
    width: 82px;
    height: 82px;
  }
}
@media (max-width: 767px) {
  .card {
    padding: 15px 18px 15px 18px;
  }
  .card__info-name {
    font-size: 14px;
    line-height: 100%;
    margin-bottom: 2px;
  }
  .card__info-model {
    font-size: 12px;
    line-height: 18px;
    margin-bottom: 0;
  }
  .card__info-block {
    display: flex;
    flex-direction: column;
    margin-bottom: 6px;
  }
  .card__info-new {
    order: -1;
    padding: 3px 3px 1px 3px;
    font-size: 12px;
    line-height: 100%;
    margin-bottom: 5px;
  }
  .card__close {
    width: 8px;
    height: 8px;
  }
  .card__close-block::before,
  .card__close-block::after {
    height: 2px;
  }
}
</style>