<template>
    <ul class="dropdown-menu">
        <li v-if="!notifications.length"><a href="">You have no notifications.</a></li>

        <li v-if="notifications.length" v-for="notification in notifications">
            <a href="">{{ notification.data.text }}</a>
        </li>
    </ul>
</template>

<script>
    import axios from 'axios';

    export default {
        data: () => ({
            notifications: []
        }),

        created() {
            // TODO resource building
            axios.get('/api/notifications')
                .then(res => this.notifications = res.data.data.notifications)
                .catch(res => console.log(res))
        },
    }
</script>
