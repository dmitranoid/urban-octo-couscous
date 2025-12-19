<template>
  <section class="features">
    <div class="features__wrapper">
      <div class="features__wrapper-image">
        <div class="features__block">
          <div class="container">
            <div class="features__container">
              <div class="features__block-info">
                  <h2><slot name="title">We are trusted by more than 1000 enterprises</slot></h2>
                <div class="features__block-button">
                  <router-link to="/contacts" class="block-overlay"></router-link>
                  <span>Contact Us</span>
                </div>
              </div>
              <div class="features__block-content">
                <div class="features__block-card features__block-card--repair">
                  <h3><slot name="repair-title">Repair</slot></h3>
                  <slot name="services-content">
                  <ul>
                    <li v-for="item in dataRepair" :key="item">
                      <div class="dot">
                        <div></div>
                      </div>
                      <span>{{ item }}</span>
                    </li>
                  </ul>
                  </slot>
                </div>
                <div class="features__block-card features__block-card--services">
                  <h3><slot name="services-title">Services</slot></h3>
                  <slot name="services-content">
                  <ul>
                    <li v-for="item in dataServices" :key="item">
                      <div class="dot">
                        <div></div>
                      </div>
                      <span>{{ item }}</span>
                    </li>
                  </ul>
                  </slot>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="features__wrapper-overlay block-overlay"></div>
        <picture>
          <img src="@/assets/images/features-sections.jpg" alt="" />
        </picture>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      dataRepair: [
        "Operator panels of all",
        "Manufacturers cabinets",
        "Frequency converters",
        "Soft starters",
        "Servo drives",
        "FREE DIAGNOSIS",
      ],
      dataServices: [
        "Emergency deliveries",
        "Installation of electrical",
        "Engineering",
        "Programming",
        "Commissioning works",
        "Logistics service",
      ],
    };
  },
};
</script>

<style scoped>
.features__wrapper {
  position: relative;
  padding-bottom: 77px;
}
.features__container {
  display: grid;
  grid-template-columns: 1fr minmax(0, max-content);
  column-gap: 20px;
  height: 100%;
}
.features__block {
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
  z-index: 3;
}
.features__block .container {
  height: 100%;
}
.features__block-info {
  align-self: center;
}
.features__block-info h2 {
  font-size: 36px;
  line-height: 100%;
  color: #ffffff;
  max-width: 487px;
  margin-bottom: 38px;
}
.features__block-button {
  position: relative;
  display: inline-block;
  padding: 0;
  width: 211px;
  height: 64px;
  font-family: "Circe";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 130%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  background: #6083c0;
  transition: 0.5s ease;
}
.features__block-button:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
  transition: 0.5s ease;
}
.features__block-button:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
}
.features__wrapper-image {
  height: 468px;
  position: relative;
}
.features__wrapper-image {
  position: relative;
  width: 100%;
  height: 468px;
  overflow: hidden;
}
.features__wrapper-image img {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 968px;
  object-fit: cover;
}
.features__wrapper-overlay {
  background: linear-gradient(0deg, rgba(39, 41, 48, 0.56), rgba(39, 41, 48, 0.56));
}
.features__block-content {
  align-self: center;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  column-gap: 16px;
}
.features__block-card {
  position: relative;
  width: 347px;
  height: 287px;
  background-color: #ffffff;
  padding: 44px 40px;
  z-index: 10;
}
.features__block-card::before {
  position: absolute;
  content: "";
  left: -8px;
  top: 8px;
  width: 8px;
  height: 100%;
  z-index: -1;
}
.features__block-card::after {
  position: absolute;
  content: "";
  left: -8px;
  bottom: -8px;
  width: 100%;
  height: 8px;
  z-index: -1;
}
.features__block-card--repair::before,
.features__block-card--repair::after {
  background-color: #7bcfb7;
}
.features__block-card--services::before,
.features__block-card--services::after {
  background-color: #6083c0;
}
.features__block-card h3 {
  font-family: "Circe";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  margin-bottom: 17px;
}
.features__block-card li {
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr;
  margin-bottom: 6px;
}
.features__block-card li:last-child {
  margin-bottom: 0;
}
.features__block-card li span {
  font-size: 16px;
  line-height: 140%;
}
.dot {
  width: 22px;
  height: 22px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.dot div {
  width: 6px;
  height: 6px;
}
.features__block-card--repair .dot div {
  background-color: #7bcfb7;
}
.features__block-card--services .dot div {
  background-color: #6083c0;
}
@media (max-width: 1400px) {
  .features__block-card {
    width: 300px;
  }
}
@media (max-width: 1199px) {
  .features__container {
    grid-template-columns: 1fr;
  }
  .features__wrapper-image {
    height: 560px;
  }
  .features__block-info h2 {
    margin-bottom: 15px;
  }
  .features__block-content {
    grid-template-columns: repeat(2, minmax(0, max-content));
  }
  .features__block-content {
    grid-template-columns: repeat(2, 1fr);
  }
  .features__block-card {
    width: 100%;
    height: unset;
    min-height: 287px;
  }
}
@media (max-width: 767px) {
  .features__wrapper-image {
    height: 576px;
  }
  .features__wrapper-image img {
    width: 1156px;
    height: 846px;
    bottom: -60px;
    right: 0px;
  }
  .features__block-card li {
    margin-bottom: 5px;
  }
  .features__block-card li span {
    font-size: 14px;
    line-height: 140%;
  }
  .features__block-card h3 {
    font-size: 16px;
    line-height: 100%;
    margin-bottom: 10px;
  }
  .dot {
    width: 20px;
    height: 20px;
  }
  .features__container {
    row-gap: 18px;
  }
  .features__block-info h2 {
    margin-bottom: 0;
  }
  .features__block-button {
    display: none;
  }
  .features__block-info {
    align-self: flex-end;
  }
  .features__block-content {
    align-self: flex-start;
  }
  .features__wrapper {
    padding-bottom: 36px;
  }
}
@media (max-width: 600px) {
  .features__block-info h2 {
    font-size: 22px;
    line-height: 100%;
  }
  .features__block-content {
    grid-template-columns: 1fr;
    row-gap: 14px;
  }
  .features__block-card {
    padding: 22px 20px;
    min-height: 216px;
  }
}
</style>
