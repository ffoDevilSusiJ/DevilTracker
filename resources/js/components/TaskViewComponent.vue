<template>
  <div :style="{ width: show ? '400px' : '0' }" class="task-view" @click="$event.stopPropagation()">
    <div class="task-view__container">
      <div class="task-view__header">
        <div class="task-view__title">{{ task.title }}<div v-if="task.group_id == 2" class="material-icons">done</div>
        </div>
        <div class="task-view__actions">
          <div @click="$emit('edit')" class="task-view__action change material-icons">edit</div>
          <div @click="$emit('delete')" class="task-view__action delete material-icons">delete</div>
        </div>
      </div>
      <div class="task-view__priority">Приоритет: <span :class="getClass(task)">{{ getPriority(task.priority_id) }}</span>
      </div>

      <div class="task-view__item">
        <div class="task-view__item-title">Описание</div>
        <div class="task-view__description">{{ task.description }}</div>
      </div>
      <div class="task-view__item">
        <div class="task-view__item-title">Создатель</div>
        <div class="task-view__creator">{{ task.creator.username }} ( {{ task.creator.email }} )</div>
      </div>
      <div class="task-view__item">
        <div class="task-view__item-title">Исполнитель</div>
        <div class="task-view__executor">{{ task.executor.username }} ( {{ task.executor.email }} )</div>
      </div>
      <div class="task-view__item">
        <div class="task-view__item-title">Создана</div>
        <div class="task-view__created">{{ formatDate(task.created_at) }}</div>

      </div>
      <div v-if="task.deadline_date" class="task-view__item">
        <div class="task-view__item-title">Срок завершения</div>
        <div class="task-view__deadline">{{ formatDate(task.deadline_date) }}</div>
      </div>
      <div v-if="task.completed_at && task.group_id == 2" class="task-view__item">
        <div class="task-view__item-title">Завершена</div>
        <div class="task-view__completed">{{ formatDate(task.completed_at) }}</div>

      </div>

    </div>
  </div>
</template>
  
<script>


export default {
  name: 'TaskViewComponent',
  props: {
    task: Object,
    show: Boolean
  },
  data() {
    let priority = ["Низкий", "Средний", "Высокий"]
    return {
      priority,
    };
  },
  methods: {
    getPriority(id) {
      return this.priority[id - 1];
    },
    getClass(task) {
      return {
        'high-priority-color': task.priority_id == 3,
        'mid-priority-color': task.priority_id == 2,
        'low-priority-color': task.priority_id == 1,
      };
    },
    formatDate(inputDate) {
      const date = new Date(Date.parse(inputDate));
      const formattedDate = date.toLocaleString();

      return formattedDate;
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

.task-view {
  display: block;
  overflow: hidden;
  position: fixed;
  z-index: 1;
  right: 0;
  top: 0;
  transition: .1s;
  height: 100%;
  font-size: 18px;
  background: white;
  border-left: 3px solid #060606bd;


  &__priority {
    margin-bottom: 35px;
  }

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
    flex-direction: column;
  }

  &__actions {
    position: relative;
    top: -6px;
    color: #2b2b2b47;
  }

  &__action {
    cursor: pointer;

    &:hover {
      color: #2b2b2bcc;

      &::before {
        display: block;
      }
    }
  }

  &__description {
    min-height: 70px;
    font-size: 16px;
  }

  &__container {
    padding: 15px;
    width: 100%;
    height: 100%;

  }

  &__item {
    margin-bottom: 35px;
    display: flex;
    flex-direction: column;
    font-size: 16px;
  }

  &__item-title {
    font-size: 18px;
    font-weight: 600;
    border-bottom: 1px solid;
    padding-bottom: 5px;
    margin-bottom: 8px;
  }

  &__title {
    margin-top: 15px;
    margin-bottom: 25px;
    font-size: 24px;
    text-align: center;

    .material-icons {
      color: #51c549;
      font-size: 16px;
      margin-left: 3px;
    }
  }

}</style>