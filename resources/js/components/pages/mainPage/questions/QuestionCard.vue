<template>
  <div
    :class="[
      'card',
      { 'card-last': numberQuestion === countQustion - 1 || (!isFaqPage && numberQuestion === limitForMainPage - 1) },
      { 'card--active': isVisibleAnswer },
    ]"
  >
    <div @click="isVisibleAnswer = !isVisibleAnswer" class="card__question">
      <div class="card__number">
        <span class="card__number-span"><span v-if="numberQuestion < 9">0</span>{{ numberQuestion + 1 }}</span>
      </div>
      <div class="card__question-text">
        <h3>{{ textQuestion }}</h3>
      </div>
      <div :class="['card__arrow', { 'card__arrow--active': isVisibleAnswer }]">
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="7" fill="none">
          <path
            fill="#272930"
            d="M7.72.092a.312.312 0 0 0-.44 0L4.582 2.787 1.888.092a.312.312 0 0 0-.442 0L.092 1.446a.312.312 0 0 0 0 .442l4.27 4.27a.31.31 0 0 0 .442 0l4.271-4.27a.312.312 0 0 0 0-.442L7.721.092Z"
          />
        </svg>
      </div>
    </div>
    <div v-if="isVisibleAnswer" class="card__answer">
      <div class="card__answer-left"></div>
      <div class="card__answer-center">
        <template v-for="item in textAnswer" :key="item">
          <p v-html="item"></p>
        </template>
      </div>
      <div class="card__answer-right"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    limitForMainPage: Number,
    isFaqPage: Boolean,
    countQustion: Number,
    numberQuestion: Number,
    isActiveQuestion: Boolean,
    textQuestion: String,
    textAnswer: Array,
  },
  data() {
    return {
      isVisibleAnswer: this.isActiveQuestion,
    };
  },
};
</script>

<style scoped>
.card {
  cursor: pointer;
}

.card__number-span {
  font-size: 14px;
  line-height: 100%;
  opacity: 0.5;
}
.card__question-text h3 {
  font-size: 22px;
  line-height: 100%;
}
.card__question {
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr minmax(0, max-content);
  height: 80px;
}

.card__number,
.card__arrow {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 80px;
}
.card__arrow::before,
.card__number::before {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  width: 100%;
  height: 2px;
  background: rgb(245, 245, 255);
}

.card__arrow::before {
  background: linear-gradient(-90deg, rgba(245, 245, 255, 0) 0%, rgba(244, 244, 245, 1) 100%);
}
.card__number::before {
  background: linear-gradient(90deg, rgba(245, 245, 255, 0) 0%, rgba(244, 244, 245, 1) 100%);
}
.card-last.card--active .card-last .card__arrow::after,
.card-last.card--active .card-last .card__number::after {
  background: transparent;
}
.card-last .card__arrow::after,
.card-last .card__number::after {
  content: "";
  position: absolute;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 2px;
  background: rgb(245, 245, 255);
}
.card-last.card--active.card-last .card__arrow::after,
.card-last.card--active.card--active .card__arrow::after {
  background: transparent;
}
.card-last.card--active.card-last .card__number::after,
.card-last.card--active.card--active .card__number::after {
  background: transparent;
}
.card-last .card__arrow::after,
.card--active .card__arrow::after {
  background: linear-gradient(-90deg, rgba(245, 245, 255, 0) 0%, rgba(244, 244, 245, 1) 100%);
}
.card-last .card__number::after,
.card--active .card__number::after {
  background: linear-gradient(90deg, rgba(245, 245, 255, 0) 0%, rgba(244, 244, 245, 1) 100%);
}

.card__question-text {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-left: 47px;
  padding-right: 47px;
  border-top: 2px solid #f4f4f5;
  border-left: 1px solid #f4f4f5;
  border-right: 1px solid #f4f4f5;
}
.card-last.card--active .card__question-text {
  border-bottom: 2px solid transparent;
}
.card-last .card__question-text {
  border-bottom: 2px solid #f4f4f5;
}
.card-last .card__answer {
  border-bottom: 2px solid #f4f4f5;
}
.card__answer {
  display: grid;
  grid-template-columns: minmax(0, max-content) 1fr minmax(0, max-content);
}
.card__answer-left,
.card__answer-right {
  width: 80px;
  height: 80px;
}
.card__answer-center {
  padding: 0 37px 30px 47px;
  border-left: 1px solid #f4f4f5;
  border-right: 1px solid #f4f4f5;
}
.card__answer-center p {
  font-size: 16px;
  line-height: 120%;
  opacity: 0.6;
}
.card__arrow svg {
  position: relative;
  transition: 0.5s ease;
  transform: rotate(0);
}
.card__arrow--active svg {
  transform: rotate(-180deg);
  transition: 0.5s ease;
}
@media (max-width: 767px) {
  .card__answer-center {
    padding-left: 24px;
    padding-right: 24px;
  }
  .card__answer-left,
  .card__answer-right {
    width: 44px;
    height: 52px;
  }
  .card__answer p {
    font-size: 14px;
    line-height: 100%;
  }
  .card__question {
    height: 52px;
  }
  .card__number,
  .card__arrow {
    width: 44px;
  }
  .card__question-text h3 {
    font-size: 14px;
    line-height: 100%;
  }
  .card__question-text {
    padding-left: 24px;
    padding-right: 42px;
  }
  .card__arrow svg {
    transform: scale(0.78);
  }
  .card__arrow--active svg {
    transform: rotate(-180deg) scale(0.78);
  }
}
</style>