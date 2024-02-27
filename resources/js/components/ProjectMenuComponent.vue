<template>
  <div class="project-menu">
    <div class="project-menu__container">
      <div class="page-divider">
        <div class="project-menu__info">
          <div class="project-menu__title">{{ project.title }}</div>
          <div class="project-menu__description">{{ project.description }}</div>
          <div class="project-menu__owner">
            <div class="">Владелец проекта: {{ project.owner.username }}</div>
          </div>
        </div>
        <div class="project-menu__statistics">
          <div class="task-pie">
            <div class="task-pie__title">

            </div>
            <task-chart v-bind:project="project"></task-chart>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';



export default {
  name: 'ProjectMenuComponent',
  props: {
    project: Object
  },
  data() {

  },
  created() {
    

  },
  methods: {
  }
};
</script>

<style lang="scss">
@import "resources/assets/sass/style.scss";

.page-divider {
  display: flex;
  height: 100%;
  > div {
    width: 50%;
    display: flex;
    flex-direction: column;
  }
}

.project-menu {
  position: relative;
  height: calc(100vh - 40px);
  width: 100%;
  padding: 40px;
  &__container {
    width: 100%;
    height: 100%;
  }
  &__title {
    font-size: 36px;

  }
  &__info {
    position: relative;
  }
  &__description {
    color: lightgray;
    margin-top: 15px;
    font-size: 18px;
  }
  &__owner {
    margin-top: 20px;
  }
  &__statistics {
    position: relative;
   
  }
}
.task-pie {
  margin: auto 0;
  width: 400px;
  height: 400px;
  right: 0;
  &__title {
    font-size: 36px;

  }
}
</style>