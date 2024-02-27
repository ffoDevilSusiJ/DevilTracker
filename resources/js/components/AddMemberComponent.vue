<template>
  <div class="member-add">
    <div class="member-add__container">
      <div style="display: flex; justify-content: space-between; align-items:center;">
        <div class="member-add__title">Добавление участников</div>
        <span @click="$emit('close')" class="close">&times;</span>

      </div>
      <form id="form" class="add-project__form" method="POST" :action="route">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="project_id" :value="project.id">

        <div id="member-list" class="form-group">
          <div>Добавить участников (нажать Enter)</div>
          <div class="form-group__divider">
            <input @keydown.enter="addMemberField" class="form-group__member" type="email" name="members[]" id="email"
              placeholder="Почта участника" />
            <select name="roles[]">
              <option value="2">Исполнитель</option>
              <option value="3">Менеджер</option>
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
    project: Object
  },
  data() {

    return {
      route: window.location.origin + "/project/" + this.project.id + "/members/",
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      project: this.project
    };
  },

  methods: {


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