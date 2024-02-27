<template>
      <div class="bar">
        <div class="bar__title">{{title}}</div>
        <div class="bar__max">
          <div class="bar__current"></div>
        </div>
      </div>
  </template>
  
  <script>
  
  
  export default {
    name: 'InfoBarComponent',
    props: {
      title: String,
      value: String
    },
    data() {
    
      
    return {
      title,
      value
    };
  }
  }
  </script>


<style lang="scss">
@import "resources/assets/sass/vars.scss";

.bar {
  width: 320px;
  &__title {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 2px solid $low-contrast-hover;
  }
  &__max {
    position: relative;
    height: 30px;
    width: 100%;
    background-color: $task-hover;
  }

  &__current {
    height: 100%;
    background-color: $task-base;
    width: v-bind("value");
  }
}
</style>