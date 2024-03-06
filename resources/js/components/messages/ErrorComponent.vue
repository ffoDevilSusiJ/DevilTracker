<template>
  <div class="alert">
    <ul>
      <li @click="closeAlert" v-for="error in errors" class="alert__danger">{{ error }}</li>
    </ul>
  </div>
</template>
  
<script>

import { ref, watch, onMounted  } from 'vue';
import state from '/resources/js/messages';
export default {
  name: 'ErrorComponent',
  methods: {
    closeAlert(event) {
      event.target.remove();
    }

  },
  setup() {
        const errors = ref(state.errors);
        watch(() => state.errors, (newValue, oldValue) => {
            errors.value = newValue; 
        });
        onMounted(() => {
            setTimeout(() => {
                let errorElements = document.querySelectorAll('.alert li');
                
                const showNextError = (errorElement) => {
                    errorElement.classList.add('fade-out');
                    setTimeout(() => {
                        errorElement.remove();
                    }, 3000);
                };

                errorElements.forEach((error, index) => {
                    setTimeout(() => {
                        showNextError(error);
                    }, index * 8000);
                });
            }, 5000);
        });
        return { errors };
    },
  created() {

   
  },
  mounted() {
    const vm = this;
  }
}
</script>

<style lang="scss">
.alert__danger {
  position: relative;
  bottom: 0;
  left: 0;
  background-color: #ffd3d3;
  width: 100%;
  height: 45px;
  display: flex;
  align-items: center;
  padding-left: 10px;
  border: 1px solid #fcc2c3;
}
</style>