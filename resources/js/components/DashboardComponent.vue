<template>
    <div class="dashboard">
        <div class="dashboard__container">
            <template v-if="!isEmpty">
                <div class="projects">
                    <!-- <div class="projects__title">Список проектов</div> -->
                    <div class="projects__list">
                        <div v-for="project in projects" class="project" @click="redirectToPage(project.id)">
                            <div class="project__info">
                                <div class="project__title">{{ project.title }}</div>
                                <div class="project__description">{{ project.description }}</div>
                                <div class="project__owner">
                                    <div class="user-bar">
                                        <div class="user-bar__image">
                                            <img :src="project.owner.avatar_path" alt="">
                                        </div>
                                        <div class="user-bar__username">{{ project.owner.username }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="project__actions">
                                <div @click="openProjectModal($event, project)" class="project__action change material-icons">edit</div>
                                <div @click="openModal($event, project)" class="project__action delete material-icons">delete
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <modal v-if="showModal" @cancel="closeModal" @success="deleteProject"
                    :title="'Подтвердите удаление проекта'"></modal>
                    <project  v-if="showProjectModal" @close="closeProjectModal" :project="targetProject" :edit="true"></project>
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
import modal from '@components/modals/ConfirmModalComponent.vue';
import project from '@components/modals/ProjectModalComponent.vue'
import state from '/resources/js/messages';
export default {
    name: 'DashboardComponent',
    props: {
        projects: Array,
        actualTasks: Array,
        test: String
    },
    components: {
        modal,
        project
    },
    data() {
        return {
            targetProject: null,
            openModal: false,
            showProjectModal: false
        }
    },
    computed: {
        showModal() {
            return this.openModal;
        }
    },
    created() {
        console.log(this.projects);
        if (this.projects.length > 0) {
            this.isEmpty = false;
        }
    },
    methods: {
        redirectToPage(id) {
            window.location.href = 'project/' + id;
        },
        closeModal() {
            this.openModal = false;
        },
        openModal(e, project) {
            e.stopPropagation();
            this.targetProject = project;
            this.openModal = true;
        },
        closeProjectModal() {
            this.showProjectModal = false;
        },
        openProjectModal(e, project) {
            e.stopPropagation();
            this.targetProject = project;
            this.showProjectModal = true;
        },
        deleteProject() {
            console.log(`/project/${this.targetProject.id}/`);
            axios.delete(`/project/${this.targetProject.id}/`,
                {
                    project_id: this.targetProject.id,
                }, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            })
                .then(response => {
                    var index = this.projects.findIndex((project) => project.id === this.targetProject.id);
                    if (index !== -1) {
                        this.projects.splice(index, 1);
                    }
                    this.closeModal()
                })
                .catch(error => {
                    state.errors.push(error.response.data);
                    this.closeModal()
                });
        }
    }
};
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

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
    padding: 25px;

    &__title {
        font-size: 24px;
        padding-top: 5px;
        border-top: 1px solid rgba(88, 88, 88, 0.322);
        margin-bottom: 25px;

    }

    &__list {
        gap: 15px;
        display: flex;
        flex-direction: column;
    }

    overflow-y: auto;

    &::-webkit-scrollbar {
        width: 6px;
    }

    &::-webkit-scrollbar-track {
        background: white;
    }

    &::-webkit-scrollbar-thumb {
        background-color: $low-contrast-hover;
        margin-left: 5px;
        border-left: 3px solid white;

    }

}

.project {
    cursor: pointer;
    height: 120px;
    width: 100%;
    padding: 5px;
    background-color: $low-contrast-base;
    position: relative;
    border-bottom: 1px solid rgba(88, 88, 88, 0.322);
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

    &:hover {
        background-color: $low-contrast-hover;

        .project__actions {
            opacity: 1;
        }
    }

    .project__actions {
        opacity: 0;
        position: absolute;
        right: 15px;
        top: 15px;
        color: #2b2b2b47;

        .project__action {
            position: relative;
            cursor: pointer;

            &:hover {
                color: #2b2b2bcc;

                &::before {
                    display: block;
                }
            }

            &::before {
                position: absolute;
                top: -25px;
                font-weight: 600;
                display: none;
                font-size: 14px;
                padding: 3px;
                color: white;
                background-color: black;
            }
        }

        .delete::before {
            content: 'Удалить';
        }

        .change::before {
            content: 'Изменить';
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