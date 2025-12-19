<template>
    <div class="service">
        <div class="header">
            <img :src="icon"/><!--:src="icon" -->
            <span class="title">{{ title }}</span>
        </div>
        <span class="text">{{ text }}</span>
    </div>
</template>

<script>
export default {
    props: { icon: String, title: String, text: String }
}
</script>

<style scoped>
.service {
    background: rgb(248, 248, 249);
    padding: 1rem;
}

.service .header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.service img {
    width: 52px;
    height: auto;
    border-radius: 10px;
}

.service .title {
    color: rgb(39, 41, 48);
    font-family: Circe;
    font-size: 15px;
    font-weight: 700;
    line-height: 140%;
    letter-spacing: 0%;
    text-align: left;
    height: 100%;
}

.service .text {
    opacity: 0.7;
    font-size: 13px;
}
</style>
