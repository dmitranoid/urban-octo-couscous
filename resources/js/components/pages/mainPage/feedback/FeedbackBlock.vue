<template>
  <section class="feedback">
    <div class="feedback__wrapper">
      <div class="feedback__container">
        <div class="feedback__image">
          <picture>
            <img src="@/assets/images/feedback.jpg" alt="feedback" />
          </picture>
        </div>
        <div class="feedback__block">
          <div class="feedback__content">
            <div class="feedback__content-line feedback__content-line--green">
              <div></div>
            </div>
            <div class="feedback__content-line feedback__content-line--blue">
              <div></div>
            </div>
            <div class="feedback__content-wrapper">
              <div class="feedback__content-info">
                <h2>
                  <slot name="title">
                    We are Open to Strong & Long-term Cooperation
                  </slot>
                </h2>
                <p><slot name="content">After filling out the form, our manager will contact you shortly</slot></p>
                <ul class="feedback__content-list">
                  <li class="feedback__content-item">
                    <div class="feedback__content-image">
                      <picture>
                        <img src="@/assets/images/feedback-svg-1.svg" alt="feedback-svg" />
                      </picture>
                    </div>
                    <span>12-month warranty</span>
                  </li>
                  <li class="feedback__content-item">
                    <div class="feedback__content-image">
                      <picture>
                        <img src="@/assets/images/feedback-svg-2.svg" alt="feedback-svg" />
                      </picture>
                    </div>
                    <span>Global delivery</span>
                  </li>
                  <li class="feedback__content-item">
                    <div class="feedback__content-image">
                      <picture>
                        <img src="@/assets/images/feedback-svg-3.svg" alt="feedback-svg" />
                      </picture>
                    </div>
                    <span>Immediate dispatch</span>
                  </li>
                </ul>
              </div>
              <div class="feedback__content-form">
                <div>
                  <div class="feedback__content-field">
                    <span>Name</span>
                    <input @input="enterText" ref="inputName" v-model="inputName" type="text" placeholder="Name" />
                  </div>
                  <div class="feedback__content-field">
                    <span>Phone</span>
                    <input
                      @input="enterText"
                      v-mask="'+## ### ### ###'"
                      ref="inputPhone"
                      v-model="inputPhone"
                      type="text"
                      placeholder="+48 794 494 350"
                    />
                  </div>
                </div>
                <button @click="handlerButtonFeedback" class="feedback__content-button">
                  <span>Continue</span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none">
                    <path
                      fill="#fff"
                      d="M13.805 7.529 9.138 2.862a.667.667 0 1 0-.943.943l3.529 3.528H2.667a.667.667 0 0 0 0 1.334h9.057l-3.529 3.528a.667.667 0 1 0 .943.943l4.667-4.667a.667.667 0 0 0 0-.942Z"
                    />
                  </svg>
                </button>
                <p class="feedback__content-accept">
                  I accept the General Term and Conditions and confirm that i have read the
                  <a href="">Privacy Policy</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div v-if="isShowSuccessModal" class="modal-success">
    <h3>Request sent successfully!</h3>
    <img src="@/assets/images/ok.svg" alt="ok" />
  </div>
  <div v-if="isShowErrorModal" class="modal-success">
    <h3><span>Oops...</span> something went wrong</h3>
    <img src="@/assets/images/error.svg" alt="error" />
  </div>
</template>

<script>
import axios from "axios";
export default {
  components: {},

  data() {
    return {
      isShowErrorModal: false,
      isShowSuccessModal: false,
      inputName: "",
      inputPhone: "",
    };
  },
  methods: {
    clearFields() {
      this.inputName = "";
      this.inputPhone = "";
    },
    handlerButtonFeedback() {
      if (this.inputName === "") {
        this.$refs.inputName.classList.add("input-wrong");
      }
      if (this.inputPhone === "") {
        this.$refs.inputPhone.classList.add("input-wrong");
      }
      if (this.inputName && this.inputPhone) {
        this.sendFeedback({
          author: this.inputName,
          contact: this.inputPhone,
        });
        this.clearFields();
      }
    },
    enterText(e) {
      e.target.classList.remove("input-wrong");
    },

    async sendFeedback(data) {
      const response = await axios.post("/api/messages/contact", data);
      if (response.status<300) {
        Promise.resolve()
          .then(() => {
            //console.log('message code', response.data.data.code);
            this.isShowSuccessModal = !this.isShowSuccessModal;
          })
          .then(() => {
            setTimeout(() => {
              this.isShowSuccessModal = !this.isShowSuccessModal;
            }, 3000);
          });
      } else {
        Promise.resolve()
          .then(() => {
            this.isShowErrorModal = !this.isShowErrorModal;
          })
          .then(() => {
            setTimeout(() => {
              this.isShowErrorModal = !this.isShowErrorModal;
            }, 3000);
          });
      }
    },
  },
};
</script>

