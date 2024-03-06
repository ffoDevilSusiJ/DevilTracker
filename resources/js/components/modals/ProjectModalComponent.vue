<template>
  <div class="project-modal">
    <div class="project-modal__container">
      <h2 class="project-modal__title">{{ getTitle() }}</h2>
      <form class="project-modal__form" method="POST" :action="route">
        <input type="hidden" name="_token" :value="csrf">
        <input v-if="edit" type="hidden" name="_method" value="put" />
        <input v-if="edit" type="hidden" name="id" :value="project.id" />
        <div class="form-group">
          <label for="title"><i class="zmdi zmdi-email"></i></label>
          <input required type="text" name="title" id="email" :value="project ? project.title : ''"
            placeholder="Название проекта" />
        </div>
        <div class="form-group">
          <label for="description"><i class="zmdi zmdi-lock"></i></label>
          <textarea required name="description" id="discription" :value="project ? project.description : ''"
            placeholder="Описание проекта"></textarea>
        </div>
        <div v-if="!edit" id="member-list" class="form-group">
          <div>Добавить участников (нажать Enter)</div>
          <div class="form-group__divider" v-for="(member, index) in members" :key="index">
            <input @keydown.backspace="removeMemberField($event, index)" @keydown.enter.prevent="addMemberField"
              v-model="member.email" class="form-group__member" type="email" name="members[]"
              placeholder="Почта участника" />
            <select v-model="member.role" name="roles[]">
              <option value="3">Исполнитель</option>
              <option value="2">Менеджер</option>
            </select>
          </div>
        </div>
        <div class="form-group form-button">
          <input type="submit" @keydown.enter.prevent name="signup" id="signup" class="form-submit"
            :value="getButtonLabel()" />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProjectModalComponent',
  props: {
    project: Object,
    edit: Boolean,
  },
  data() {
    return {
      route: window.location.origin + "/project",
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      members: this.initializeMembers(),
    };
  },
  methods: {
    selectLastField() {
      setTimeout(() => {
        let f = document.querySelectorAll(".form-group__member");
        f[f.length - 1].focus();
      }, 50)
    },
    getTitle() {
      return this.edit ? 'Редактирование' : 'Создание';
    },
    getButtonLabel() {
      return this.edit ? 'Применить' : 'Создать проект';
    },
    initializeMembers() {
      if (this.project) {
        return this.project.users.map(member => ({ email: member.email, role: member.role }));
      } else {
        return [{ email: '', role: '2' }];
      }
    },
    addMemberField() {
      this.members.push({ email: '', role: '2' });
      this.selectLastField();
    },
    removeMemberField(event, index) {
      if (event.target.value == "" && this.members.length > 1) {
        this.members.splice(index, 1);
        event.preventDefault();
        this.selectLastField();
      }
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
.project-modal {
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