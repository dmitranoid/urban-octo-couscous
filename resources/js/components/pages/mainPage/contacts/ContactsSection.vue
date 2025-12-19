<template>
  <section class="contacts">
    <div class="container">
      <div class="contacts__wrapper">
        <h2 v-if="!isContactsPage">Contacts</h2>
        <div class="contacts__list">
          <slider-tab
            :dataContacts="!isContactsPage ? dataContacts.filter((item) => item.active) : dataContacts"
            :activeIdx="activeIdx"
            @setActiveIdx="setActiveIdx"
          ></slider-tab>
        </div>
        <div class="contacts__block">
          <div
            v-for="(item, idx) in !isContactsPage ? dataContacts.filter((item) => item.active) : dataContacts"
            :class="['contacts__card', { 'contacts__card--hidden': idx !== activeIdx }]"
            :key="item.name"
          >
            <div class="contacts__card-image">
              <div v-if="!item.active" class="contacts__card-overlay block-overlay"></div>
              <picture>
                <img :src="item.image" alt="contacts-image" />
              </picture>
            </div>
            <div class="contacts__card-info">
              <h3>{{ item.name }}</h3>
              <p :class="[{ 'contacts__disabled-address': !item.active }]">
                <svg v-if="!item.active" xmlns="http://www.w3.org/2000/svg" width="16" height="19" fill="none">
                  <path
                    fill="#272930"
                    d="M2.596 18.772c-.447 0-.827-.157-1.14-.47a1.553 1.553 0 0 1-.47-1.14V8.15c0-.453.157-.836.47-1.148a1.556 1.556 0 0 1 1.14-.468H3.78v-1.89c0-1.184.411-2.188 1.234-3.013C5.837.807 6.832.394 7.998.394c1.167 0 2.162.413 2.986 1.238.824.825 1.236 1.83 1.236 3.013v1.89h1.183c.449 0 .83.156 1.145.468.314.312.471.695.471 1.148v9.01c0 .447-.157.827-.471 1.14a1.56 1.56 0 0 1-1.145.47H2.596Zm0-1.61h10.807V8.15H2.596v9.01Zm5.41-2.782c.472 0 .873-.164 1.204-.49.33-.327.495-.72.495-1.178 0-.446-.167-.848-.5-1.208a1.59 1.59 0 0 0-1.21-.54c-.473 0-.874.18-1.205.54-.33.361-.495.767-.495 1.22 0 .452.167.842.5 1.167a1.67 1.67 0 0 0 1.21.489ZM5.39 6.535h5.22V4.646c0-.741-.254-1.366-.76-1.874A2.512 2.512 0 0 0 8 2.01c-.725 0-1.342.254-1.85.762-.507.508-.76 1.133-.76 1.874v1.89Z"
                  />
                </svg>
                {{ item.address }}
              </p>
              <a class="mail" :href="'mailto:' + item.mail">{{ item.mail }}</a>
              <a class="phone" :href="'tel:+' + item.phone">{{ item.phone }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import SliderTab from "./SliderTab.vue";
import {axiosFetcher, getParam} from "@/functions/dataload";
import useSWRV from "swrv";
import * as urlgen from "@/functions/urlgen";
import * as utils from "@/functions/utils";
import {ref, watchEffect} from "vue";
import {getSWRVOptions} from "@/functions/utils";

export default {
  props: {
    isContactsPage: {
      type: Boolean,
      default: false,
    },
  },
  components: { SliderTab },

  setup() {
    let pageBlocks = {};
    let dataContacts = [
      {
        image: "/assets/images/contacts-1.jpg",
        name: "Head office",
        address: "aleja Armii Krajowej 61, 50-541 Wrocław, Poland",
        mail: "info@etrade-ag.com",
        phone: "+48 786 434 232",
        active: true,
      },
      {
        image: "/assets/images/contacts-2.jpg",
        name: "Ukraine office",
        address: "1B, Postysheva street, Brovary, Kiev region, Ukraine, 07400",
        mail: "⁠office@e-trade.org.ua",
        phone: "+38 096 071 22 22",
        active: true,
      },
      {
        image: "/assets/images/contacts-3.jpg",
        name: "Kiev Office",
        address: "37-41 Sichovykh Striltsiv Street, Kyiv, Ukraine, 04053",
        mail: "info@e-trade.org.ua",
        phone: "+38 067 323 67 23",
        active: true,
      },
      {
        image: "/assets/images/contacts-4.jpg",
        name: "New York office",
        address: "Coming Soon",
        mail: "info@etrade-ag.com",
        phone: "+48 786 434 232",
        active: false,
      },
      {
        image: "/assets/images/contacts-5.jpg",
        name: "Singapore office",
        address: "Coming Soon",
        mail: "info@etrade-ag.com",
        phone: "+48 786 434 232",
        active: false,
      },
      {
        image: "/assets/images/contacts-6.jpg",
        name: "Vancouver Office",
        address: "Coming Soon",
        mail: "info@etrade-ag.com",
        phone: "+48 786 434 232",
        active: false,
      },
    ];
    const pageName = 'contacts-block';

    const {data: respPageBlocks} = useSWRV(urlgen.urlPageBlocks(pageName), utils.getDataFetcher(), getSWRVOptions());

    watchEffect(()=>{
      if (respPageBlocks.value) {
        pageBlocks = respPageBlocks.value.data;
        dataContacts = [];
        for (const i in pageBlocks) {
          const contact = mapDataContact(pageBlocks[i]);
          dataContacts.push(contact);
        }
      }
    });

    function mapDataContact(block) {
      return {
        image: block.image ?? "",
        name: block.name ?? "",
        address: getParam(block.params, "address"),
        mail: getParam(block.params, "email"),
        phone: getParam(block.params, "phone"),
        active: true,
      }
    }

    return {
      dataContacts,
    }
  },

  data() {
    return {
      activeIdx: 0,
    };
  },
  mounted() {
    // const {data: respContacts} = useSWRV(urlgen.urlPageBlocks(useRoute().name), axiosFetcher, {cache: utils.getCacheStorage()})
    // this.loadPageData(this.pageName).then(()=> {
    //   this.dataContacts = [];
    //   for (const i in this.pageBlocks) {
    //     const contact = this.mapDataContact(this.pageBlocks[i]);
    //     this.dataContacts.push(contact);
    //   }
    // });
  },
  methods: {
    setActiveIdx(idx) {
      this.activeIdx = idx;
    },
    getImgUrl(pic) {
      return "/assets/images/" + pic;
    },

  },
};
</script>

<style scoped>
.contacts__disabled-address {
  position: relative;
  padding-left: 25px;
  height: unset !important;
  margin-bottom: 18px !important;
}
.contacts__disabled-address svg {
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
}
.contacts__card-overlay {
  background: #ffffff;
  opacity: 0.6;
}
.contacts__list {
  display: none;
}
.contacts__wrapper {
  padding-bottom: 84px;
}
.contacts__wrapper h2 {
  font-size: 36px;
  line-height: 100%;
  margin-bottom: 44px;
}
.contacts__block {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  column-gap: 32px;
  row-gap: 52px;
}
.contacts__card-image {
  position: relative;
  width: 100%;
  max-height: 365px;
  margin-bottom: 27px;
}
.contacts__card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.contacts__card-info {
  display: flex;
  flex-direction: column;
}
.contacts__card h3 {
  font-size: 22px;
  line-height: 100%;
  margin-bottom: 20px;
}
.contacts__card p {
  font-size: 16px;
  line-height: 100%;
  opacity: 0.5;
  margin-bottom: 8px;
}
.contacts__card .mail,
.contacts__card .phone {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: #6083c0;
}
.contacts__card .mail {
  text-decoration-line: underline;
  margin-bottom: 19px;
}
@media (max-width: 1600px) {
  .contacts__card p {
    height: 32px;
  }
}
@media (max-width: 1400px) {
  .contacts__block {
    column-gap: 20px;
  }
}
@media (max-width: 1199px) {
  .contacts__card p {
    height: unset;
    margin-bottom: 13px;
  }
  .contacts__list {
    display: flex;
    margin-bottom: 25px;
  }

  .contacts__item:last-child {
    margin-right: 0;
  }
  .contacts__card--hidden {
    display: none;
  }
  .contacts__card-image {
    max-height: unset;
    height: 300px;
    width: 462px;
  }
  .contacts__block {
    grid-template-columns: minmax(0, max-content);
  }
}
@media (max-width: 767px) {
  .contacts__wrapper h2 {
    font-size: 22px;
    line-height: 100%;
    margin-bottom: 27px;
  }
  .contacts__card-image {
    margin-bottom: 20px;
  }

  .contacts__card h3 {
    font-size: 16px;
    line-height: 100%;
    margin-bottom: 16px;
  }
  .contacts__card p {
    font-size: 12px;
    line-height: 100%;
    height: unset;
    margin-bottom: 13px;
  }
  .contacts__card .mail,
  .contacts__card .phone {
    font-size: 12px;
    line-height: 100%;
  }
  .contacts__card .mail {
    margin-bottom: 13px;
  }
  .contacts__wrapper {
    padding-bottom: 37px;
  }
}
@media (max-width: 600px) {
  .contacts__block {
    grid-template-columns: 1fr;
  }
  .contacts__wrapper h2,
  .contacts__card-info {
    padding-left: 18px;
    padding-right: 18px;
  }
  .contacts__list {
    padding-left: 18px;
  }
  .contacts .container {
    padding: 0;
  }
  .contacts__card-image {
    width: 100%;
    height: 186px;
  }
}
</style>