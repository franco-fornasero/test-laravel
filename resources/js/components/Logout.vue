<template >
     <button @click="logout" type="button" class="btn btn-outline-danger">Logut <i
        class="fa-solid fa-right-from-bracket"></i></button>
</template>
<script>
import axios from 'axios';

export default {
    methods: {
        async logout() {
            try {
                await axios.post('/api/logout', null, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                console.log('Logged out');
                localStorage.removeItem('token');
                this.$router.push({ name: 'Login' });
            } catch (error) {
                console.error(error);
            }
        },
    },
}
</script>
<style >
    
</style>