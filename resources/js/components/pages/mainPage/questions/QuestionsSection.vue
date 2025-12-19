<template>
  <section class="questions">
    <div class="container">
      <div class="questions__wrapper">
        <div :class="['questions__info', { 'questions__info--page': isFaqPage }]">
          <div v-if="isFaqPage" class="questions__info-breadcrumbs">
            <router-link to="/">E-Trade</router-link>
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="none">
              <g clip-path="url(#a)" opacity=".5">
                <path
                    fill="#272930"
                    d="M1.573 1.49a.25.25 0 0 0 0 .353L3.73 3.999 1.573 6.156a.25.25 0 0 0 0 .353l1.084 1.084a.25.25 0 0 0 .353 0l3.417-3.417a.248.248 0 0 0 0-.353L3.01.406a.25.25 0 0 0-.353 0L1.573 1.489Z"
                />
              </g>
              <defs>
                <clipPath id="a">
                  <path fill="#fff" d="M0 8V0h8v8z"/>
                </clipPath>
              </defs>
            </svg>
            <span>FAQ</span>
          </div>
          <h2>Frequently asked questions</h2>
          <div class="questions__image">
            <picture>
              <img src="@/assets/images/questions-scheme.svg" alt="questions-scheme"/>
            </picture>
          </div>
        </div>
        <div class="questions__block">
          <question-card
              v-for="(item, idx) in !isFaqPage ? dataQuestions.filter((item, i) => i < limitForMainPage) : dataQuestions"
              :isFaqPage="isFaqPage"
              :key="item.question"
              :countQustion="dataQuestions.length"
              :numberQuestion="idx"
              :isActiveQuestion="item.isActive"
              :textQuestion="item.question"
              :textAnswer="item.answer"
              :limitForMainPage="limitForMainPage"
          ></question-card>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import QuestionCard from "./QuestionCard.vue";
import {getPageBlocks} from "@/functions/dataload";
import {ref, unref, watch} from "vue";
import useSWRV from "swrv";
import {urlPageBlocks} from "@/functions/urlgen";
import {getDataFetcher, getSWRVOptions} from "@/functions/utils";

const props = defineProps({
  isFaqPage: {
    type: Boolean,
    default: false,
  },
});

const limitForMainPage = 7;
const pageName = 'faq-list';

let dataQuestions = ref([]);
// [{
//   question: "How to make an order on your site?",
//   answer: [
//     "You can place your order through the feedback form, send us your order by e-mail (<a href='mailto:info@etrade-ag.com'>info@etrade-ag.com</a>) or contact us by phone (<a href='tel:+48 786 434 232'>+48 786 434 232</a>)",
//   ],
//   isActive: false,
// }]
const {data: dataQuestionsResp} = useSWRV(urlPageBlocks(pageName), getDataFetcher(), getSWRVOptions());

watch(dataQuestionsResp, () => {
  dataQuestions.value = [];
  if (dataQuestionsResp.value) {
    dataQuestionsResp.value.data.map((item) => {
      dataQuestions.value.push(mapDataQuestion(item));
    })
  } else {
    //
  }
}, {immediate: true, deep: true});

function mapDataQuestion(block) {
  return {
    question: block.name ?? '',
    answer: [block.content ?? ''],
    isActive: false,
  }
}

</script>

<style scoped>
.questions__wrapper {
  padding-bottom: 99px;
  display: grid;
  grid-template-columns: minmax(0, 451px) 1fr;
  column-gap: 20px;
}

.questions__info h2 {
  font-size: 36px;
  line-height: 100%;
  max-width: 300px;
  margin-bottom: 37px;
}

.questions__info--page {
  position: relative;
}

.questions__info-breadcrumbs {
  position: absolute;
  top: 105px;
  left: 0;
  display: flex;
  align-items: center;
  font-size: 16px;
  line-height: 100%;
}

.questions__info-breadcrumbs a {
  color: #272930;
  opacity: 0.5;
}

.questions__info-breadcrumbs svg {
  margin-left: 8px;
  margin-right: 10px;
}

.questions__info--page h2 {
  margin-bottom: 177px;
}

.questions__image {
  width: 254px;
  height: 447px;
}

.questions__image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}

@media (max-width: 1400px) {
  .questions__wrapper {
    grid-template-columns: minmax(0, 300px) 1fr;
  }
}

@media (max-width: 1199px) {
  .questions__info-breadcrumbs {
    top: 90px;
  }

  .questions__wrapper {
    grid-template-columns: 1fr;
    row-gap: 17px;
    padding-bottom: 41px;
  }

  .questions__image {
    display: none;
  }

  .questions__info h2 {
    margin-bottom: 0;
  }

  .questions__info--page h2 {
    margin-bottom: 48px;
  }
}

@media (max-width: 767px) {
  .questions__info-breadcrumbs {
    font-size: 12px;
    left: 18px;
    top: 60px;
  }

  .questions .container {
    padding: 0;
    margin: 0;
  }

  .questions__wrapper {
    width: 100%;
  }

  .questions__info h2 {
    padding-left: 18px;
    font-size: 22px;
    line-height: 100%;
    max-width: 250px;
  }

  .questions__info--page h2 {
    margin-bottom: 38px;
  }
}
</style>