<template>
  <div class="statistics">
    <div class="statistics__container">
      <div class="statistics__info">
        <div class="statistics__title">Статистика по проекту</div>
        <div class="form-group">
          <div class="form-group__divider">
            <div class="form-group__select-title">Информация о</div>
            <select @change="userChanged" name="executor_id">
              <option selected value="-1">Всем проекте</option>
              <option :selected="user.id == task?.executor" v-for="user in project.users" :value="user.id">{{
              user.username }} ( {{ user.email }} )</option>
            </select>
          </div>
        </div>
      </div>
      <div class="divider">
        <div>
          <div class="statistics__task-chart">
            <pie :tasks="pieTasks" :key="chartKey"></pie>
          </div>
          <bar :key="chartKey" v-for="bar in bars" :title="bar.title" :value="bar.value"></bar>
          <info :key="chartKey" v-for="info in infos" :title="info.title" :value="info.value"></info>

        </div>
        <graph :tasks="graphTasks" :key="chartKey"></graph>
      </div>
    </div>
  </div>
</template>

<script>
import pie from '@components/charts/TaskChartComponent.vue';
import members from '@components/common/MembersListComponent.vue';
import bar from '@components/charts/InfoBarComponent.vue';
import info from '@components/charts/InfoTitleComponent.vue';
import graph from "@components/charts/TaskGraphComponent.vue"
export default {
  name: 'StatisticsComponent',
  props: {
    project: Object,
  },
  components: {
    members,
    bar,
    info,
    graph,
    pie
  },
  data() {
    let groupTasks = this.project.tasks.filter(task => task.group_id == 2);
    let completed = groupTasks ? (groupTasks.length / this.project.tasks.length) * 100 : 0;

    let bars = [
      { title: "Общий прогресс по проекту", value: completed + "%" },
    ];
    let infos = []
    return {
      bars,
      infos,
      pieTasks: this.project.tasks,
      graphTasks: groupTasks,
      chartKey: 0,
    }
  },
  created() {
  },
  methods: {
    userChanged(event) {
      const selectedIndex = event.target.selectedIndex;
      if (selectedIndex === 0) { this.loadDefaults(); return; }
      const user = this.project.users[selectedIndex - 1];
      let userTasks = this.project.tasks.filter(task => task.executor_id == user.id);
      let completeTasks = userTasks.filter(task => task.group_id == 2);
      let expiredTasks = userTasks.filter(task => task.deadline_date ? new Date(task.deadline_date) <= new Date() : false);
      let completed = completeTasks ? (completeTasks.length / userTasks.length) * 100 : 0;
      const totalSpentTime = userTasks.reduce((total, task) => total + task.time_spent, 0);

      this.pieTasks = userTasks;
      this.graphTasks = completeTasks;
      this.chartKey += 1;
      this.bars = [
        { title: "Выполнено задач", value: completed + "%" },
      ]
      this.infos = [
        { title: "Потрачено времени на проект", value: this.formatTime(totalSpentTime) },
        { title: "Просрочено задач", value: expiredTasks.length },
      ]
    },
    loadDefaults() {
      let groupTasks = this.project.tasks.filter(task => task.group_id == 2);
      let completed = groupTasks ? (groupTasks.length / this.project.tasks.length) * 100 : 0;

      this.graphTasks = groupTasks;
      this.pieTasks = this.project.tasks;
      console.log(this.tasks);
      this.bars = [
        { title: "Общий прогресс по проекту", value: completed + "%" },
      ];
      this.infos = [];
      this.chartKey += 1;
    },
    redirectToPage(event) {
      window.location.href = 'project?id=' + event.target.getAttribute('project-id');;
    },
    formatTime(seconds) {
      const days = Math.floor(seconds / (3600 * 24));
      const hours = Math.floor(seconds / 3600);
      const minutes = Math.floor(seconds / 60);
      let result = '';
      if (days > 0) {
        result += `${days} д `;
      }
      if (hours > 0 || days > 0) {
        result += `${hours} ч `;
      }
      result += `${minutes} мин`;

      return result;
    }
  }
};
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

.statistics {
  position: relative;
  height: calc(100vh - 80px);
  width: calc(100vw - 480px);
  padding: 40px;
  display: flex;
  justify-content: center;

  .form-group {
    &__select-title {
      width: 123px;
    }

    select {
      border: 0;
      border-left: 1px solid;
      bottom: 1px;
      position: relative;
      padding-left: 5px;
    }
  }

  .divider {
    display: flex;
    width: 100%;
    flex-direction: row;

    >div {
      width: 50%;

    }

    >canvas {
      margin-left: 90px;
      max-height: 491px;
      max-width: 983px;
    }
  }

  &__container {
    width: 100%;
    height: 100%;
  }

  &__title {
    font-size: 36px;
    margin-bottom: 40px;
  }

  &__task-chart {
    width: 400px;
    height: 400px;
    margin-bottom: 35px;
  }
}
</style>