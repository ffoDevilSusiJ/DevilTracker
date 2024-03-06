<template>
  <div class="alert">
    <ul>
      <li @click="closeAlert" v-for="success in successes" class="alert__success">{{ success }}</li>
    </ul>
  </div>
</template>
  
<script>

import { ref, watch, onMounted  } from 'vue';
import state from '/resources/js/messages';
export default {
  name: 'AddMemberComponent',
  methods: {
    closeAlert(event) {
      event.target.remove();
    }

  },
  setup() {
        const successes = ref(state.successes);
        watch(() => state.successes, (newValue, oldValue) => {
          successes.value = newValue; 
        });
        onMounted(() => {
            setTimeout(() => {
                let successElements = document.querySelectorAll('.alert li');
                
                const showNextError = (successElements) => {
                  successElements.classList.add('fade-out');
                    setTimeout(() => {
                      successElements.remove();
                    }, 3000);
                };

                successElements.forEach((success, index) => {
                    setTimeout(() => {
                        showNextError(success);
                    }, index * 8000);
                });
            }, 5000);
        });
        return { successes };
    },
  created() {

   
  },
  mounted() {
    const vm = this;
  }
}
</script>

<style lang="scss">
.alert__success {
  position: relative;
  bottom: 0;
  right: 0;
  background-color: #daffd3;
  width: 100%;
  height: 45px;
  display: flex;
  align-items: center;
  padding-left: 10px;
  border: 1px solid #b6ddae;
}
</style>