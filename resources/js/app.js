import './bootstrap';
import './common'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { createApp } from 'vue';
import HeaderComponent from '@components/HeaderComponent.vue';
import SideMenuComponent from '@components/SideMenuComponent.vue';
import DashboardComponent from '@components/DashboardComponent.vue';
import StatisticsComponent from '@components/StatisticsComponent.vue';
import ProjectMenuComponent from '@components/ProjectMenuComponent.vue';
import TaskBoardComponent from '@components/TaskBoardComponent.vue';
import TaskChartComponent from '@components/charts/TaskChartComponent.vue';
import CreateModalComponent  from '@components/modals/CreateModalComponent.vue'
import TaskViewComponent  from '@components/TaskViewComponent.vue'


const app = createApp({});
app.component('header-component', HeaderComponent);
app.component('side-menu', SideMenuComponent);
app.component('dashboard', DashboardComponent);
app.component('task-board', TaskBoardComponent);
app.component('statistics', StatisticsComponent);
app.component('project-menu', ProjectMenuComponent);
app.component('task-chart', TaskChartComponent);
app.component('create-modal', CreateModalComponent);
app.component('task-view', TaskViewComponent);

app.use(VueAxios, axios)
app.mount('#app');

