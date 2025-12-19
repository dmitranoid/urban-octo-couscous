<template>
  <div class="automation">
    <div class="automation__wrapper">
      <div class="container">
        <div class="automation__block">
          <div class="automation__title">
            <div class="automation__title-block">
              <div class="automation__title-head">
                <block-line></block-line>
                <h2><slot name="title">E-TRADE AUTOMATION</slot></h2>
              </div>
              <h3>
                <slot name="subtitle">
                Group of companies was founded in 2014 and since has established itself as a reliable supplier of
                automation components and control systems from leading OEMs.
                </slot>
              </h3>
            </div>
          </div>
          <!--текстовый блок для дескотопа, который скрывается на мобилке, для мобилки - стр.40 -->
          <div class="automation__text automation__text--desctop">
            <div class="automation__text-block">
              <slot name="content">
              <div>
              <p>
                Our company is one of the world leader in the supply of automation components, and we are proud to have
                been supplying our products all over the world for more than 8 years. We are confident in the quality of
                our products and guarantee shipping within 24 hours of ordering
              </p>
              <p>
                We value every employee and are proud that not one of our colleagues has left since the opening of the
                company. Our team consists of the best specialists in the industry, who work together to provide fast
                and high-quality delivery of the necessary components for our partners.
              </p>
              </div>
              </slot>
            </div>
          </div>
        </div>
      </div>
      <div class="automation__banner">
        <slot name="image">
        <picture>
          <img src="@/assets/images/automation-banner.jpg" alt="automation__banner" />
        </picture>
        </slot>
      </div>
      <div class="automation__text automation__text--mobile">
        <div class="container">
          <div class="automation__text-block">
            <p>
              Our company is one of the world leader in the supply of automation components, and we are proud to have
              been supplying our products all over the world for more than 8 years. We are confident in the quality of
              our products and guarantee shipping within 24 hours of ordering
            </p>
            <p>
              We value every employee and are proud that not one of our colleagues has left since the opening of the
              company. Our team consists of the best specialists in the industry, who work together to provide fast and
              high-quality delivery of the necessary components for our partners.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BlockLine from "@/components/ui/BlockLine.vue";

export default {
  components: { BlockLine },
};
</script>

<style scoped>
.automation__block {
  display: grid;
  grid-template-columns: minmax(0, 1000px) minmax(0, 700px);
  column-gap: 40px;
}

.automation__title {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.automation__title-block {
  max-width: 634px;
}
.automation__title-head {
  display: flex;
  align-items: center;
  margin-bottom: 26px;
}
.automation__title-head h2 {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
}
.automation__title-block h3 {
  font-size: 36px;
  line-height: 100%;
}

.automation__text {
  padding-top: 40px;
}
.automation__text-block {
  max-width: 626px;
}
.automation__banner {
  position: relative;
  z-index: 2;
  margin-top: 67px;
  margin-bottom: 85px;
  width: 100%;
  max-height: 526px;
}
.automation__banner img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.automation__text--mobile {
  display: none;
}
@media (max-width: 990px) {
  .automation__block {
    grid-template-columns: 1fr;
  }
  .automation__text--desctop {
    display: none;
  }
  .automation__text--mobile {
    display: block;
    padding-top: 0;
    margin-bottom: 32px;
  }
  .automation__text--mobile .automation__text-block {
    max-width: 100%;
  }
  .automation__banner {
    margin-bottom: 22px;
  }
}
@media (max-width: 767px) {
  .automation__title-head h2 {
    font-size: 14px;
    line-height: 100%;
  }
  .automation__title-head {
    margin-bottom: 16px;
  }
  .automation__title-block h3 {
    font-size: 22px;
    line-height: 100%;
  }
  .automation__banner {
    margin-top: 22px;
  }
  .automation__text-block p {
    font-size: 12px;
    line-height: 140%;
    margin-bottom: 10px;
  }
}
</style>

<style>

.automation__text-block div p  {
  font-size: 16px;
  line-height: 140%;
  opacity: 0.6;
  margin-bottom: 20px;
}
.automation__text-block div p:last-child {
  margin-bottom: 0;
}

</style>