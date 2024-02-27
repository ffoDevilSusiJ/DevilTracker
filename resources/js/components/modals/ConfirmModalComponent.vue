<template>
  <div id="modal" :class="{ 'modal': true }">
    <div class="modal__content">
      <div class="modal__top">
        <div class="modal__title">{{ title }}</div>
        <span @click="$emit('cancel')" class="close">&times;</span>
      </div>
      <div @click="$emit('success')" class="modal__button">Подтвердить</div>
      <div @click="$emit('cancel')" class="modal__button">Отмена</div>

    </div>
  </div>
</template>
  
<script>


export default {
  name: 'ConfirmModalComponent',
  props: {
    title: String
  },
  data() {
    return {
      title: this.title
    };
  },
  mounted() {
    const vm = this;

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        vm.$emit('cancel');
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        vm.$emit('success');
      }
    });
  }
}


</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

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
  user-select: none;
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