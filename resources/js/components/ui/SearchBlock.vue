<template>
  <div class="search__wrapper">
    <div class="search__wrapper-input">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" fill="none">
        <g fill="#272930" opacity=".2">
          <path
            d="M0 8.18c0 4.53 3.722 8.178 8.342 8.178 4.62 0 8.342-3.649 8.342-8.179S12.962 0 8.342 0C3.722 0 0 3.65 0 8.18Zm8.342-5.034c2.823 0 5.133 2.265 5.133 5.033 0 2.768-2.31 5.033-5.133 5.033-2.824 0-5.134-2.265-5.134-5.033 0-2.768 2.31-5.033 5.134-5.033Z"
          />
          <path d="M15.012 11.257 22 18.108l-2.722 2.67-6.988-6.852 2.723-2.669Z" />
        </g>
      </svg>
      <input v-model="searchStr" @keydown.enter="goSearchPage()" type="text" placeholder="Search by part number"/>
    </div>
    <button @click="goSearchPage()">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" fill="none">
          <path
            fill="#fff"
            d="M0 8.18c0 4.53 3.722 8.178 8.342 8.178 4.62 0 8.342-3.649 8.342-8.179S12.962 0 8.342 0C3.722 0 0 3.65 0 8.18Zm8.342-5.034c2.823 0 5.133 2.265 5.133 5.033 0 2.768-2.31 5.033-5.133 5.033-2.824 0-5.134-2.265-5.134-5.033 0-2.768 2.31-5.033 5.134-5.033Z"
          />
          <path fill="#fff" d="M15.012 11.257 22 18.108l-2.722 2.67-6.988-6.852 2.723-2.669Z" />
        </svg>
        <span>Search</span>
      </div>
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchStr: "",
    }
  },
  methods: {
    goSearchPage() {
      this.$router.push({name: 'search', query: {str: this.searchStr}});
    }
  }
};
</script>

<style scoped>
.search__wrapper {
  display: grid;
  grid-template-columns: 1fr minmax(0, max-content);
  height: 86px;
  box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
}
.search__wrapper-input {
  position: relative;
}
.search__wrapper-input svg {
  position: absolute;
  left: 34px;
  top: 50%;
  transform: translateY(-50%);
}
.search__wrapper-input input {
  width: 100%;
  height: 100%;
  background-color: #fff;
  padding: 0 69px;
}
.search__wrapper button {
  padding: 0;
  background: #6083c0;
  width: 233px;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transition: 0.5s ease;
}
.search__wrapper button:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
  transition: 0.5s ease;
}
.search__wrapper button:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
}
.search__wrapper button div {
  display: flex;
  align-items: center;
}
.search__wrapper button svg {
  margin-right: 9px;
}
.search__wrapper button span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 100%;
  color: #ffffff;
}
@media (max-width: 767px) {
  .search__wrapper {
    height: 56px;
  }
  .search__wrapper button span {
    display: none;
  }
  .search__wrapper button {
    width: 56px;
  }
  .search__wrapper button svg {
    margin: 0;
    position: relative;
    transform: scale(0.85);
  }
  .search__wrapper-input svg {
    display: none;
  }
  .search__wrapper-input input {
    padding: 0 23px;
    font-size: 14px;
    line-height: 14px;
  }
}
</style>