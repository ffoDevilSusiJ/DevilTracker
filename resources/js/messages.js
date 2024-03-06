import { reactive, watchEffect } from 'vue';

const state = reactive({
    errors: [],
    successes: []
});

export default state;