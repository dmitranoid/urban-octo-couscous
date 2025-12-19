<template>
    <div class="count">
        <span>Quantity:</span>
        <div class="count-block">
            <button @click="minusCount" class="count-button"></button>
            <input type="text" v-model="inputValue" disabled/>
            <button @click="plusCount" class="count-button count-button--plus"></button>
            <button class="count-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="6" height="4" fill="none">
                    <path
                        fill="#374061"
                        d="M.946.059a.208.208 0 0 1 .29 0L3 1.784 4.764.059a.208.208 0 0 1 .29 0l.886.866c.08.078.08.205 0 .283L3.145 3.941a.206.206 0 0 1-.29 0L.06 1.208a.197.197 0 0 1 0-.283L.946.06Z"
                        opacity=".3"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            inputValue: this.countProduct,
        }
    },
    emits:["change-product-qty"],
    props:{
        countProduct: {
             type: Number,
             default: 1,
        }
    },
    methods: {
        plusCount() {
            this.inputValue++;
            this.$emit("change-product-qty", this.inputValue);
        },
        minusCount() {
            if (this.inputValue > 1) {
                this.inputValue--;
                this.$emit("change-product-qty", this.inputValue);
            }
        }
    },
};
</script>

<style scoped>
.count-arrow {
    display: none;
}

.count {
    display: flex;
    align-items: center;
}

.count span {
    font-size: 16px;
    line-height: 24px;
    opacity: 0.5;
    margin-right: 16px;
}

.count-block {
    padding: 0 16px;
    width: 110px;
    height: 38px;
    border: 1px solid rgba(39, 41, 48, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.count-block input {
    width: 20px;
    text-align: center;
    padding: 0;
    font-family: "Circe-Bold";
    font-style: normal;
    font-weight: 700;
    font-size: 16px;
    line-height: 24px;
    color: #272930;
}

.count-button {
    position: relative;
    padding: 0;
    width: 10px;
    height: 10px;
}

.count-button::before {
    content: "";
    position: absolute;
    width: 8px;
    height: 2px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(39, 41, 48, 0.3);
}

.count-button--plus::after {
    content: "";
    position: absolute;
    height: 8px;
    width: 2px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(39, 41, 48, 0.3);
}

@media (max-width: 767px) {
    .count-button {
        display: none;
    }

    .count-arrow {
        display: flex;
        width: 15px;
        height: 15px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .count-block {
        padding-left: 10px;
        padding-right: 8px;
        width: 62px;
        height: 28px;
    }

    .count-block input {
        font-size: 12px;
        line-height: 18px;
        width: 15px;
    }
}
</style>