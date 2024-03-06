<template>
    <header class="header">
        <div class="header__container">
            <div class="logo" @click="redirectToHome">
                <img src="" alt="" class="logo__image">
                <div class="logo__title">Devil Tracker</div>
            </div>
            <template v-if=isLogin>
                <div class="nav-menu">
                    <div class="nav-menu__item">
                        Проекты
                        <div class="triangle_down1"></div>
                    </div>
                    <div class="nav-menu__item">
                        Задачи
                        <div class="triangle_down1"></div>
                    </div>
                    <div class="nav-menu__item nav-menu__button"  @click="toggleModal">
                        Создать
                    </div>
                </div>
                <div class="user-bar">
                    <div class="user-bar__image">
                        <img :src="this.user.avatar_path" alt="">
                    </div>
                    <div class="user-bar__username">{{ this.user.username }}</div>
                    <div @click="logout" class="user-bar__logout material-icons">logout</div>
                </div>
            </template>
            <create v-if="showCreateModal" @open-project="openProjectModal" @open-task="openTaskModal"></create>
            <task  v-if="showTaskModal" @close="closeTaskModal" :projects="projects"></task>
            <project  v-if="showProjectModal" @close="closeProjectModal"></project>

        </div>
    </header>
</template>

<script>
import task from '@components/modals/TaskModalComponent.vue'
import create  from '@components/modals/CreateModalComponent.vue'
import project from '@components/modals/ProjectModalComponent.vue'
export default {
    name: 'HeaderComponent',
    props: {
        user: Object,
        projects: Array
    },
    components: {
        task,
        project,
        create
    },
    data() {
        let isLogin = false;
        if(this.user) isLogin = true;
        return { isLogin: isLogin, user: this.user, projects: this.projects, showTaskModal: false, showCreateModal: false, isEdit: true};
    },
    methods: {
        logout() {
            window.location.href = '/logout';
        },
        toggleModal() {
            this.showCreateModal = true;
            let modal = document.getElementById('modal')
            if(modal) modal.classList.toggle('hidden')
        },
        openTaskModal() {
            console.log(1);
            this.showCreateModal = false;
            this.showTaskModal = true;
        },
        closeTaskModal() {
            this.showTaskModal = false;
        },
        openProjectModal() {
            this.showCreateModal = false;
            this.showProjectModal = true;
        },
        closeProjectModal() {
            this.showProjectModal = false;
        },
        redirectToHome() {
            window.location.href = '/';
        }
    }
};
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

.logo {
    display: flex;
    align-items: center;
    cursor: pointer;

    &__title {
        font-size: 22px;
    }

    margin-right: 24px;
}

.header {
    position: relative;
    width: 100%;
    height: 40px;
    border: 1px solid #2f2f2f52;
    padding-left: 5px;

    &__container {
        display: flex;
        align-items: center;
        width: 100%;
        height: 100%;
    }
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 20px;

    &__item {
        cursor: pointer;
        height: fit-content;
    }

    &__button {
        padding: 5px 10px;
        background-color: $primary-color;
        color: white;
    }
}

.triangle_down {
    width: 0;
    height: 0;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-top: 15px solid #2f2f2f;
    font-size: 0;
    line-height: 0;
    float: left;
}

.triangle_down1 {
    position: relative;
    top: -3px;
    content: "";
    display: inline-block;
    width: 5px;
    height: 5px;
    border-right: 0.1em solid black;
    border-top: 0.1em solid black;
    transform: rotate(135deg);
    margin-right: 0.1em;
    margin-left: 0.2em;
}

.triangle_up1 {
    position: relative;
    top: -5px;
    content: "";
    display: inline-block;
    width: 15px;
    height: 15px;
    border-right: 0.2em solid black;
    border-top: 0.2em solid black;
    transform: rotate(-45deg);
    margin-right: 0.5em;
    margin-left: 1.0em;
}

.user-bar {
    height: 100%;
    display: flex;
    position: absolute;
    align-items: center;
    right: 0;
    margin-right: 15px;

    &__username {
        height: fit-content;
        align-self: center;
        margin-right: 10px;

    }
    &__logout {
        height: fit-content;
        font-size: 18px;
        cursor: pointer;
        user-select: none;
    }
    &__image {
        margin-right: 10px;
        display: flex;

        img {
            align-self: center;
            height: 80%;
            width: auto;

        }
    }
}
</style>