<template>
  <section class="about">
    <div class="about__breadcrumbs">
      <div class="container">
        <the-breadcrumbs></the-breadcrumbs>
      </div>
    </div>
    <automation-section>
      <template v-if="'title' in automationTitle" #title>{{ automationTitle.title }}</template>
      <template v-if="'title' in automationTitle" #subtitle><span v-html="automationTitle.content"></span></template>
      <template v-if="'title' in automationContent" #content>
        <div v-html="automationContent.content"></div>
      </template>
      <template v-if="'title' in automationImage" #image>
        <picture>
          <img :src="automationImage.image" alt="automation__banner"/>
        </picture>
      </template>

    </automation-section>
    <services-section></services-section>
    <contacts-section>


    </contacts-section>
    <feedback-block>


    </feedback-block>
  </section>
</template>

<script setup>
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import AutomationSection from "./AutomationSection.vue";
import ServicesSection from "./ServicesSection.vue";
import ContactsSection from "../mainPage/contacts/ContactsSection.vue";
import FeedbackBlock from "../mainPage/feedback/FeedbackBlock.vue";
import {onMounted, watchEffect} from "vue";
import {useRoute} from "vue-router/dist/vue-router";
import useSWRV from "swrv";
import {getPageBlocks, getPageInfo, setBlockData} from "@/functions/dataload";
import * as urlgen from "@/functions/urlgen";
import {getDataFetcher, getSWRVOptions} from "@/functions/utils";

// components: {TheBreadcrumbs, AutomationSection, ServicesSection, ContactsSection, FeedbackBlock},
//    const pageName = 'contacts-block';
let pageInfo = {};
let pageBlocks = {};
const automationTitle = {};
const automationContent = {};
const automationImage = {};
const servicesTitle = {};

const {data: respPageInfo} = useSWRV(urlgen.urlPageInfo(useRoute().name), getDataFetcher(), getSWRVOptions());
const {data: respPageBlocks} = useSWRV(urlgen.urlPageBlocks(useRoute().name), getDataFetcher(), getSWRVOptions());

watchEffect(() => {
  if (respPageBlocks.value) {
    pageBlocks = respPageBlocks.value.data;
    setBlockData(pageBlocks, automationTitle, 'automation-title');
    setBlockData(pageBlocks, automationContent, 'automation-content');
    setBlockData(pageBlocks, automationImage, 'automation-image');
    setBlockData(pageBlocks, servicesTitle, 'services-title');
  }
});

watchEffect(() => {
  if (respPageInfo.value) {
    pageInfo = respPageInfo.value;
  }
});

onMounted(() => {
  window.scrollTo({
    top: 1,
    behavior: "smooth",
  });
});
</script>


<style scoped>
.about__breadcrumbs {
  padding-top: 41px;
  padding-bottom: 68px;
}

@media (max-width: 767px) {
  .about__breadcrumbs {
    padding-top: 27px;
    padding-bottom: 38px;
  }
}
</style>