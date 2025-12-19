<template>
  <footer class="footer">
    <div class="container">
      <div class="footer__wrapper">
        <div class="footer__logo">
          <div class="footer__logo-block">
            <router-link to="/" class="block-overlay"></router-link>
            <div class="footer__logo-left">
              <picture>
                <img src="@/assets/images/logo-footer-left.svg" alt="logo"/>
              </picture>
            </div>
            <div class="footer__logo-right">
              <picture>
                <img src="@/assets/images/logo-footer-right.svg" alt="logo"/>
              </picture>
            </div>
          </div>
          <p>
            Welcome to E-Trade Automation Company, which has a wide selection of industrial automation and electronics
            components. We are your reliable partner for solving problems in the field of industrial automation.
          </p>
          <span>Copyright © E-Trade Automation, 2023</span>
          <p class="copyright-content">Copyright 2023 by E-TRADE AUTOMATION GROUP. All product names, logos, and brands
            are property of their respective owners. All company, product and service names used in this website are for
            identification purposes only. Use of these names, logos, and brands does not imply endorsement.</p>
        </div>
        <nav class="footer__nav">
          <ul>
            <li v-for="item in dataNavFooter" :key="item.name">
              <router-link :to="item.path" class="block-overlay"></router-link>
              {{ item.name }}
            </li>
          </ul>
        </nav>
        <div class="footer__info">
          <div class="footer__info-block">
            <a class="footer__info-phone" :href="`tel:${designSettings?.phone ?? ''}`">{{ designSettings?.phone ?? '' }}</a>
            <p>{{ designSettings?.address ?? '' }}</p>
            <a class="footer__info-mail" :href="`mailto:${designSettings?.email??''}`">{{ designSettings?.email ?? '' }}</a>
            <ul class="footer__social">
              <li class="footer__social-item">
                <a class="block-overlay" href="https://www.linkedin.com/company/e-trade-automation/?viewAsMember=true" target="_blank"></a>
                <div class="footer__social-image">
                  <picture>
                    <img src="@/assets/images/LinkedIn.svg" alt="LinkedIn"/>
                  </picture>
                </div>
              </li>
              <li class="footer__social-item">
                <a class="block-overlay" href="https://www.youtube.com/channel/UCrk4NbjepfOuHpXN9oQEwnQ" target="_blank"></a>
                <div class="footer__social-image">
                  <picture>
                    <img src="@/assets/images/YouTube.svg" alt="YouTube"/>
                  </picture>
                </div>
              </li>
              <li class="footer__social-item">
                <a class="block-overlay" href="https://www.facebook.com/etradeautomationcompany" target="_blank"></a>
                <div class="footer__social-image">
                  <picture>
                    <img src="@/assets/images/Facebook.svg" alt="Facebook"/>
                  </picture>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="footer__question">
          <div class="footer__question-block">
            <h3>Have any questions?</h3>
            <p>Ask them now</p>
            <div class="footer__question-button">
              <span>Ask a question</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import {ref, watch} from "vue";
import useSWRV from "swrv";
import {urlSettings} from "@/functions/urlgen";
import {getDataFetcher, getSWRVOptions} from "@/functions/utils";

const dataNavFooter = [
  {
    name: "About",
    path: "/about",
  },
  {
    name: "Shipping",
    path: "/shipping",
  },
  {
    name: "FAQ",
    path: "/faq",
  },
  {
    name: "Contacts",
    path: "/contacts",
  },
];

// await getSettings('general-design');
let designSettings = ref([]);

const {data: designSettingsResp} = useSWRV(urlSettings('general-design'), getDataFetcher(), getSWRVOptions());

watch(designSettingsResp, ()=> {
  if (designSettingsResp.value) {
    designSettings.value = designSettingsResp.value.data;
  } else {
    designSettings.value = null;
  }
}, {deep: true, immediate: true})

</script>


<style scoped>
.footer {
  border-top: 1px solid #f4f4f5;
}

.footer__wrapper {
  padding: 80px 0;
  display: grid;
  grid-template-columns: minmax(0, 350px) minmax(0, 196px) minmax(0, 420px) 1fr;
}

.footer__logo-block {
  position: relative;
  display: flex;
  align-items: center;
  margin-bottom: 26px;
}

.footer__logo-left {
  width: 32px;
  height: 39px;
  margin-right: 17px;
}

.footer__logo-right {
  width: 97px;
  height: 42px;
}

.footer__logo-left img,
.footer__logo-right img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

.footer__logo p,
.footer__logo span {
  font-size: 14px;
  line-height: 100%;
  color: #272930;
  margin-bottom: 30px;
}

