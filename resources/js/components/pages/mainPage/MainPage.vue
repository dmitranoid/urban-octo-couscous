<template>
  <greeting-section>
    <template v-if="'title' in greeting" #title>
      {{ greeting.title }}
    </template>
    <template v-if="'title' in greeting" #content>
      <span v-html="greeting.content"></span>
    </template>
  </greeting-section>

  <manufacters-section>

    <template v-if="'title' in manufacturersCaption" #title>
      {{ manufacturersCaption.title }}
    </template>

    <template v-if="manufacturersCaption" #subtitle>
      <span v-html="manufacturersCaption.content"></span>
    </template>

    <template v-if="'title' in manufacturersContent" #content>
      <p v-html="manufacturersContent.content"></p>
    </template>

  </manufacters-section>

  <our-values-section>
    <template v-if="'title' in ourValues" #title>
      <span v-if="ourValues">{{ ourValues.title }}</span>
      <!--      Complex supplies and repairs of industrial equipment and electrical accessories.-->
    </template>
  </our-values-section>

  <features-section>
    <template v-if="'title' in featuresTitle" #title>
      {{ featuresTitle.title }}
    </template>
    <template v-if="'title' in featuresRepair" #repair>
      <template>{{ featuresRepair.title }}</template>
      <!--      We are trusted by more than 1000 enterprises-->
      <template>{{ featuresRepair.content }}</template>
    </template>
    <template v-if="'title' in featuresServices" #services>
      <template>{{ featuresServices.title }}</template>
      <!--      We are trusted by more than 1000 enterprises-->
      <template>{{ featuresServices.content }}</template>
    </template>
  </features-section>

  <questions-section></questions-section>
  <feedback-block>
    <template v-if="'title' in feedbackForm" #title>
      {{ feedbackForm.title }}
    </template>
    <template v-if="'title' in feedbackForm" #content>
      {{ feedbackForm.content }}
    </template>
  </feedback-block>
  <contacts-section></contacts-section>
</template>

<script setup>
import GreetingSection from "./greeting/GreetingSection.vue";
import ManufactersSection from "./manufacturers/ManufactersSection.vue";
import OurValuesSection from "./ourValues/ourValuesSection.vue";
import FeaturesSection from "./features/FeaturesSection.vue";
import QuestionsSection from "./questions/QuestionsSection.vue";
import FeedbackBlock from "./feedback/FeedbackBlock.vue";
import ContactsSection from "./contacts/ContactsSection.vue";
import useSWRV from "swrv";
import {axiosFetcher, setBlockData} from "@/functions/dataload";
import LocalStorageCache from "swrv/esm/cache/adapters/localStorage";
import {computed, onMounted, ref, watch, watchEffect} from "vue";
import {urlPageInfo, urlPageBlocks,} from "@/functions/urlgen";
import {getCacheStorage, getDataFetcher, getSWRVOptions} from "@/functions/utils";
import {useRoute} from "vue-router";


const route = useRoute();

const pageName = computed(() => route.name)

const greeting = {};
const manufacturersCaption = {};
const manufacturersContent = {};
const ourValues = {};
const featuresTitle = {};
const featuresRepair = {};
const featuresServices = {};
const feedbackForm = {};

let pageInfo = {};
let pageBlocks = {};

const {data: respPageInfo} = useSWRV(
    urlPageInfo(useRoute().name),
    getDataFetcher(),
    getSWRVOptions()
);
const {data: respPageBlocks} = useSWRV(
    urlPageBlocks(useRoute().name),
    getDataFetcher(),
    getSWRVOptions()
);

watch(respPageInfo, () => {
  if (respPageInfo.value) {
    pageInfo = respPageInfo.value.data;
  }
});


watch(respPageBlocks, () => {
  if (respPageBlocks.value) {
    pageBlocks = respPageBlocks.value.data;
    //console.log('watchEffect - respPageBlocks', pageBlocks);
    if (pageBlocks) {
      setBlockData(pageBlocks, greeting, 'greeting');
      setBlockData(pageBlocks, manufacturersCaption, 'manufacturers-caption');
      setBlockData(pageBlocks, manufacturersContent, 'manufacturers-content');
      setBlockData(pageBlocks, ourValues, 'our-values');
      setBlockData(pageBlocks, featuresTitle, 'features-title');
      setBlockData(pageBlocks, featuresRepair, 'features-repair');
      setBlockData(pageBlocks, featuresServices, 'features-services');
    }
  } else {
    pageBlocks = null;
  }
});

onMounted(() => {
  window.scrollTo({
    top: 1,
    behavior: "smooth",
  });
});

</script>

<style></style>