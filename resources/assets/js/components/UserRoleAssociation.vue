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
                    <span v-if="errors.users">{{ errors.users[0] }}</span>
                </div>
                <div class="col-md-6">
                    <role-multiselect
                        @role-selected="roleSelected"
                        @role-removed="removeRole"
                    ></role-multiselect>
                    <span v-if="errors.roles">{{ errors.roles[0] }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <user-role-listing
                            :users="users"
                            :roles="roles"
                            @remove-user="removeUser"
                            @remove-role="removeRole"
                    ></user-role-listing>
                </div>
            </div>

            <div class="footer">
                <button
                        type="button"
                        @click="submit"
                        class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>


    </div>
</template>

<script>
    import UserRoleListing from "./UserRoleListing";
    import axios from 'axios';

    export default {
        components: {UserRoleListing},
        data: () => ({
            errors: []
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
            submit() {
                this.errors = []

                // TODO resource replacement
                axios.post(`/api/users-roles/associate`, {
                    users: this.users,
                    roles: this.roles
                })
                    .then(res => this.onSuccess(res))
                    .catch(res => this.onError(res))

                // TODO error handling
            },
            // TODO mixin
            onError(res) {
                if (res.response.hasOwnProperty('data')) {
                    this.errors = res.response.data
                }

                $.notify({
                    icon: 'ti-check',
                    message: 'Could not complete the operation'

                },{
                    type: 'danger',
                    timer: 3000
                });
            },
            // TODO mixins
            onSuccess(res) {
                $.notify({
                    icon: 'ti-check',
                    message: 'Operation successfully completed'

                },{
                    type: 'success',
                    timer: 3000
                });
            },
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
