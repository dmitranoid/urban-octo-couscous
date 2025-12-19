<template>
  <div class="block-line"></div>
</template>

<script>
export default {};
</script>

<style>
.block-line {
  position: relative;
  width: 32px;
  height: 9px;
  margin-right: 9px;
}
.block-line::before {
  content: "";
  position: absolute;
  width: 26px;
  height: 3px;
  background-color: #6083c0;
  right: 0;
  top: 0;
}
.block-line::after {
  content: "";
  position: absolute;
  width: 26px;
  height: 3px;
  background-color: #7bcfb7;
  bottom: 0;
  left: 0;
}
@media (max-width: 767px) {
  .block-line {
    width: 23px;
    height: 7px;
  }
  .block-line::before,
  .block-line::after {
    width: 18px;
    height: 2px;
  }
}
</style>
