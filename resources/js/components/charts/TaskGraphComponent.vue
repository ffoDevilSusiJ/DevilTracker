<template>
  <Line id="graph" :options="chartOptions" :data="chartData" />
</template>

<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, PointElement, LineElement, Tooltip, Legend, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, PointElement, LineElement, LinearScale)

export default {
  name: 'TaskGraphComponent',
  components: { Line },
  props: {
    tasks: Array
  },
  data() {
    this.tasks.sort((task1, task2) => new Date(task1.completed_at) - new Date(task2.completed_at));
    const updatedTasks = this.tasks.map(task => {
      return {
        ...task,
        completed_at: new Date(task.completed_at).toLocaleString(),
        time_spent: Math.floor(task.time_spent / 60)
      };
    });
    const data = {
      datasets: [
        {
          label: 'Выполненные задачи',
          data: updatedTasks,
          borderColor: "rgb(239,68,68)",
          backgroundColor: "rgba(239,68,68, 0.5)",
          pointStyle: 'circle',
          pointRadius: 10,
          pointHoverRadius: 15
        }
      ]
    };
    return {
      chartData: data,
      chartOptions: {
        responsive: true,
        onClick: this.handleClick,
        parsing: {
          xAxisKey: 'completed_at',
          yAxisKey: 'time_spent'
        },
        plugins: {
          title: {
            display: false,
          },
          tooltip: {
            displayColors: false,
            callbacks: {
              title: function (context) {
                return context[0].raw.title;
              },
              label: function (context) {
                const value = context.parsed.y;
                return `Потрачено времени: ${value}мин.`;
              },
            },
          },
        },
        elements: {
          point: {
            radiusOffset: 2
          }
        },
        scales: {
          y: {
            title: {
              display: true,
              text: 'Время выполнения'
            },
            offset: true
          },
          x: {
            title: {
              display: true,
              text: 'Дата завершения'
            },
            offset: true
          }
        }
      }
    };
  },
  methods: {
    handleClick(evt, i) {
      let task = i[0].element.$context.raw;
      window.location.href = `/project/${task.project_id}/board?task=${task.id}`
    }
  }
}
</script>