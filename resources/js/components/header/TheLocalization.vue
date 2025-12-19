<template>
  <ul>
    <li
      v-for="(item, idx) in arrayLocalizaton"
      @click="changeLocalization(idx)"
      :key="item.name"
      :class="{ active: item.isActive }"
    >
      {{ item.name }}
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    dataLocalization: Array,
  },
  data() {
    return {
      arrayLocalizaton: this.dataLocalization,
    };
  },
  methods: {
    changeLocalization(activeIdx) {
      this.arrayLocalizaton = this.arrayLocalizaton.map((item, idx) => {
        if (idx === activeIdx) {
          item.isActive = true;
        }
        if (idx !== activeIdx) {
          item.isActive = false;
        }
        return item;
      });
    },
  },
};
</script>

<style scoped>
li {
  cursor: pointer;
  font-family: "Circe";
  font-style: normal;
  font-weight: 700;
  font-size: 14px;
  line-height: 100%;
  color: #272930;
  opacity: 0.3;
  transition: 0.5s ease;
  margin-right: 16px;
}
li:last-child {
  margin-right: 0;
}
.active {
  transition: 0.5s ease;
  opacity: 1;
}
</style>
