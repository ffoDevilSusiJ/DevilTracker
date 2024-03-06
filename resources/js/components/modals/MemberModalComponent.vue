<template>
  <div class="member-add">
    <div class="member-add__container">
      <div style="display: flex; justify-content: space-between; align-items:center;">
        <div class="member-add__title">{{getTitle()}}</div>
        <span @click="$emit('close')" class="close">&times;</span>

      </div>
      <form id="form" class="add-project__form" method="POST" :action="route">
        <input type="hidden" name="_token" :value="csrf">
        <input v-if="edit" type="hidden" name="_method" value="put" />
        <input type="hidden" name="project_id" :value="project.id">
        <input v-if="edit" type="hidden" name="id" :value="member.id">

        <div v-if="!edit" id="member-list" class="form-group">
          <div>Добавить участников (нажать Enter)</div>
          <div class="form-group__divider">
            <input class="form-group__member" type="email" name="members[]" id="email"
              placeholder="Почта участника" />
            <select name="roles[]">
              <option value="3">Исполнитель</option>
              <option value="2">Менеджер</option>
            </select>
          </div>
        </div>
        <div v-if="edit" class="form-group">
          <div class="form-group__divider">
            <input disabled class="form-group__member" type="email" id="email"
              placeholder="Почта участника" :value="member.username"/>
            <select name="role_id">
              <option :selected="member.role_id == 3" value="3">Исполнитель</option>
              <option :selected="member.role_id == 2" value="2">Менеджер</option>
            </select>
          </div>
        </div>
        <div class="form-group form-button">
          <input type="submit" @keydown.enter.prevent name="signup" id="signup" class="form-submit"
            value="Добавить" />
        </div>
      </form>

    </div>
  </div>
</template>
  
<script>


export default {
  name: 'AddMemberComponent',
  props: {
    project: Object,
    member: Object
  },
  data() {
    console.log(this.member);
    return {
      route: window.location.origin + "/members",
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      project: this.project,
      edit: !!this.member,
    };
  },

  methods: {
    getTitle() {
      return this.edit ? "Редактирование участника" : "Добавление участников"
    },
    getAction() {
      return this.edit ? "Применить" : "Добавить"
    }

  },
  mounted() {
    const vm = this;

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        vm.$emit('close');
      }
    });
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
      }
    });
    document.addEventListener('keydown', function (event) {
      if (document.activeElement.classList.contains('form-group__member')) {
        var element = document.querySelector('#modal');
        if (event.key === 'Enter') {
          let divider = document.getElementsByClassName('form-group__divider')[0].cloneNode(true);
          divider.children[0].value = '';

          divider.children[0].addEventListener('keydown', function (event) {
            if (event.key === 'Backspace' && document.activeElement.value == '') {
              divider.parentNode.removeChild(divider);
              let childs = document.getElementById('member-list').children
              childs[childs.length - 1].children[0].focus();
            }
          });

          document.getElementById('member-list').appendChild(divider);
          divider.children[0].focus();
        }
      }

    });
  }
}
</script>

<style lang="scss">
.member-add {
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

    top: -7px;
    position: relative;
  }

  &__container {
    padding: 15px;
    width: 550px;
    height: fit-content;
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