<template>
  <div class="board" @click="handleSelectTask(null)">
    <div class="board__container">
      <div class="task-group" v-for="groupId in 3" :key="groupId">
        <div class="task-group__title">{{ groupTitle(groupId) }}</div>
        <div class="task-group__list drop-zone" @drop="onDrop($event, groupId)" @dragenter.prevent @dragover.prevent>
          <div class="task expand drag-el" @click="openTask($event, task)" draggable="true" @dragstart="startDrag($event, task)"
            v-for="task in getList(groupId)" :key="task.id" :class="getClass(task)" @dragenter.prevent @dragover.prevent>
            <div class="task__title">
              <div class="material-icons">task</div>{{ task.title }} <div class="expand-icon material-icons">expand_more
              </div>
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
      </div>
    </div>
    <task-view v-if="selectedTask" :task="selectedTask"></task-view>

  </div>
</template>

<script>
import { onMounted } from 'vue';
import { computed } from "vue";
import draggable from "vuedraggable";
// Компонент TaskBoardComponent
export default {
  name: 'TaskBoardComponent',
  props: {
    tasks: Array
  },
  components: {
    draggable,
  },
  data() {
    return {
      selectedTask: null
    }

  },
  setup(props) {
    const tasks = computed(() => props.tasks.sort((a, b) => b.priority_id - a.priority_id));

    const initialGroupNames = ['Нужно сделать', 'В процессе', 'Сделано'];


    const getList = (group_id) => {

      return tasks.value.filter((task) => task.group_id == group_id - 1)
    }
    function groupTitle(groupId) {
      return `${initialGroupNames[groupId - 1]}`;
    }

    return {
      tasks,
      getList,
      groupTitle
    };
  },
  methods: {
    openTask(event, task) {
      event.stopPropagation();
      this.selectedTask = task;
    },
    getClass(task) {
      return {
        'high-priority': task.priority_id == 3,
        'mid-priority': task.priority_id == 2,
        'low-priority': task.priority_id == 1,

        'todo-status': task.group_id == 0,
        'inprogres-status': task.group_id == 1,
        'complete-status': task.group_id == 2,
      };
    },
    startDrag(evt, task) {
      evt.dataTransfer.dropEffect = 'move'
      evt.dataTransfer.effectAllowed = 'move'
      evt.dataTransfer.setData('taskID', task.id)
    },
    onDrop(evt, groupId) {
      const itemID = evt.dataTransfer.getData('taskID')
      const task = this.tasks.find((task) => task.id == itemID)

      if (task.group_id != groupId - 1) {
        task.group_id = groupId - 1;
        axios.post(`/task/${itemID}/status`,
          {
            group_id: task.group_id,
          }, {
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        })
          .then(response => {
            console.log(response.data);
            this.$forceUpdate()
          })
          .catch(error => {
            console.log(error);
          })
      }
    },
    handleSelectTask(task) {
      this.selectedTask = task;
    }
  },

  mounted() {
    const taskElements = document.querySelectorAll('.task');
    const expandIcons = document.querySelectorAll('.expand-icon');
    expandIcons.forEach(icon => {
      icon.addEventListener('click', (e) => {
        e.target.textContent = (e.target.textContent.trim() == "expand_more") ? "expand_less" : "expand_more";

        const task = icon.closest('.task');
        task.classList.toggle('expand');
      });
    });
    document.addEventListener('click', function (e) {
    })
  }
}


</script>

<style lang="scss">
@import "resources/assets/sass/style.scss";

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
        width: 4px;
        /* ширина scrollbar */
      }

      &::-webkit-scrollbar-track {
        background: $low-contrast-base;
        /* цвет дорожки */
      }

      &::-webkit-scrollbar-thumb {
        background-color: $low-contrast-hover;
      }
    }


  }

  .task {
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
    }
  }

  .high-priority {
    border-left: 6px solid rgb(194, 0, 0);
  }

  .mid-priority {
    border-left: 6px solid #ff7c00;
  }

  .low-priority {
    border-left: 6px solid rgb(124, 124, 124);
  }


  .inprogres-status {
    .complete-status {
      .material-icons {
        color: #51c549;
      }
    }
  }

  .complete-status {
    .task__title {
      text-decoration: line-through;
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