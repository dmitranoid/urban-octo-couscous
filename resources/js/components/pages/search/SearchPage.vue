<template>
  <section class="catalog">
    <div class="catalog__wrapper">
      <div class="container">
        <div class="catalog__wrapper-head">
          <h2 v-if="searchString" >Search for: {{ searchString }}</h2>
          <h2 v-else >Search </h2>

          <the-breadcrumbs></the-breadcrumbs>
        </div>
      </div>
      <div class="container">
        <div class="catalog__search">
          <search-block></search-block>
        </div>
      </div>
      <div class="catalog__products">
        <div class="container">
          <div class="catalog__block">
            <card-product v-for="item in dataProducts" :key="item.sku" :dataProduct="item"></card-product>
          </div>
        </div>
      </div>
      <div class="container">
        <button @click="handlerButtonShowMore"
                v-if="pagination.pagesCount !== currentPage
                  && pagination.pagesCount > 1
                  && dataProducts.length !== pagination.itemsTotalCount"
                class="catalog__show">
          <div>
            <img src="@/assets/images/show-product-svg.svg" alt="show-svg" />
            <span>Show {{ pagination.itemsOnNextPageCount }} more products</span>
          </div>
        </button>
        <div class="catalog__pagination">
          <div v-if="pagination.pagesCount > 1"  class="catalog__pagination-block">
            <paginate-pages
                :page-count="pagination.pagesCount"
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

<script>
import SearchBlock from "@/components/ui/SearchBlock.vue";
import PaginatePages from "@/components/ui/PaginatePages.vue";
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import CardProduct from "@/components/ui/CardProduct.vue";
import FeedbackBlock from "@/components/pages/mainPage/feedback/FeedbackBlock.vue";
import {searchProductsPaged} from "@/functions/dataload";

export default {
  data() {
    return {
      currentPage: 1,
      TotalCountPage: 0,
      countAllProducts: 0,
      totalProductsInNextPage: 0,
      pagination: {
        itemsTotalCount: 0,
        itemsPerPage: 24,
        pagesCount: 0,
        currentPage: 1,
        itemsOnNextPageCount: 0,
      },
      dataProducts: [
        // {
        //   name: "6EP1961-2BA11",
        //   description:
        //     "SITOP PSE200U 3 A Selectivity module 4-channel input: 24 V DC/12 A output: 24 V DC/4x 3 A threshold value adjustable 0.5-3 A with common signaling contact *Ex approval no longer available*",
        //   image: "siemens/6EP1961-2BA11.jpg",
        //   path: "/manufacturers/siemens/s7-200/6EP1961-2BA11",
        // },
      ],

    };
  },
  computed: {
    searchString() {
      return this.$route.query.str;
    }
  },
  mounted() {
    window.scrollTo({
      top: 1,
      behavior: "smooth",
    });
    if (this.searchString) {
      this.loadData(this.searchString)
    }
  },
  components: { TheBreadcrumbs, CardProduct, FeedbackBlock, SearchBlock, PaginatePages },
  methods: {
    async pageChangeHandler(pageNo) {
      window.scrollTo({
        top: 1,
        behavior: "smooth",
      });
      this.currentPage = pageNo;
      this.dataProducts = await searchProductsPaged(this.searchString, pageNo);
      if (pageNo > 1 && pageNo === this.pagination.pagesCount-1) {
        const arrayProductsInNextPage = await searchProducts(this.searchString, this.currentPage + 1);
        this.pagination.itemsOnNextPageCount = arrayProductsInNextPage.length;
      }
    },
    async handlerButtonShowMore () {
      this.productsInNextPage = await searchProductsPaged(this.searchString, this.currentShowMorePage + 1);
      this.currentShowMorePage = this.currentShowMorePage + 1;
      this.dataProducts = this.dataProducts.concat(this.productsInNextPage);
    },

    async loadData(searchString) {
      this.dataProducts = await searchProductsPaged(searchString);
      this.pagination.itemsTotalCount = 1000;
      this.pagination.pagesCount = Math.ceil(this.pagination.itemsTotalCount / this.pagination.itemsPerPage);

      if (this.pagination.pagesCount > 1) {
        const arrayProductsInNextPage = await searchProductsPaged(searchString, this.pagination.currentPage + 1);
        this.pagination.itemsOnNextPageCount = arrayProductsInNextPage.length;
      }
    },
  },
};
</script>

<style scoped>
.catalog__pagination-block {
  display: flex;
  align-items: center;
}
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