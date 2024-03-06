<template>
  <div class="task-modal">
    <div class="task-modal__container">
      <h2 class="task-modal__title">{{ getTitle() }}</h2>
      <form class="task-modal__form" method="POST" :action="route">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="project_id" :value="selectedProject.id">
        <input v-if="edit" type="hidden" name="_method" value="put" />
        <input v-if="edit" type="hidden" name="id" :value="task.id" />

        <div v-if="!edit" class="form-group">
          <div class="form-group__divider">
            <div class="form-group__select-title">Проект</div>
            <select @change="updateExecutors" name="project">
              <option v-for="project in projects" :value="project.id">{{ project.title }}</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="title"><i class="zmdi zmdi-email"></i></label>
          <input required type="text" name="title" id="title" :value="task?.title" placeholder="Заголовок задачи" />
        </div>

        <div class="form-group">
          <label for="description"><i class="zmdi zmdi-lock"></i></label>
          <textarea name="description" id="description" :value="task?.description" placeholder="Описание задачи"></textarea>
        </div>

        <div class="form-group">
          <div class="form-group__divider">
            <div class="form-group__select-title">Исполнитель</div>
            <select :disabled="current_user.role_id == 3" name="executor_id">
              <option :selected="user.id == task?.executor.id" v-for="user in selectedProject.users" :value="user.id">{{ user.username }} ( {{ user.email }} )</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group__divider">
            <div class="form-group__select-title">Приоритет</div>
            <select name="priority_id">
              <option value="3">Высокий</option>
              <option value="2">Средний</option>
              <option value="1">Низкий</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group__divider">
            <div class="form-group__select-title">Срок выполнения</div>
            <input class="form-group__deadline" :value="task?.deadline_date" type="datetime-local" name="deadline_date" placeholder="Срок выполнения" />
          </div>
        </div>

        <div class="form-group form-button">
          <input type="submit" name="signup" id="signup" class="form-submit" :value="getButtonLabel()" />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskModalComponent',
  props: {
    projects: Array,
    task: Object,
    current_user: Object
  },
  data() {
    return {
      selectedProject: this.task ? this.task.project : this.projects[0],
      route: `${window.location.origin}/task`,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      edit: !!this.task,
    };
  },
  methods: {
    getTitle() {
      return this.edit ? 'Редактирование' : 'Создание';
    },
    getButtonLabel() {
      return this.edit ? 'Применить' : 'Создать';
    },
    updateExecutors(event) {
      const selectedId = event.target.value;
      this.selectedProject = this.projects.find((p) => p.id === selectedId);
    },
  },
  mounted() {
    const vm = this;
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        vm.$emit('close');
      }
    });
  },
};
</script>


<style lang="scss">
.task-modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);

  .close {
    top: -4px;
    position: relative;
  }

  &__container {
    padding: 15px;
    width: 550px;
    height: auto;
    border-radius: 5px;
    margin: 45px auto auto;
    background-color: #fff;
  }

  .form-button {
    margin-top: 39px;
  }

  &__form {
    display: flex;
    flex-direction: column;
  }

  select {
    border: 0;
    border-left: 1px solid;
    bottom: 1px;
    position: relative;
    padding-left: 5px;
  }

  input textarea {
    font-size: 16px;
  }

  textarea {
    border-radius: 0;
  }

  input[type="datetime-local"] {
    width: 150px;
  }

  &__title {
    margin-top: 15px;
    margin-bottom: 25px;
    font-size: 24px;
  }
}
</style>
