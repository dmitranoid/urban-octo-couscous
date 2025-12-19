<template>
    <div class="header">
        <img :src="icon"/>
        <span class="text">{{ text }}</span>
    </div>
</template>

<script>
export default {
    props: { icon: String, text: String }
}
</script>

<style scoped>
.header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

img {
    width: 25px;
    height: auto;
}

.text {
    color: rgb(39, 41, 48);
    font-family: Circe;
    font-size: 15px;
    font-weight: 700;
    line-height: 140%;
    letter-spacing: 0%;
    text-align: left;
    height: 100%;
}
</style>
