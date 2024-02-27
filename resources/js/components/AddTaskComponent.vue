<template>
  <div class="task-add">
    <div class="task-add__container">
      <div class="task-add__title">Создание задачи</div>
      <form class="add-project__form" method="POST" :action="route">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="project_id" :value="selectedProject.id">

        <div class="form-group">
          <div class="form-group__divider">
              <div class="form-group__select-title">Проект</div>
            
              <select  @change="updateExecutors" name="project">
                <option  v-for="project in projects" :value=project.id>{{project.title}}</option>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label for="title"><i class="zmdi zmdi-email"></i></label>
          <input required type="text" name="title" id="email" placeholder="Загаловок задачи" />
        </div>
        <div class="form-group">
          <label for="description"><i class="zmdi zmdi-lock"></i></label>
          <textarea name="description" id="discription" placeholder="Описание задачи"></textarea>
        </div>
        <div class="form-group">
          <div class="form-group__divider">
              <div class="form-group__select-title">Исполнитель</div>
            
              <select name="executor_id">
                <option  v-for="user in selectedProject.users" :value="user.id">{{user.username}} ( {{ user.email }} )</option>
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
              <input class="form-group__deadline" type="datetime-local" name="deadline_date"
              placeholder="Почта участника" />
          </div>
        </div>
        
        <div class="form-group form-button">
          <input type="submit" name="signup" id="signup" class="form-submit" value="Создать задачу" />
        </div>
      </form>

    </div>
  </div>
</template>
  
<script>


export default {
  name: 'AddTaskComponent',
  props: {
    projects: Array
  },
  data() {

    console.log(this.projects);
    return {
      projects: this.projects,
      selectedProject: this.projects[0],
      route: window.location.origin + "/task",
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
  },
  methods: {
    updateExecutors(event) {
      const selectedId = event.target.value;
      console.log(selectedId);
      console.log(this.projects.find((p) => p.id === selectedId));
      this.selectedProject = this.projects.find((p) => p.id === selectedId)
    },
  }
}
</script>

<style lang="scss">
.task-add {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);

  &__container {
    padding: 15px;
    width: 550px;
    height: 593px;
    border-radius: 5px;
    margin: 45px auto auto;
    background-color: #fff;
  }
  .form-button {
    margin-top: 62px;
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