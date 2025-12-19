<template>
  <section class="faq">
    <div class="faq__wrapper">
      <questions-section :isFaqPage="true"></questions-section>
    </div>
  </section>
</template>

<script>
import QuestionsSection from "../mainPage/questions/QuestionsSection.vue";
export default {
  components: { QuestionsSection },
};
</script>

<style scoped>
.faq__wrapper {
  padding-top: 60px;
}
@media (max-width: 767px) {
  .faq__wrapper {
    padding-top: 36px;
  }
}
</style>
