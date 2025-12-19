<template>
    <div @click="$emit('toggle-modal')" class="overlay"></div>
    <div class="modal-form">
        <div @click="$emit('toggle-modal')" class="modal-form__close"></div>
        <h3 class="modal-form__title">Get a price on request</h3>
        <p class="modal-form__description">Ask for quote</p>
        <div class="modal-form__wrapper">
            <div class="modal-form__container">
                <label class="modal-form__block">
                    <span>Name<span>*</span></span>
                    <input @input="enterText" v-model="inputName" ref="inputName" type="text"/>
                </label>
                <label class="modal-form__block">
                    <span>Company<span>*</span></span>
                    <input @input="enterText" v-model="inputCompany" ref="inputCompany" type="text"/>
                </label>
                <label class="modal-form__block">
                    <span>Email<span>*</span></span>
                    <input @input="enterMail" v-model="inputMail" ref="inputMail" type="text"/>
                </label>
            </div>
            <div>
                <button @click="handlerButton" class="modal-form__button">
                    <span>Send</span>
                    <img src="@/assets/images/arrow-form.svg" alt="arrow-form"/>
                </button>
                <p class="modal-form__privacy">
                    I accept the General Term and Conditions and confirm that i have read the <a href="">Privacy
                    Policy</a>
                </p>
            </div>
        </div>
    </div>
    <div v-if="isShowSuccessModal" class="modal-success">
        <h3>Request sent successfully!</h3>
        <img src="@/assets/images/ok.svg" alt="ok"/>
    </div>
    <div v-if="isShowErrorModal" class="modal-success">
        <h3><span>Oops...</span> something went wrong</h3>
        <img src="@/assets/images/error.svg" alt="error"/>
    </div>
</template>

<script>
import axios from "axios";

