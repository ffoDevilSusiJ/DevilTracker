<template>
    <div class="statistics">
        <div  class="statistics__container">
          <div class="statistics__info">
            <div class="statistics__title">Статистика по проекту</div>
          </div>
          <bar v-for="bar in bars" :title="bar.title" :value="bar.value"></bar>
          <div class="statistics__task-chart">
              <task-chart :project="project"></task-chart>
          </div>
        </div>
    </div>
</template>

<script>
import members from '@components/common/MembersListComponent.vue';
import bar from '@components/charts/InfoBarComponent.vue';

export default {
    name: 'StatisticsComponent',
    props: {
    project: Object,
  },
  components: {
    members,
    bar
  },
  data() {
    const bars = [
        {title: "Общий прогресс по проекту", value: "30%"},
        {title: "Просрочено задач", value: "10%"},
    ]
    return {
        bars
    }
  },
  created() {
  },
  methods: {
    redirectToPage(event) {
        window.location.href = 'project?id=' + event.target.getAttribute('project-id');;
    }
  }
};
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

.statistics {
    position: relative;
    height: calc(100vh - 40px);
    width: 100%;
    padding: 20px;
    display: flex;
    justify-content: center;

    &__container {
        width: 100%;
        height: 100%;
    }
    &__title {
        font-size: 36px;

    }
    .statistics__task-chart {
        width: 400px;
        height: 400px;
    }
}


</style>