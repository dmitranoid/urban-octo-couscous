<template>
  <section class="ourValues">
    <div class="container">
      <div class="ourValues__wrapper">
        <div class="ourValues__info">
          <div class="ourValues__info-scheme">
            <picture>
              <img src="@/assets/images/our-values-scheme.svg" alt="our-values-scheme" />
            </picture>
          </div>
          <div class="ourValues__info-block">
              <h3><slot name="title">Complex supplies and repairs of industrial equipment and electrical accessories.</slot></h3>
            <ul class="ourValues__info-list">
              <li class="ourValues__info-item" v-for="item in valuesInfo" :key="item.image">
                <div class="ourValues__info-image">
                  <picture>
                    <img :src="getImgUrl(item.image)" :alt="item.image" />
                  </picture>
                </div>
                <span>{{ item.name }}</span>
              </li>
            </ul>
          </div>
        </div>
        <div class="ourValues__block">
          <div class="ourValues__block-top">
            <block-line></block-line>
            <h2>Our values</h2>
          </div>
          <ul class="ourValues__block-list">
            <li class="ourValues__block-item" v-for="item in valuesList" :key="item">
              <div class="dot">
                <div></div>
              </div>
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import BlockLine from "@/components/ui/BlockLine.vue";
export default {
  components: { BlockLine },
  data() {
    return {
      valuesInfo: [
        {
          image: "our-values-1.svg",
          name: "Offices in Ukraine and Europe, as well as soon opening offices in the USA, China and Canada",
        },
        {
          image: "our-values-2.svg",
          name: "Wide range of products",
        },
        {
          image: "our-values-3.svg",
          name: "Flexible payment terms",
        },
        {
          image: "our-values-4.svg",
          name: "Low prices compared to representations",
        },
        {
          image: "our-values-5.svg",
          name: "Compliance with delivery dates",
        },
      ],
      valuesList: ["Urgency", "Loyalty", "Expert team", "Clarity representations", "Guarantees", "Honesty"],
    };
  },
  methods: {
    getImgUrl(pic) {
      return "/assets/images/" + pic;
    },
  },
};
</script>

<style scoped>
.ourValues__wrapper {
  display: grid;
  grid-template-columns: 1fr minmax(0, 530px);
  padding-bottom: 70px;
}
.ourValues__info {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.ourValues__info-block h3 {
  font-size: 36px;
  line-height: 100%;
  max-width: 600px;
  margin-bottom: 35px;
}
.ourValues__info-item {
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr;
  margin-bottom: 15px;
}
.ourValues__info-item:last-child {
  margin-bottom: 0;
}
.ourValues__info-item span {
  font-size: 18px;
  line-height: 120%;
  max-width: 431px;
  align-self: center;
}
.ourValues__info-image {
  width: 36px;
  height: 36px;
  margin-right: 13px;
}
.ourValues__info-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
.ourValues__block {
  background-color: #f8f8f9;
  padding: 66px 90px;
}
.ourValues__block-top {
  display: flex;
  align-items: center;
  margin-bottom: 26px;
}
.ourValues__block-top h2 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
}

.ourValues__block-item {
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr;
  margin-bottom: 39px;
  column-gap: 4px;
}
.ourValues__block-item:last-child {
  margin-bottom: 0;
}
.ourValues__block-item span {
  font-size: 28px;
  line-height: 100%;
  align-self: center;
}
.ourValues__block-item .dot {
  width: 28px;
  height: 28px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  align-self: center;
}

.ourValues__block-item .dot div {
  width: 6px;
  height: 6px;
  background-color: #6083c0;
}
.ourValues__info-scheme {
  position: absolute;
  left: 50%;
  transform: translateX(-25%);
  bottom: 0;
  width: 277px;
  height: 771px;
  opacity: 0.15;
}
.ourValues__info-scheme img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
@media (max-width: 1600px) {
  .ourValues__wrapper {
    column-gap: 20px;
  }
}
@media (max-width: 1199px) {
  .ourValues__wrapper {
    grid-template-columns: 1fr minmax(0, 350px);
  }
  .ourValues__block {
    padding: 66px 45px;
  }
}
@media (max-width: 900px) {
  .ourValues__wrapper {
    grid-template-columns: 1fr;
    row-gap: 22px;
  }
  .ourValues__info-scheme {
    width: 150px;
    height: 417px;
    left: unset;
    right: 0;
    transform: translateX(-25%);
  }
  .ourValues__block {
    padding: 25px 20px;
  }
}
@media (max-width: 767px) {
  .ourValues__block-top {
    margin-bottom: 29px;
  }

  .ourValues__block-top h2 {
    font-size: 14px;
    line-height: 100%;
  }
  .ourValues__block-item span {
    font-size: 18px;
    line-height: 100%;
  }
  .ourValues__block-item .dot {
    width: 18px;
    height: 18px;
  }
  .ourValues__block-item {
    margin-bottom: 22px;
  }
  .ourValues__info-block h3 {
    font-size: 22px;
    line-height: 100%;
    margin-bottom: 22px;
  }
  .ourValues__info-item span {
    font-size: 14px;
    line-height: 120%;
  }
  .ourValues__info-item {
    margin-bottom: 12px;
  }
  .ourValues__info-image {
    width: 26px;
    height: 26px;
    margin-right: 10px;
  }
}
</style>
