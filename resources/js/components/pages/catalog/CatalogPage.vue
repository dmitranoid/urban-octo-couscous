<template>
  <section class="catalog">
    <div class="catalog__wrapper">
      <div class="container">
        <div class="catalog__wrapper-head">
          <h2 v-if="dataManufacturer">{{ dataManufacturer.name }}</h2>
          <the-breadcrumbs></the-breadcrumbs>
        </div>
      </div>
      <slider-catalog :dataSlideCatalog="dataCategories"></slider-catalog>
      <div class="container">
        <div class="catalog__search">
          <search-block></search-block>
        </div>
      </div>
      <div class="catalog__products">
        <div class="container">
          <div class="catalog__block">
            <template v-if="dataProducts">
              <card-product v-for="item in dataProducts" :key="item" :dataProduct="item"></card-product>
            </template>
          </div>
        </div>
      </div>
      <div class="container">
        <button @click="handlerButtonShowMore"
                v-if="paginator.itemsLeft > 0"
                class="catalog__show"
        >
          <div>
            <img src="@/assets/images/show-product-svg.svg" alt="show-svg"/>
            <span>Show {{ paginator.itemsShowMore }} more products</span>
          </div>
        </button>
        <div class="catalog__pagination">
          <div v-if="paginator.totalPages > 1" class="catalog__pagination-block">
            <paginate-pages
                :page-count="paginator.totalPages"
                :force-page="paginator.currentPage"
                :click-handler="pageChangeHandler"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'className'">
            </paginate-pages>
          </div>
        </div>
      </div>
    </div>
  </section>
  <feedback-block></feedback-block>
</template>

<script setup>
import SearchBlock from "@/components/ui/SearchBlock.vue";
import PaginatePages from "@/components/ui/PaginatePages.vue";
import SliderCatalog from "./SliderCatalog.vue";
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import CardProduct from "@/components/ui/CardProduct.vue";
import FeedbackBlock from "@/components/pages/mainPage/feedback/FeedbackBlock.vue";
import {onMounted, ref, unref, watch, watchEffect} from "vue";
import {useRoute} from "vue-router/dist/vue-router";
import useSWRV from "swrv";
import {urlManufacturer, urlCategories, urlProductsPaged} from "@/functions/urlgen";
import {axiosFetcher, getProductsPaged} from "@/functions/dataload.js";
import LocalStorageCache from "swrv/esm/cache/adapters/localStorage";

let dataManufacturer = ref(null);
let dataProducts = ref([]);
let metaProducts = ref(null);
let dataCategories = ref(null);
let paginator = ref({
  firstPage: 1,
  totalPages: 1,
  currentPage: 1,
  itemsPerPage: 24,
  totalItems: 0,
  get itemsLeft() {
    return (this.totalItems - (this.itemsPerPage * this.currentPage) > 0) ? this.totalItems - (this.itemsPerPage * this.currentPage) : 0
  },
  get itemsShowMore() {
    return this.itemsLeft > this.itemsPerPage ? this.itemsPerPage : this.itemsLeft
  },
});

const route = useRoute();

const {data: respManufacturer} = useSWRV(
    urlManufacturer(route.params.manufacturer),
    axiosFetcher,
    {
      cache: new LocalStorageCache('swrv'),
      revalidateOnFocus: false,
      dedupingInterval: 30 * 60 * 1000 //30 minutes
    }
)
const {data: respCategories} = useSWRV(
    () => dataManufacturer.value && urlCategories(dataManufacturer.value.id),
    axiosFetcher,
    {
      cache: new LocalStorageCache('swrv'),
      revalidateOnFocus: false,
      dedupingInterval: 30 * 60 * 1000 //30 minutes
    }
)
const {data: respProducts} = useSWRV(
    () => dataManufacturer.value && urlProductsPaged(dataManufacturer.value.id, null, 1),
    axiosFetcher,
    {
      cache: new LocalStorageCache('swrv'),
      revalidateOnFocus: false,
      dedupingInterval: 30 * 60 * 1000 //30 minutes
    }
)

onMounted(() => {
  window.scrollTo({
    top: 1,
    behavior: "smooth",
  });
})

