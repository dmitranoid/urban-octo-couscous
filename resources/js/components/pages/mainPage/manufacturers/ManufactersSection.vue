<template>
  <section class="manufacturers">
    <div class="container">
      <div class="manufacturers__wrapper">
        <div class="manufacturers__info">
          <div class="manufacturers__info-block">
            <div class="manufacturers__info-top">
              <block-line></block-line>
              <h2><slot name="title">Manufacturers</slot></h2>
            </div>
              <h3><slot name="subtitle">We stock thousands of automation and control components from leading OEM</slot></h3>
            <p>
              <slot name="content">
              We stock thousands of automation and control components from leading OEMs, all accessible to you from a
              single place. If it’s not in stock, our multilingual team will scour the globe to find you the part you
              need for the best price.
              </slot>
            </p>
          </div>
        </div>
        <div class="manufacturers__block">
          <div v-for="item in dataManufacturers" :key="item.image" class="manufacturers__block-card">
            <router-link :to="{ name: 'manufacturer', params: { manufacturer: item.slug} }" class="block-overlay"></router-link>
            <div class="manufacturers__block-image" v-if="item.image">
              <picture>
                <img :src="getImgUrl(item.image)" loading="lazy" />
              </picture>
            </div>
            <div class="manufacturers__block-all" v-else>
              <div class="manufacturers__block-arrow">
                <picture>
                  <img src="@/assets/images/manufacturers-arrow.svg" alt="manufacturers-arrow" />
                </picture>
              </div>
              <span>View all</span>
            </div>
          </div>
          <div class="manufacturers__block-card">
            <router-link to="/manufacturers" class="block-overlay"></router-link>
            <div class="manufacturers__block-all">
              <div class="manufacturers__block-arrow">
                <picture>
                  <img src="@/assets/images/manufacturers-arrow.svg" alt="manufacturers-arrow" />
                </picture>
              </div>
              <span>View all</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <modal-form v-if="isVisibleModalForm" @toggle-modal="toggleModalForm"></modal-form>
</template>

<script>
import ModalForm from "@/components/pages/productPage/ModalForm.vue";
import BlockLine from "@/components/ui/BlockLine.vue";

export default {
  components: { BlockLine, ModalForm },
  data() {
    return {
      isVisibleModalForm: false,
      dataManufacturers: [
        {
          name: "siemens",
          image: "manufacturers-1.svg",
          slug: "siemens",
        },
        {
          name: "OMRON",
          image: "brands/OMRON.png",
          slug: "omron",
        },
        {
          name: "Pilz",
          image: "brands/Pilz.png",
          slug: "pilz",
        },
        {
          name: "Keyence",
          image: "brands/Keyence.png",
          slug: "keyence",
        },
        {
          name: "Pepperl+Fuchs",
          image: "brands/Pepperl+Fuchs.png",
          slug: "pepperlfuchs",
        },
        {
          name: "Allen-Bradley",
          image: "brands/Allen-Bradley.png",
          slug: "allenbradley",
        },
        {
          name: "Sick",
          image: "brands/Sick.png",
          slug: "sick",
        },
      ],
    };
  },
  methods: {
    toggleModalForm() {
      this.isVisibleModalForm = !this.isVisibleModalForm;
      this.isVisibleModalForm
        ? document.body.classList.add("body-overlay")
        : document.body.classList.remove("body-overlay");
    },
    getImgUrl(pic) {
      return "/assets/images/" + pic;
    },
  },
};
</script>

<style scoped>
.manufacturers {
  overflow: hidden;
}
.manufacturers__block-all {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.manufacturers__block-all span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
}
.manufacturers__block-arrow {
  width: 19px;
  height: 19px;
  margin-bottom: 10px;
}
.manufacturers__block-arrow img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
.manufacturers__wrapper {
  position: relative;
  z-index: 2;
  padding-top: 103px;
  padding-bottom: 77px;
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr;
  column-gap: 102px;
}
.manufacturers__info {
  max-width: 451px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.manufacturers__info-top {
  display: flex;
  align-items: center;
  margin-bottom: 26px;
}
.manufacturers__info-top h2 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  color: #272930;
}
.manufacturers__info h3 {
  font-size: 36px;
  line-height: 100%;
  margin-bottom: 26px;
}
.manufacturers__info p {
  font-size: 18px;
  line-height: 140%;
  opacity: 0.5;
}

.manufacturers__block {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
}
.manufacturers__block-card {
  position: relative;
  border: 2px solid #f4f4f5;
  border-right: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 260px;
}

.manufacturers__block-card::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  width: 0;
  height: 6px;
  background-color: #6083c0;
  transition: 0.5s ease;
}
.manufacturers__block-card:nth-child(4) {
  border-right: 2px solid #f4f4f5;
}
.manufacturers__block-card:last-child {
  border-right: none;
  border-bottom: none;
}
.manufacturers__block-card:nth-last-child(-n + 4) {
  border-top: none;
}
.manufacturers__block-image {
  width: 100%;
  height: 100%;
}
.manufacturers__block-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
@media (min-width: 990px) {
  .manufacturers__block-card:hover::after {
    width: 100%;
    transition: 0.5s ease;
  }
}
@media (max-width: 1600px) {
  .manufacturers__wrapper {
    column-gap: 30px;
  }
  .manufacturers__info {
    max-width: 400px;
  }
}
@media (max-width: 1400px) {
  .manufacturers__info {
    max-width: 312px;
  }
}

@media (max-width: 1199px) {
  .manufacturers__info {
    max-width: 100%;
  }
  .manufacturers__wrapper {
    grid-template-columns: 1fr;
    column-gap: 0;
    row-gap: 29px;
  }
}
@media (max-width: 767px) {
  .manufacturers__block-all span {
    font-size: 12px;
  }
  .manufacturers__wrapper {
    padding-top: 62px;
    padding-bottom: 36px;
  }
  .manufacturers__info-top {
    margin-bottom: 20px;
  }

  .manufacturers__info-top h2 {
    font-size: 14px;
    line-height: 100%;
  }
  .manufacturers__info h3 {
    font-size: 22px;
    margin-bottom: 16px;
  }
  .manufacturers__info p {
    font-size: 14px;
  }
  .manufacturers__block-image {
    padding: 10px;
  }
  .manufacturers__block {
    grid-template-columns: repeat(3, 1fr);
  }
  .manufacturers__block-card {
    min-height: unset;
    height: 110px;
  }
  .manufacturers__block-card:nth-child(4) {
    display: none;
  }
  .manufacturers__block-card:nth-last-child(-n + 2),
  .manufacturers__block-card:nth-child(3) {
    border-right: 2px solid #f4f4f5;
  }
  .manufacturers__block-card:last-child {
    grid-column: 1 / 4;
    min-height: unset;
    height: 43px;
    border-right: 2px solid #f4f4f5;
    border-bottom: 2px solid #f4f4f5;
  }
  .manufacturers__block-all {
    flex-direction: row;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    padding-left: 21px;
    padding-right: 29px;
  }
  .manufacturers__block-arrow {
    order: 1;
    width: 12px;
    height: 12px;
    margin-bottom: 0;
  }
}
</style>
