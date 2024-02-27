<template>
    <header class="header">
        <div class="header__container">
            <div class="logo">
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
                </div>
            </template>
            <create-modal v-if="showCreateModal" @open-task="openTaskModal"></create-modal>
            <add-task :projects="projects" v-if="showTaskModal"></add-task>
        </div>
    </header>
</template>

<script>
export default {
    name: 'HeaderComponent',
    props: {
        user: Object,
        projects: Array
    },
    data() {
        let isLogin = false;
        if(this.user) isLogin = true;
        return { isLogin: isLogin, user: this.user, projects: this.projects, showTaskModal: false, showCreateModal: false};
    },
    methods: {
        toggleModal() {
            this.showCreateModal = true;
            let modal = document.getElementById('modal')
            if(modal) modal.classList.toggle('hidden')
        },
        openTaskModal() {
            this.showCreateModal = false;
            this.showTaskModal = !this.showTaskModal;
        }
    }
};
</script>

<style lang="scss">
@import "resources/assets/sass/style.scss";

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
    right: 0;
    margin-right: 15px;

    &__username {
        height: fit-content;
        align-self: center;
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