export default {
    emits: {
        "toggle-modal": null,
    },
    props: [
        "productName",
        "productSku",
        "qty",
    ],
    data() {
        return {
            isShowErrorModal: false,
            isShowSuccessModal: false,
            inputName: "",
            inputCompany: "",
            inputMail: "",
        };
    },
    methods: {
        clearFields() {
            this.inputName = "";
            this.inputCompany = "";
            this.inputMail = "";
        },
        enterText(e) {
            e.target.classList.remove("input-wrong");
        },
        enterMail(e) {
            const mailformat = /^\w+([\\.-]?\w+)*@\w+([\\.-]?\w+)*(\.\w{2,5})+$/;
            if (e.target.value.match(mailformat)) {
                e.target.classList.remove("input-wrong");
            } else {
                e.target.classList.add("input-wrong");
            }
        },
        handlerButton() {
            if (this.inputName === "") {
                this.$refs.inputName.classList.add("input-wrong");
            }
            if (this.inputCompany === "") {
                this.$refs.inputCompany.classList.add("input-wrong");
            }
            if (this.inputMail === "") {
                this.$refs.inputMail.classList.add("input-wrong");
            }
            if (this.validateMail && this.inputCompany && this.inputName) {
                this.sendFeedback({
                    name: this.inputName,
                    company: this.inputCompany,
                    email: this.inputMail,
                });
                this.clearFields();
            }
        },
        async sendFeedback(data) {
            // https://api.etrade-ag.com/get_price/

            // console.log('send-feedback ',
            //     data,
            //     this.productName,
            //     this.productSku,
            //     this.qty,);

            const postData = {
                author: data.name,
                contact: data.email,
                message: `Quick price request from ${data.company} \n${this.productSku} (${this.productName}) - ${this.qty} pieces`,
                products: [{
                  sku:this.productSku,
                  qty:this.qty
                }]
            }
            const response = await axios.post("/api/messages/pricerequest", postData);
            if (response.data.data) {
                Promise.resolve()
                    .then(() => {
                        this.isShowSuccessModal = !this.isShowSuccessModal;
                        //console.log(data);
                    })
                    .then(() => {
                        setTimeout(() => {
                            this.isShowSuccessModal = !this.isShowSuccessModal;
                            this.$emit("toggle-modal");
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
                            this.$emit("toggle-modal");
                        }, 3000);
                    });
            }
        },
    },
    computed: {
        validateMail() {
            const mailformat = /^\w+([\\.-]?\w+)*@\w+([\\.-]?\w+)*(\.\w{2,3})+$/;
            if (this.inputMail.match(mailformat)) {
                return this.inputMail;
            } else {
                return "";
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

.overlay {
    position: fixed;
    width: 100vw;
    height: 100vh;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 98;
    background: #272930;
    opacity: 0.2;
}

.modal-form {
    position: fixed;
    z-index: 99;
    width: 567px;
    height: 561px;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    padding: 45px 60px;
    background: #ffffff;
    box-shadow: 8px 8px 34px rgba(16, 25, 57, 0.15);
}

.modal-form__close {
    cursor: pointer;
    position: absolute;
    width: 12px;
    height: 12px;
    top: 21px;
    right: 21px;
}

.modal-form__close::before,
.modal-form__close::after {
    position: absolute;
    content: "";
    width: 100%;
    height: 3px;
    background-color: rgba(39, 41, 48, 0.5);
    top: 50%;
    left: 50%;
}

.modal-form__close::before {
    transform: translate(-50%, -50%) rotate(45deg);
}

.modal-form__close::after {
    transform: translate(-50%, -50%) rotate(-45deg);
}

.modal-form__title {
    font-size: 28px;
    line-height: 100%;
    margin-bottom: 7px;
}

.modal-form__description {
    font-size: 18px;
    line-height: 110%;
    color: rgba(39, 41, 48, 0.6);
    margin-bottom: 27px;
}

.modal-form__container {
    display: flex;
    flex-direction: column;
}

.modal-form__block {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.modal-form__block:last-of-type {
    margin-bottom: 41px;
}

.modal-form__block span {
    font-size: 14px;
    line-height: 21px;
    color: rgba(39, 41, 48, 0.5);
}

.modal-form__block input {
    font-size: 16px;
    line-height: 24px;
    padding-top: 6px;
    padding-bottom: 13px;
    border-bottom: 2px solid rgba(39, 41, 48, 0.1);
    transition: 0.5s ease;
}

.modal-form__block input:focus {
    border-bottom: 2px solid #6083c0;
    transition: 0.5s ease;
}

.modal-form__block span span {
    color: rgba(234, 67, 53, 1);
}

.modal-form__button {
    width: 100%;
    position: relative;
    height: 60px;
    background: #6083c0;
    margin-bottom: 27px;
}

.modal-form__button:hover {
    background: linear-gradient(0deg, #83a3dc, #83a3dc), #6083c0;
}

.modal-form__button:active {
    background: #496aa4;
}

.modal-form__button img {
    position: absolute;
    right: 22px;
    top: 50%;
    transform: translateY(-50%);
}

.modal-form__button span {
    font-family: "Circe-Bold";
    font-style: normal;
    font-weight: 700;
    font-size: 16px;
    line-height: 100%;
    color: #fff;
}

.modal-form__privacy {
    font-size: 14px;
    line-height: 120%;
    color: rgba(39, 41, 48, 0.4);
    max-width: 376px;
}

.modal-form__privacy a {
    text-decoration: underline;
    color: rgba(39, 41, 48, 0.4);
}

@media (max-width: 600px) {
    .modal-success {
        width: 284px;
        height: 200px;
    }

    .modal-success h3 {
        font-size: 20px;
        line-height: 100%;
        margin-bottom: 25px;
    }

    .modal-form {
        position: fixed;
        z-index: 999;
        width: 100vw;
        height: 100vh;
        left: 0;
        top: 0;
        bottom: 0;
        transform: translate(0, 0);
        padding: 24px 18px;
        background: #ffffff;
        box-shadow: none;
    }

    .modal-form__wrapper {
        height: 85%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .modal-form__title {
        font-size: 20px;
        line-height: 100%;
        margin-bottom: 7px;
    }

    .modal-form__description {
        font-size: 14px;
        line-height: 110%;
        margin-bottom: 36px;
    }

    .modal-form__block span {
        font-size: 12px;
        line-height: 18px;
    }

    .modal-form__block input {
        padding-top: 10px;
        padding-bottom: 14px;
        font-size: 14px;
        line-height: 21px;
    }

    .modal-form__button {
        height: 52px;
        margin-bottom: 18px;
    }

    .modal-form__button span {
        font-size: 14px;
        line-height: 100%;
    }

    .modal-form__privacy {
        font-size: 12px;
        line-height: 120%;
    }
}
</style>