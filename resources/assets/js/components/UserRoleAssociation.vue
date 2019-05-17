<template>
    <div class="user-role-widget">

    <div class="card ">
        <div class="header">
            <h4 class="title">User-Role Association</h4>
            <p class="category">All</p>
        </div>
        <div class="content">

            <div class="row">
                <div class="col-md-6">
                    <user-multiselect
                        @user-selected="userSelected"
                        @user-removed="removeUser"
                    ></user-multiselect>
                </div>
                <div class="col-md-6">
                    <role-multiselect
                        @role-selected="roleSelected"
                        @role-removed="removeRole"
                    ></role-multiselect>
                </div>
            </div>

            <div class="footer">
                <user-role-listing
                        :users="users"
                        :roles="roles"
                        @remove-user="removeUser"
                        @remove-role="removeRole"
                ></user-role-listing>
            </div>
        </div>
    </div>


    </div>
</template>

<script>
    import UserRoleListing from "./UserRoleListing";
    export default {
        components: {UserRoleListing},
        data: () => ({
        }),
        computed: {
            users() {
                return this.$store.getters.getUsers
            },
            roles() {
                return this.$store.getters.getRoles
            }
        },
        methods: {
            removeUser(user) {
                this.$store.commit('removeUser', user)
            },
            removeRole(role) {
                this.$store.commit('removeRole', role)
            },
            userSelected(option) {
                this.$store.commit('addUser', option)
            },
            roleSelected(option) {
                this.$store.commit('addRole', option)
            }
        },
    }
</script>
