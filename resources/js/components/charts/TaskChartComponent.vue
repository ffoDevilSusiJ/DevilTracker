<template>
    <Pie
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
    />
  </template>
  
  <script>
  import { Pie } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, ArcElement, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale)
  
  export default {
    name: 'PieTaskChart',
    components: { Pie },
    props: {
      project: Object
    },
    data() {
    let countByGroup = {0:0, 1:0, 2:0};
    this.project.tasks.forEach(task => {
      const currentGroup = task.group_id;
      if (!countByGroup[currentGroup]) {
        countByGroup[currentGroup] = 0;
      }

      countByGroup[currentGroup]++;
    });
    const data = {
      labels: ['Нужно сделать', 'В процессе', 'Сделано'], // Используем ключи объекта как метки
      datasets: [{
        label: 'Задач',
        data: Object.values(countByGroup), // Используем значения объекта как данные
        backgroundColor: [
          '#7ddfe9',
          '#ffd473',
          '#51c549'
        ],
        hoverOffset: 4
      }]
    };

    return {
      chartData: data,
      chartOptions: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: false,
          }
        }
      }
    };
  }
  }
  </script>