async function handlerButtonShowMore() {
  const resp = await getProductsPaged(dataManufacturer.value.id, null, paginator.value.currentPage + 1);
  const productsNextPage = resp.data.data;
  metaProducts.value = resp.data.meta;
  paginator.value.currentPage = metaProducts.value.current_page;
  productsNextPage.forEach((item) => {
    dataProducts.value.push(item)
  })
}

async function pageChangeHandler(page) {
  window.scrollTo({
    top: 1,
    behavior: "smooth",
  });
  const resp = await getProductsPaged(dataManufacturer.value.id, null, page);
  const productsNextPage = resp.data.data;
  metaProducts.value = resp.data.meta;
  paginator.value.currentPage = metaProducts.value.current_page;
  dataProducts.value = productsNextPage;
}

watch(route, () => {

});

watch(respManufacturer, () => {
      if (respManufacturer.value) {
        dataManufacturer.value = respManufacturer.value.data;
      } else {
        dataManufacturer.value = null;
      }
    },
    {deep: true, immediate: true}
)

watch(respCategories, () => {
      if (respCategories.value) {
        dataCategories.value = respCategories.value.data;
      } else {
        dataCategories.value = null;
      }
    },
    {deep: true, immediate: true}
);

watch(respProducts, () => {
      if (respProducts.value) {
        const data = respProducts.value;
        dataProducts.value = data.data;
        //data.data.forEach((item) => dataProducts.value.push(item));
        metaProducts.value = data.meta;
        paginator.value.totalPages = metaProducts.value.last_page;
        paginator.value.totalItems = metaProducts.value.total;
        paginator.value.currentPage = metaProducts.value.current_page;
        paginator.value.totalItems = metaProducts.value.total;
      } else {
        dataProducts.value = null;
        paginator.value.totalPages = 1;
        paginator.value.totalItems = 0;
        paginator.value.currentPage = 1;
        paginator.value.totalItems = 0;
      }

    },
    {deep: true, immediate: true}
)

</script>

<style scoped>
.catalog__pagination {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.catalog__pagination-arrow--prev {
  margin-right: 17px;
}

.catalog__pagination-arrow--next {
  margin-left: 17px;
}

.catalog__pagination-block {
  display: flex;
  align-items: center;
}

.catalog__pagination-list {
  display: flex;
  align-items: center;
}

.catalog__pagination-item {
  cursor: pointer;
  width: 46px;
  height: 46px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 2px solid transparent;
}

.catalog__pagination-item--active {
  border: 2px solid #6083c0;
}

.catalog__show {
  padding: 0;
  width: 100%;
  height: 70px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 2px solid rgba(39, 41, 48, 0.1);
  margin-bottom: 40px;
  transition: 0.5s ease;
  background-color: transparent;
}

.catalog__show:hover {
  transition: 0.5s ease;
  border: 2px solid rgba(123, 207, 183, 1);
}

.catalog__show:active {
  transition: 0.5s ease;
  background-color: rgba(123, 207, 183, 0.15);
}

.catalog__pagination-arrow {
  cursor: pointer;
}

.catalog__show div {
  display: flex;
  align-items: center;
}

.catalog__show img {
  width: 22px;
  height: 22px;
  margin-right: 10px;
}

.catalog__show span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
}

.catalog__wrapper {
  padding-top: 60px;
  padding-bottom: 75px;
}

.catalog__wrapper h2 {
  font-size: 46px;
  line-height: 100%;
  margin-bottom: 16px;
}

.catalog__wrapper-head {
  margin-bottom: 48px;
}

.catalog__search {
  margin-bottom: 65px;
}

.catalog__block {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  margin-bottom: 43px;
}

@media (max-width: 1199px) {
  .catalog__block {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 990px) {
  .catalog__block {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 767px) {
  .catalog__show {
    height: 50px;
    margin-bottom: 28px;
  }

  .catalog__show img {
    width: 16px;
    height: 16px;
    margin-right: 6px;
  }

  .catalog__show span {
    font-size: 14px;
    line-height: 100%;
  }

  .catalog__block {
    margin-bottom: 22px;
  }

  .catalog__products .container {
    padding: 0;
  }

  .catalog__search {
    margin-bottom: 34px;
  }
}
</style>