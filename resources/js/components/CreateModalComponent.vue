<template>
  <div id="modal" :class="{ 'modal': true }">
    <div class="modal__content">
      <div class="modal__top">
        <div class="modal__title">Что вы хотите создать</div>
        <span @click="hideModal" class="close">&times;</span>
      </div>
      <div @click="openProjectForm" class="modal__button">Проект</div>
      <div @click="$emit('openTask')" class="modal__button">Задачу</div>

    </div>
  </div>
</template>
  
<script>


export default {
  name: 'CreateModalComponent',
  data() {
    return {
      isModalVisible: false // Начинаем с тем, что модальное окно всегда видно
    };
  },
  methods: {
    hideModal() {
      const modal = document.querySelector('#modal');
      modal.classList.add('hidden');
    },
    openProjectForm() {
      window.location.href = '/create/';
    },
    openTaskForm() {
      window.location.href = '/project/' + this.project.id + '/' + view;
    },
  }
}

document.addEventListener('keydown', function (event) {
  var element = document.querySelector('#modal');
  if (event.key === 'Escape' && element.style.display !== 'none') {
    element.classList.add('hidden')
  }
});
</script>

<style lang="scss">
@import "resources/assets/sass/style.scss";

.hidden {
  display: none !important;
}

.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);

  &__top {
    justify-content: space-between;
    display: flex;
    margin-bottom: 15px;
  }

  &__title {
    font-size: 28px;
  }

  &__content {
    background-color: #fefefe;
    display: flex;
    flex-direction: column;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
  }

  &__button {
    padding: 5px 30px;
    margin-bottom: 5px;
    background-color: $low-contrast-base;
    cursor: pointer;

    &:hover {
      background-color: $low-contrast-hover;
    }
  }
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
}

.modal::before {
  content: "";
  display: block;
  position: fixed;
  z-index: -1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}
</style>