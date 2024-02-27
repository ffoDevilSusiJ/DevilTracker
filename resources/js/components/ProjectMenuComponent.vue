<template>
  <div class="project-menu">
    <div class="project-menu__container">
      <div class="page-divider">
        <div class="project-menu__info">
          <div class="project-menu__title">{{ project.title }}</div>
          <div class="project-menu__description">{{ project.description }}</div>
          <div class="project-menu__owner">
            <div class="">Владелец проекта: {{ project.owner.username }}</div>
          </div>
          <div class="project-menu__item">
            <div class="">Участники</div>
            <div class="" @click="openMemberModal">Добавить</div>
          </div>
          <members class="project-menu__members" :users="project.users"></members>
        </div>
        <div class="project-menu__statistics">
          <div class="task-pie">
            <div class="task-pie__title">
            </div>
          </div>
        </div>
      </div>
    </div>
    <add_member v-if="addMemberModal" @close="closeMemberModal" :project="project"></add_member>
  </div> 
</template>

<script>
import members from '@components/common/MembersListComponent.vue';
import add_member from '@components/AddMemberComponent.vue';

export default {
  name: 'ProjectMenuComponent',
  props: {
    project: Object
  },

  components: {
    members,
    add_member
  },
  data() {
    return {
      addMemberModal: false
    }
  },
  created() {
    

  },
  methods: {
    openMemberModal() {
      console.log(2);
      this.addMemberModal = true
    },
    closeMemberModal() {
      console.log(3);

      this.addMemberModal = false
    },
  }
};
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

.page-divider {
  display: flex;
  height: 100%;
  > div {
    width: 50%;
    display: flex;
    flex-direction: column;
  }
}

.project-menu {
  position: relative;
  height: calc(100vh - 40px);
  width: 100%;
  padding: 40px;
  &__item {
    display: flex;
    justify-content: space-between;
    width: 620px;
    padding-bottom: 5px;
    border-bottom: 1px solid;
    margin-bottom: 15px;
    >div:first-child {
      font-size: 24px;
    }
    >div:last-child {
      cursor: pointer;
      color: lightgray;
      bottom: -7px;
      position: relative;
      &:hover {
        color: gray;
      }
    }
  }
  &__container {
    width: 100%;
    height: 100%;
  }
  &__title {
    font-size: 36px;

  }
  &__members {
  }
  &__info {
    position: relative;
  }
  &__description {
    color: lightgray;
    margin-top: 15px;
    font-size: 18px;
  }
  &__owner {
    margin-top: 20px;
    margin-bottom: 130px;
  }
  &__statistics {
    position: relative;
   
  }
}
.task-pie {
  margin: auto 0;
  width: 400px;
  height: 400px;
  right: 0;
  &__title {
    font-size: 36px;
    
  }
}
</style>