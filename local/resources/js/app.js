require('./bootstrap');
import { createApp } from 'vue'
import LoginComponent from  './components/LoginComponent'


createApp({
    components: {
		LoginComponent,
	}
}).mount('#app');