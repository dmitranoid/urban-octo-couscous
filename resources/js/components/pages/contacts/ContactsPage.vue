<template>
  <section class="contacts">
    <div class="contacts__wrapper">
      <div class="container">
        <h2>Contacts</h2>
        <div class="contacts__breadcrumbs">
          <the-breadcrumbs></the-breadcrumbs>
        </div>
      </div>
      <contacts-section :isContactsPage="true"></contacts-section>
    </div>
  </section>
</template>

<script>
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import ContactsSection from "../mainPage/contacts/ContactsSection.vue";
export default {
  components: { ContactsSection, TheBreadcrumbs },
  mounted() {
    window.scrollTo({
      top: 1,
      behavior: "smooth",
    });
  },
};
</script>

<style scoped>
.contacts__wrapper {
  padding-top: 60px;
}
.contacts__wrapper h2 {
  font-size: 46px;
  line-height: 100%;
  margin-bottom: 16px;
}
.contacts__breadcrumbs {
  margin-bottom: 51px;
}
@media (max-width: 767px) {
  .contacts__wrapper {
    padding-top: 36px;
  }
  .contacts__wrapper h2 {
    font-size: 26px;
    line-height: 100%;
    margin-bottom: 12px;
  }
  .contacts__breadcrumbs {
    margin-bottom: 36px;
  }
}
@media (max-width: 400px) {
  .contacts__breadcrumbs {
    margin-bottom: 26px;
  }
}
</style>
