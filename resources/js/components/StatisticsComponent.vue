<template>
    <div class="dashboard">
        <div  class="dashboard__container">
            <template v-if="!isEmpty" >
                <div class="projects">
                    <!-- <div class="projects__title">Список проектов</div> -->
                    <div class="projects__list">
                        <div v-for="project in projects" class="project" :project-id="project.id" @click="redirectToPage">
                            <div class="project__info">
                                <div class="project__title">{{project.title}}</div>
                                <div class="project__description">{{project.description}}</div>
                                <div class="project__owner">
                                    <div class="user-bar">
                                        <div class="user-bar__image">
                                            <img :src="project.owner.avatar_path" alt="">
                                        </div>
                                        <div class="user-bar__username">{{ project.owner.username }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider">
                    <div class="nearest-task">
                        <div class="nearest-task__title">Ближайшая задача</div>
                        <task></task>
                        <div class="nearest-task__list">
                            <div class="nearest-task__item">Всего нужно сделать: </div>
                            <div class="nearest-task__item">Всего в процессе: </div>
                            <div class="nearest-task__item">Всего просроченных задач: </div>
                        </div>

                    </div>
                    <div class="nearest-task">
                        <div class="nearest-task__title">Ближайшая задача</div>
                        <task></task>
                        <div class="nearest-task__list">
                            <div class="nearest-task__item">Всего нужно сделать: </div>
                            <div class="nearest-task__item">Всего в процессе: </div>
                            <div class="nearest-task__item">Всего просроченных задач: </div>
                        </div>

                    </div>
                </div>
                <div class="notifications">
                    <div class="notifications__container">

                    </div>
                </div>
            </template>

            <div v-else class="empty">
                <div class="empty__info">
                    <div class="empty__title">У вас нет проектов</div>
                    <div class="empty__subtitle">Чтобы создать проект кликните в любов месте рабочего окна</div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'StatisticsComponent',
    props: {
    projects: Array,
    actualTasks: Array,
    test:String
  },
  
  created() {
      console.log(this.projects);
    if (this.projects.length > 0) {
      this.isEmptya = false;
    }
  },
  methods: {
    redirectToPage(event) {
        window.location.href = 'project?id=' + event.target.getAttribute('project-id');;
    }
  }
};
</script>

<style lang="scss">
@import "resources/assets/sass/style.scss";
.divider {
    display: flex;
    flex-direction: column;
    width: 23%;
    justify-content: space-between;
}
.dashboard {
    position: absolute;
    top: 50px;
    left: 0;
    height: calc(100% - 100px);
    width: 100%;
    &__container {
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
        width: 100%;
        height: 80%;
    }
}
.projects {
   
    margin-left: 20px;
    width: 50%;
    background-color: $low-contrast-base;
    padding: 25px;

    &__title {
        font-size: 24px;
        padding-top: 5px;
        border-top: 1px solid rgba(88, 88, 88, 0.322);
        margin-bottom: 25px;
    }
}

.project {
    height: 120px;
    width: 100%;
    background-color: $low-contrast-base;
    position: relative;
    border-bottom: 1px solid rgba(88, 88, 88, 0.322);;
    border-radius: 5px;
    &:hover {
        background-color: $low-contrast-hover;
    }
    &__info {
        padding: 10px;
        display: flex;
        flex-direction: column;
        
    }
    &__title {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    &__description {
        font-size: 14px;
        color: gray;
        margin-bottom: 15px;
    }
    &__owner {
        .user-bar {
            height: fit-content;
            margin-bottom: 10px;
            right: unset;
            bottom: 0;
        }
        img {
            height: 30px;
            width: auto;
        }
    }
}

.nearest-task {
    margin-left: 20px;
    height: 47%;
    width: 100%;
    background-color: $low-contrast-base;
}

.notifications {
    margin-right: 20px;
    margin-left: 20px;
    height: 100%;
    width: 22%;
    background-color: $low-contrast-base;
}
</style>