<style scoped>
.modal-success {
  position: fixed;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 400px;
  height: 350px;
  background-color: #fff;
  box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
  z-index: 999999;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.modal-success h3 {
  font-size: 30px;
  line-height: 100%;
  margin-bottom: 25px;
}
.modal-success h3 span {
  display: block;
}
.input-wrong {
  color: #ea4335 !important;
  border-bottom: 2px solid #ea4335 !important;
  transition: 0.5s ease;
}
.feedback__wrapper {
  padding-bottom: 75px;
}
.feedback__container {
  position: relative;
}
.feedback__block {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 1172px;
  height: 459px;
}
.feedback__image {
  position: relative;
  height: 589px;
  overflow: hidden;
}
.feedback__image img {
  width: 100%;
  height: 1107px;
  position: absolute;
  bottom: 0;
  object-fit: cover;
  left: 0;
}
.feedback__content {
  width: 100%;
  height: 100%;
  position: relative;
}
.feedback__content-wrapper {
  width: 100%;
  height: 100%;
  position: relative;
  background-color: #fff;
  z-index: 10;
}
.feedback__content-line--green {
  top: -30px;
  left: 30px;
  width: 655px;
  height: 114px;
}
.feedback__content-line--blue {
  width: 496px;
  height: 459px;
  bottom: -30px;
  right: -30px;
}
.feedback__content-line--blue div::before,
.feedback__content-line--blue div::after {
  background-color: #6083c0;
  bottom: 0;
  right: 0;
}
.feedback__content-line--green div::before,
.feedback__content-line--green div::after {
  background-color: #7bcfb7;
  top: 0;
  left: 0;
}
.feedback__content-line {
  position: absolute;
}
.feedback__content-line div {
  width: 100%;
  height: 100%;
  position: relative;
}
.feedback__content-line div::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 8px;
  z-index: -1;
}
.feedback__content-line div::after {
  content: "";
  position: absolute;
  height: 100%;
  width: 8px;
}
.feedback__content-wrapper {
  display: grid;
  grid-template-columns: 1fr minmax(0, 376px);
  padding: 70px 90px;
}
.feedback__content-info h2 {
  font-size: 36px;
  line-height: 100%;
  margin-bottom: 23px;
  max-width: 480px;
}
.feedback__content-info p {
  font-size: 18px;
  line-height: 140%;
  opacity: 0.6;
  margin-bottom: 39px;
  max-width: 414px;
}
.feedback__content-list {
  display: flex;
  align-items: center;
}
.feedback__content-item {
  padding-left: 41px;
  padding-right: 45px;
  border-right: 2px solid #f4f4f5;
}
.feedback__content-item:first-child {
  padding-right: 28px;
  padding-left: 0;
}
.feedback__content-item:last-child {
  padding-right: 0;
  border-right: none;
}
.feedback__content-item span {
  display: block;
  font-size: 18px;
  line-height: 100%;
  max-width: 79px;
}
.feedback__content-image {
  width: 36px;
  height: 36px;
  margin-bottom: 16px;
}
.feedback__content-image img {
  width: 100%;
  height: 100%;
  object-fit: scale-down;
}
.feedback__content-field {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}
.feedback__content-field:last-child {
  margin-bottom: 35px;
}
.feedback__content-field span {
  display: block;
  font-size: 14px;
  line-height: 21px;
  color: rgba(39, 41, 48, 0.5);
}
.feedback__content-field input {
  font-size: 16px;
  line-height: 24px;
  color: #272930;
  padding-top: 12px;
  padding-bottom: 17px;
  border-bottom: 2px solid rgba(39, 41, 48, 0.1);
  transition: 0.5s ease;
}
.feedback__content-field input:focus {
  border-bottom: 2px solid #6083c0;
  transition: 0.5s ease;
}
.feedback__content-button {
  position: relative;
  width: 100%;
  height: 60px;
  background: #6083c0;
  margin-bottom: 23px;
}
.feedback__content-button:hover {
  background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
  transition: 0.5s ease;
}
.feedback__content-button:active {
  background: linear-gradient(0deg, #496aa4, #496aa4), #6083c0;
}
.feedback__content-button svg {
  position: absolute;
  right: 22px;
  top: 50%;
  transform: translateY(-50%);
}
.feedback__content-button span {
  font-family: "Circe-Bold";
  font-style: normal;
  font-weight: 700;
  font-size: 16px;
  line-height: 100%;
  color: #fff;
}
.feedback__content-accept {
  font-size: 14px;
  line-height: 120%;
  color: rgba(39, 41, 48, 0.4);
}
.feedback__content-accept a {
  color: rgba(39, 41, 48, 0.4);
  text-decoration: underline;
}
.feedback__content-info {
  align-self: center;
}
@media (max-width: 1300px) {
  .feedback__content-wrapper {
    padding: 70px 40px;
  }
  .feedback__block {
    width: 880px;
  }
}
@media (max-width: 990px) {
  .feedback__content-info h2 {
    max-width: 400px;
  }
  .feedback__wrapper {
    padding-bottom: 0;
  }
  .feedback__image {
    height: 400px;
  }
  .feedback__image img {
    height: 811px;
  }
  .feedback__block {
    position: static;
    width: 600px;
    transform: translate(0%, -150px);
    margin: 0 auto;
    box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
    height: unset;
  }
  .feedback__content-wrapper {
    grid-template-columns: 1fr;
    row-gap: 51px;
    padding: 40px 0;
  }
  .feedback__content-info {
    justify-self: center;
  }
  .feedback__content-form {
    max-width: 420px;
    margin: 0 auto;
  }
  .feedback__content-line--green {
    width: 478px;
  }
}
@media (max-width: 767px) {
  .modal-success {
    width: 284px;
    height: 200px;
  }
  .modal-success h3 {
    font-size: 20px;
    line-height: 100%;
    margin-bottom: 25px;
  }
  .feedback__image {
    height: 213px;
  }
  .feedback__image img {
    height: 432px;
  }
  .feedback__block {
    transform: translate(0%, -50px);
  }

  .feedback__content-info h2 {
    font-size: 22px;
    line-height: 100%;
    margin-bottom: 14px;
    max-width: 350px;
  }
  .feedback__content-info p {
    font-size: 14px;
    line-height: 140%;
    margin-bottom: 25px;
  }
  .feedback__content-image {
    width: 32px;
    height: 32px;
    margin-bottom: 8px;
  }
  .feedback__content-item span {
    font-size: 12px;
    line-height: 100%;
    max-width: 50px;
  }
  .feedback__content-wrapper {
    padding-top: 20px;
    padding-bottom: 28px;
    padding-left: 16px;
    padding-right: 16px;
  }
  .feedback__block {
    width: calc(100% - 36px);
  }
  .feedback__content-form {
    width: 252px;
  }
  .feedback__content-item {
    padding-left: 21px;
    padding-right: 21px;
  }
  .feedback__content-item:first-child {
    padding-right: 21px;
  }
  .feedback__content-list {
    width: 252px;
    margin: 0 auto;
  }
  .feedback__content-field span {
    font-size: 12px;
    line-height: 18px;
  }
  .feedback__content-field input {
    font-size: 14px;
    line-height: 21px;
    padding-top: 13px;
    padding-bottom: 16px;
  }
  .feedback__content-field {
    margin-bottom: 22px;
  }
  .feedback__content-field:last-child {
    margin-bottom: 30px;
  }
  .feedback__content-button {
    margin-bottom: 20px;
  }
  .feedback__content-accept {
    font-size: 12px;
    line-height: 120%;
  }
  .feedback__content-line div::before {
    height: 4px;
  }
  .feedback__content-line div::after {
    width: 4px;
  }
  .feedback__content-line--green {
    width: 255px;
    left: 12px;
    top: -16px;
  }
  .feedback__content-line--blue {
    width: 45px;
    height: 262px;
    bottom: -10px;
    right: -11px;
  }
}
@media (max-width: 400px) {
  .feedback__image img {
    width: 678px;
    left: -250px;
  }
}
@media (max-width: 350px) {
  .feedback__image img {
    left: -313px;
  }
}
</style>