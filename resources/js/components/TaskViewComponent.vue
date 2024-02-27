<template>
  <div class="task-view" @click="$event.stopPropagation()">
    <div class="task-view__container">
      <div class="task-view__item task-view__title">{{task.title}}</div>
      <div class="task-view__item task-view__priority">Приоритет: {{getPriority(task.priority_id)}}</div>
      
      <div class="task-view__item task-view__description">{{task.description}}</div>

      <div class="task-view__item task-view__creator">{{task.creator.username}} ( {{ task.creator.email }} )</div>
      <div class="task-view__item task-view__executor">{{task.executor.username}} ( {{ task.executor.email }} )</div>

      <div class="task-view__item task-view__created">{{new Date(task.created_at)}}</div>
      <div class="task-view__item task-view__deadline">{{new Date(task.deadline_date)}}</div>

      <div class="task-view__item task-view__created">Завершена в {{task.completed_at}}</div>

    </div>
  </div>
</template>
  
<script>


export default {
  name: 'TaskViewComponent',
  props: ['task'],
  data() {
    console.log(this.task);
    let priority = ["Низкий", "Средний","Высокий"]
    return {
      priority,
    };
  },
  methods: {
    getPriority(id) {
      return this.priority[id-1];
    }
  }
}
</script>

<style lang="scss">
.task-view {
  display: block;
  position: fixed;
  z-index: 1;
  right: 0;
  top: 0;
  width: 400px;
  height: 100%;
  font-size: 18px;
  background: white;
  border-left: 3px solid #060606bd;
  &__item {
    margin-bottom: 20px;
  }
  &__container {
    padding: 15px;
    width: 100%;
    height: 100%;
  }

  &__title {
    margin-top: 15px;
    margin-bottom: 25px;
    font-size: 24px;
  }

}
</style>