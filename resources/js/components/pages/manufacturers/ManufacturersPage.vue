<template>
  <section class="manufacturers">
    <div class="container">
      <div class="manufacturers__wrapper">
        <div class="manufacturers__wrapper-head">
          <div>
            <h2>Manufacturers</h2>
            <the-breadcrumbs></the-breadcrumbs>
          </div>
          <div class="manufacturers__wrapper-search">
            <svg
              class="manufacturers__wrapper-svg"
              xmlns="http://www.w3.org/2000/svg"
              width="21"
              height="19"
              fill="none"
            >
              <path
                fill="#272930"
                d="M.001 7.48c0 4.142 3.404 7.479 7.629 7.479 4.224 0 7.628-3.337 7.628-7.48C15.258 3.337 11.855 0 7.63 0S0 3.337 0 7.48ZM7.63 2.876c2.581 0 4.694 2.07 4.694 4.602 0 2.532-2.113 4.603-4.694 4.603-2.582 0-4.695-2.071-4.695-4.603 0-2.531 2.113-4.602 4.695-4.602Z"
              />
              <path fill="#272930" d="m13.727 10.293 6.39 6.266-2.49 2.44-6.389-6.264 2.49-2.441Z" />
            </svg>
            <input v-model="inputSearchValue" type="text" placeholder="Search in list" />
            <button v-if="isVisibleClearSearch" @click="inputSearchValue = ''" class="manufacturers__wrapper-clear">
              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none">
                <path
                  fill="#272930"
                  d="M8.423.101a.337.337 0 0 0-.482 0L5 3.084 2.06.101a.337.337 0 0 0-.483 0L.1 1.6a.35.35 0 0 0 0 .489L2.97 5 .1 7.911a.35.35 0 0 0 0 .49l1.477 1.498a.337.337 0 0 0 .482 0L5 6.916l2.942 2.983a.337.337 0 0 0 .482 0L9.9 8.4a.35.35 0 0 0 0-.489L7.03 5 9.9 2.089a.35.35 0 0 0 0-.49L8.423.102Z"
                />
              </svg>
            </button>
          </div>
        </div>
        <div class="manufacturers__block">
          <div class="manufacturers__card" v-for="item in dataManufacturers" :key="item.name">
            <router-link :to="{ name: 'manufacturer', params: { manufacturer: item.slug } }" :class="{hidden: (item.hidden ? item.hidden : false)}" class="block-overlay"></router-link>
<!--            <div @click="toggleModalForm" class="manufacturers__card-overlay block-overlay"></div>-->
            <img :src="item.image" :alt="item.name" />
          </div>
        </div>
      </div>
    </div>
    <div class="mobile">
      <feedback-block></feedback-block>
    </div>
  </section>
  <modal-form v-if="isVisibleModalForm" @toggle-modal="toggleModalForm"></modal-form>
</template>

<script>
import ModalForm from "@/components/pages/productPage/ModalForm.vue";
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import FeedbackBlock from "@/components/pages/mainPage/feedback/FeedbackBlock.vue";
import { getManufacturers } from "@/functions/dataload";

export default {
  components: { TheBreadcrumbs, FeedbackBlock, ModalForm },
  data() {
    return {
      inputSearchValue: "",
      isVisibleModalForm: false,
      dataManufacturersFullFist: [],
      dataManufacturers: [],
    };
  },
  methods: {
    getImgUrl(pic) {
      return "/assets/images/" + pic;
    },

    toggleModalForm() {
      this.isVisibleModalForm = !this.isVisibleModalForm;
      this.isVisibleModalForm
        ? document.body.classList.add("body-overlay")
        : document.body.classList.remove("body-overlay");
    },

    async loadData() {
      this.dataManufacturersFullFist = await getManufacturers();
      this.dataManufacturers = this.dataManufacturersFullFist;
    },


    filterManufacturers(filterStr) {
      this.dataManufacturers = this.dataManufacturersFullFist.filter(item=>item.name.toLowerCase().includes(filterStr.toLowerCase()));
    }
  },
  computed: {
    isVisibleClearSearch() {
      return this.inputSearchValue;
    },
  },
  mounted() {
    this.loadData();
    window.scrollTo({
      top: 1,
      behavior: "smooth",
    });
  },
  watch: {
    inputSearchValue: function (value) {
      this.filterManufacturers(value);
    },
    $route(to, from) {
      this.loadData();
    }
  }
};
</script>

<style scoped>
.hidden {
  display: none;
}

.mobile {
  display: none;
}
.manufacturers__wrapper {
  padding-top: 60px;
  padding-bottom: 77px;
  min-height: 100vh;
}
.manufacturers__wrapper-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 77px;
}
.manufacturers__wrapper h2 {
  font-size: 46px;
  line-height: 100%;
  margin-bottom: 16px;
}
.manufacturers__wrapper-search {
  width: 334px;
  height: 60px;
  position: relative;
  padding-bottom: 20px;
}
.manufacturers__block {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
}
.manufacturers__card {
  position: relative;
  height: 280px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 1px solid #f4f4f5;
}
.manufacturers__card img {
  width: 140px;
  height: 50px;
  object-fit: cover;
}
.manufacturers__wrapper-search input {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
  font-size: 16px;
  line-height: 100%;
  padding-left: 30px;
  border-bottom: 2px solid rgba(39, 41, 48, 0.5);
  transition: 0.5s ease;
}
.manufacturers__wrapper-search input:focus {
  border-bottom: 2px solid #6083c0;
  transition: 0.5s ease;
}
.manufacturers__wrapper-svg,
.manufacturers__wrapper-clear {
  position: absolute;
}
.manufacturers__wrapper-svg {
  left: 0;
  top: 50%;
  transform: translateY(-50%);
}
.manufacturers__wrapper-clear {
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}
.manufacturers__wrapper-clear svg {
  opacity: 0.5;
}
@media (max-width: 1199px) {
  .manufacturers__card {
    height: 220px;
  }
  .manufacturers__card img {
    width: 100px;
    height: 35px;
  }
}
@media (max-width: 990px) {
  .manufacturers__card img {
    width: 80px;
    height: 15px;
  }
  .manufacturers__card {
    height: 150px;
  }
}
@media (max-width: 767px) {
  .mobile {
    display: block;
  }
  .manufacturers__wrapper-search {
    width: 284px;
  }
  .manufacturers__wrapper-svg {
    transform: translateY(-45%) scale(0.88);
  }
  .manufacturers__wrapper-search input {
    height: 53px;
    font-size: 14px;
    line-height: 100%;
  }
  .manufacturers__wrapper-head {
    margin-bottom: 27px;
  }
  .manufacturers__wrapper {
    padding-top: 36px;
    padding-bottom: 48px;
  }
  .manufacturers__wrapper h2 {
    font-size: 26px;
    line-height: 100%;
    margin-bottom: 12px;
  }
  .manufacturers__wrapper-head {
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
  }
  .manufacturers__card img {
    width: 60px;
    height: 18px;
  }
  .manufacturers__block {
    grid-template-columns: repeat(3, 1fr);
  }
  .manufacturers__card {
    height: 110px;
  }
}
</style>