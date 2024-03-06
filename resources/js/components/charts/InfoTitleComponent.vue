<template>
  <div class="info">
    <div class="info__title">{{ title }}</div>
    <div class="info__value">{{ value }}</div>
  </div>
</template>

<script>


export default {
  name: 'InfoTitleComponent',
  props: {
    title: String,
    value: String
  },
  data() {

  }
}
</script>


<style lang="scss">
@import "resources/assets/sass/vars.scss";

.info {
  width: 385px;
  margin-bottom: 15px;
  &__title {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 2px solid $low-contrast-hover;
  }

  &__value {
    position: relative;
    height: 30px;
    width: 100%;
    font-size: 18px;
  font-weight: 500;
  }
}
</style>