.footer__logo p {
  opacity: 0.3;
}

.footer__logo span {
  opacity: 0.4;
}

.footer__nav,
.footer__info,
.footer__question {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.footer__nav li {
  position: relative;
  cursor: pointer;
  padding: 17.5px 0;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
}

.footer__nav li:first-child {
  padding-top: 0;
}

.footer__nav li:last-child {
  padding-bottom: 0;
}

.footer__info-phone {
  display: block;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 26px;
  line-height: 100%;
  color: #6083c0;
  margin-bottom: 20px;
  opacity: 1;
  transition: 0.5s ease;
}

.footer__info-mail {
  display: block;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: #6083c0;
  margin-bottom: 27px;
  text-decoration: underline;
  opacity: 1;
  transition: 0.5s ease;
}

.footer__info-phone:hover,
.footer__info-mail:hover {
  opacity: 0.5;
  transition: 0.5s ease;
}

.footer__info-phone:active,
.footer__info-mail:active {
  opacity: 0.7;
}

.footer__info-block p {
  font-size: 16px;
  line-height: 100%;
  color: #272930;
  opacity: 0.5;
  margin-bottom: 19px;
}

.footer__social {
  display: flex;
  align-items: center;
}

.footer__social-item {
  position: relative;
  width: 46px;
  height: 46px;
  border: 1.5px solid #7bcfb7;
  border-radius: 50%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-right: 8px;
}

.footer__social-item:last-child {
  margin-right: 0;
}

.footer__social-image {
  width: 22px;
  height: 22px;
}

.footer__social-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

.footer__question-block h3 {
  font-size: 22px;
  line-height: 100%;
  margin-bottom: 5px;
  text-align: right;
}

.footer__question-block p {
  display: block;
  width: 100%;
  font-size: 14px;
  line-height: 140%;
  text-align: right;
  opacity: 0.6;
  margin-bottom: 22px;
}

.footer__question-button {
  width: 196px;
  height: 60px;
  border: 2px solid #f4f4f5;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: rgba(96, 131, 192, 1);
  background: transparent;
  transition: 0.5s ease;
}

.footer__question-button:hover {
  border: 2px solid transparent;
  color: #fff;
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #ffffff;
  transition: 0.5s ease;
}

.footer__question-button:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #ffffff;
}

@media (max-width: 1700px) {
  .footer__wrapper {
    column-gap: 20px;
  }

  .footer__nav,
  .footer__info {
    align-items: center;
  }
}

@media (max-width: 990px) {
  .footer__wrapper {
    grid-template-columns: repeat(2, 1fr);
    row-gap: 42px;
  }

  .footer__nav {
    align-items: flex-end;
  }

  .footer__info {
    align-items: flex-start;
  }
}

@media (max-width: 600px) {
  .footer__wrapper {
    padding-top: 24px;
    padding-bottom: 35px;
  }

  .footer__logo p,
  .footer__logo span {
    display: none;
  }

  .footer__logo-block {
    margin-bottom: 32px;
  }

  .footer__logo-left {
    width: 21px;
    height: 25px;
    margin-right: 11px;
  }

  .footer__logo-right {
    width: 63px;
    height: 27px;
  }

  .footer__nav li {
    font-size: 14px;
    line-height: 100%;
    padding: 13px 0;
  }

  .footer__nav {
    margin-bottom: 42px;
  }

  .footer__info-phone {
    font-size: 20px;
    line-height: 100%;
    margin-bottom: 16px;
  }

  .footer__info-block p {
    font-size: 12px;
    line-height: 100%;
    margin-bottom: 10px;
  }

  .footer__info-mail {
    font-size: 12px;
    line-height: 100%;
    margin-bottom: 19px;
  }

  .footer__info {
    margin-bottom: 48px;
  }

  .footer__social-image {
    width: 19px;
    height: 19px;
  }

  .footer__social-item {
    width: 40px;
    height: 40px;
    margin-right: 6px;
  }

  .footer__wrapper {
    grid-template-columns: 1fr;
    row-gap: 0;
  }

  .footer__nav,
  .footer__question {
    align-items: flex-start;
  }

  .footer__question-block h3 {
    font-size: 16px;
    line-height: 100%;
    margin-bottom: 4px;
    text-align: left;
  }

  .footer__question-block p {
    text-align: left;
    font-size: 12px;
    line-height: 140%;
    margin-bottom: 13px;
  }

  .footer__question-button {
    width: 155px;
    height: 42px;
    font-size: 14px;
    line-height: 100%;
  }
}
</style>