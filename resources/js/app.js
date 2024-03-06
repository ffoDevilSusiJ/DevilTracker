import './bootstrap';
import './messages'
import state from '/resources/js/messages';
import axios from 'axios'
import VueAxios from 'vue-axios'
import { createApp } from 'vue';
import HeaderComponent from '@components/HeaderComponent.vue';
import SideMenuComponent from '@components/SideMenuComponent.vue';
import DashboardComponent from '@components/DashboardComponent.vue';
import StatisticsComponent from '@components/StatisticsComponent.vue';
import ProjectMenuComponent from '@components/ProjectMenuComponent.vue';
import TaskBoardComponent from '@components/TaskBoardComponent.vue';
import ErrorComponent  from '@components/messages/ErrorComponent.vue'
import SuccessComponent  from '@components/messages/SuccessComponent.vue'

const app = createApp({});
app.component('header-component', HeaderComponent);
app.component('side-menu', SideMenuComponent);
app.component('dashboard', DashboardComponent);
app.component('task-board', TaskBoardComponent);
app.component('statistics', StatisticsComponent);
app.component('project-menu', ProjectMenuComponent);
app.component('error-modal', ErrorComponent);
app.component('success-modal', SuccessComponent);

app.use(VueAxios, axios)
app.mount('#app');

document.addEventListener('DOMContentLoaded', function() {
    var errorMessage = document.getElementById('error');
    if(errorMessage) {
        state.errors.push(errorMessage.innerText);
    }
    var successMessage = document.getElementById('success');
    if(successMessage) {
        state.successes.push(successMessage.innerText);
    }
});