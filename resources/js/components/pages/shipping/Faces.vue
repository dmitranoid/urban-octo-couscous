<template>
<div>
    <img src="@/assets/images/face.png" v-for="i in 5" :style="{ 'z-index': 5-i, 'margin-left': ((i-1)*35)+'px' }">
</div>
</template>

<script>
export default {
    props: { images: Object }
}
</script>

<style scoped>
img {
    border-radius: 25px;
    border: 3px solid #fff;
    position: absolute;
}

div {
    position: relative;
    height: 45px;
}
</style>