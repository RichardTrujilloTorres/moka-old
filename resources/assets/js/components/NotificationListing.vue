<template>
    <ul class="dropdown-menu">
        <li v-if="!hasUnreadNotifications"><a href="#">You have no notifications.</a></li>

        <li v-if="hasUnreadNotifications" v-for="notification in unreadNotifications">
            <a :href="notificationUrl(notification.id)">{{ notification.data.text }}</a>
        </li>
    </ul>
</template>

<script>
    import axios from 'axios';

    export default {
        data: () => ({
            notifications: []
        }),

        computed: {
            hasUnreadNotifications() {
                if (!this.notifications.length) {
                    return false
                }

                return this.unreadNotifications.length
            },
            unreadNotifications() {
                return this.notifications.filter(notification => notification.read_at === null)
            },
        },

        methods: {
            notificationUrl(id) {
                return `/admin/users/notifications/${id}`
            }
        },

        created() {
            // TODO resource building
            axios.get('/api/notifications')
                .then(res => this.notifications = res.data.data.notifications)
                .catch(res => console.log(res)) // TODO set error handling
        },
    }
</script>
