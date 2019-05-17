<template>
    <div class="user-role-listing">
        <div class="row">
            <div class="col-md-6">
                <h5>Users</h5>
                <ul>
                    <li v-for="user in users">
                        {{ user.name }} ({{ user.email }})
                        <span class="custom__remove" @click="removeUser(user)">❌</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>Roles</h5>
                <ul>
                    <li v-for="role in roles">
                        {{ role.name }}
                        <span class="custom__remove" @click="removeRole(role)">❌</span>
                    </li>
                </ul>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            users: {
                type: Array,
                required: false,
                default: []
            },
            roles: {
                type: Array,
                required: false,
                default: []
            }
        },
        data: () => ({
        }),

        computed: {
        },

        methods: {
            removeUser(user) {
                this.$emit('remove-user', user)
            },
            removeRole(role) {
                this.$emit('remove-role', role)
            }
        },

        created() {
        },

    }
</script>
