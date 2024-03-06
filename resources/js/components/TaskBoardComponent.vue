<template>
  <div class="board" @click="hideTaskView">
    <div class="board__container">
      <div class="task-group" v-for="groupId in 3" :key="groupId">
        <div class="task-group__title">{{ groupTitle(groupId) }}</div>
        <div class="task-group__list drop-zone" @drop="onDrop($event, groupId)" @dragenter.prevent @dragover.prevent>
          <div class="task expand drag-el" @click="openTask($event, task)" draggable="true"
            @dragstart="startDrag($event, task)" v-for="task in getList(groupId)" :key="task.id" :class="getClass(task)"
            @dragenter.prevent @dragover.prevent>
            <div class="task__title">
              <div class="material-icons">task</div>
              <span>
                {{ task.title }}
              </span>
              <div @click="toggleExpandTask" class="expand-icon material-icons">expand_more</div>
            </div>
            <div>
              <div class="task__executor">
                <div class="material-icons">person</div>{{ task.executor.username }}
              </div>
              <div v-if="task.deadline_date" class="task__deadline">
                <div class="material-icons">schedule</div>{{new Date(task.deadline_date).toLocaleString()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <viewer v-if="selectedTask" :show="showTaskView" :task="selectedTask" @edit="openTaskEditModal"
      @delete="deleteTask(selectedTask.id)"></viewer>
    <task v-if="showTaskModal" :current_user="user" :task="selectedTask" @close="closeTaskEditModal" @edit="true"></task>
  </div>
</template>

<script>
import viewer  from '@components/TaskViewComponent.vue'
import draggable from "vuedraggable";
import state from '/resources/js/messages';
import task from '@components/modals/TaskModalComponent.vue';

export default {
  name: 'TaskBoardComponent',
  props: {
    tasks: Array,
    project: Object,
    user: Object
  },
  components: {
    draggable,
    viewer,
    task
  },
  data() {
    let projectUser = this.project.users.find(pUser => pUser.id == this.user.id)
    console.log(projectUser);
    return {
      selectedTask: null,
      showTaskModal: false,
      showTaskView: false,
      user: projectUser
    };
  },
  computed: {
    tasksSorted() {
      return this.tasks.sort((a, b) => b.priority_id - a.priority_id);
    },
    initialGroupNames() {
      return ['Нужно сделать', 'В процессе', 'Сделано'];
    }
  },
  methods: {
    getList(group_id) {
      return this.tasksSorted.filter((task) => task.group_id === group_id - 1);
    },
    groupTitle(groupId) {
      return `${this.initialGroupNames[groupId - 1]}`;
    },
    openTask(event, task) {
      event.stopPropagation();
      task['project'] = this.project;
      this.selectedTask = task;
      setTimeout(() => {
        this.showTaskView = true;
      }, 100);
    },
    getClass(task) {
      let isDeadline = task.deadline_date ? new Date(task.deadline_date) <= new Date() : false;
      return {
        'high-priority-border': task.priority_id === 3,
        'mid-priority-border': task.priority_id === 2,
        'low-priority-border': task.priority_id === 1,
        'todo-status': task.group_id === 0,
        'inprogres-status': task.group_id === 1,
        'complete-status': task.group_id === 2,
        'deadline': isDeadline
      };
    },
    startDrag(evt, task) {
      evt.dataTransfer.dropEffect = 'move';
      evt.dataTransfer.effectAllowed = 'move';
      evt.dataTransfer.setData('taskID', task.id);
    },
    onDrop(evt, groupId) {
      const itemID = evt.dataTransfer.getData('taskID');
      groupId -= 1;
      const task = this.tasks.find((task) => task.id == itemID);

      if (task.group_id !== groupId) {
        let body = {};
        if (groupId === 2)
          body = {
            group_id: groupId,
            completed_at: new Date().toISOString(),
          }
        else
          body = {
            group_id: groupId,
          }
        axios.post(`/task/${itemID}/status`, body, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
          .then(response => {
            task.group_id = groupId;
            task.completed_at = new Date().toISOString();
            this.$forceUpdate();
          })
          .catch(error => {
            state.errors.push(error.response.data);
          })
      }
    },
    hideTaskView() {
      this.showTaskView = false;
    },
    openTaskEditModal() {
      this.showTaskModal = true;
    },
    closeTaskEditModal() {
      this.showTaskModal = false;
    },
    deleteTask(itemID) {
      axios.delete(`/task/${itemID}/`, { id: itemID }, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
        .then(response => {
          var index = this.tasks.findIndex((task) => task.id === itemID);
          if (index !== -1) {
            this.tasks.splice(index, 1);
            this.showTaskView = false;
            state.successes.push(response.data);

            this.$forceUpdate();
          }
        })
        .catch(error => {
          state.errors.push(error.response.data);
          console.log(error);
        })
    },
    toggleExpandTask(e) {
      e.stopPropagation();
      let icon = e.target;
      icon.textContent = (icon.textContent.trim() == "expand_more") ? "expand_less" : "expand_more";
      icon.closest('.task').classList.toggle('expand');
    },
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    const task_id = urlParams.get('task');
    this.selectedTask = this.tasksSorted.find(task => task.id == task_id);
    console.log(this.selectedTask);
    setTimeout(() => {
      this.showTaskView = true;
    }, 100);
  }
};
</script>

<style lang="scss">
@import "resources/assets/sass/vars.scss";

.board {
  position: relative;
  height: calc(100vh - 40px);
  width: 100%;
  padding: 20px;
  display: flex;
  justify-content: center;

  &__container {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    height: 100%;
    width: 100%;
    max-width: 1300px;
  }

  .task-group {
    height: 80%;
    width: 25%;

    &__title {
      font-size: 26px;
      padding-bottom: 5px;
      border-bottom: 6px solid $low-contrast-base;
      margin-bottom: 12px;
    }

    &__list {
      overflow-y: auto;
      height: 100%;

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


  }

  .task {
    position: relative;
    display: flex;
    cursor: pointer;
    user-select: none;
    flex-direction: column;
    justify-content: space-between;
    height: 120px;
    transition: .3s;
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    background-color: $low-contrast-base;

    &:hover {
      background-color: $low-contrast-hover;

      .expand-icon {
        opacity: 1;
      }
    }

    &__title {
      display: flex;

      span {
        white-space: nowrap;
        overflow: clip;
        text-overflow: ellipsis;
        max-width: 85%;
        position: relative;
        top: 5px;
      }
    }

    &__executor {
      font-size: 14px;
    }

    &__deadline {
      font-size: 14px;
    }

    .material-icons {
      font-size: 18px;
      color: #898989a1;
      top: 3px;
      position: relative;
      margin-right: 3px;
    }

    .expand-icon {
      float: right;
      opacity: 0;
      position: absolute;
      right: 15px;
      margin: auto;
      top: 15px;
    }
  }
  .deadline {
    background-color: #ffdada;
  }

  .inprogres-status {
    .complete-status {
      .material-icons {
        span {
          color: #51c549;
        }
      }
    }
  }
  .complete-status {
    .task__title {
      span {
        text-decoration: line-through;
      }
    }

    .material-icons {
      color: #51c549;
    }
  }
}

.expand {
  height: 45px !important;
  overflow: hidden;

  >div:last-child {
    opacity: 0;

  }
}
</style>



<!-- <div class="task-group">
  <div class="task-group__title">{{ groupTitle(0) }}</div>
  <div class="task-group__list drop-zone">
    <div class="task drag-el" @dragstart="startDrag($event, task)" v-for="task in getList(0)" :key="task.group_id" :class="getProprity(task)">
      <div class="task__title">
        <div class="material-icons">task</div>{{ task.title }}
      </div>
      <div>
        <div class="task__executor">
          <div class="material-icons">person</div>{{ task.executor.username }}
        </div>
        <div v-if="task.deadline_date" class="task__deadline">
          <div class="material-icons">schedule</div>{{ task.deadline_date }}
        </div>
      </div>
    </div>
  </div>
</div> -->