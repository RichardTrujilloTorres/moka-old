<template>
    <div>
        <label class="typo__label" for="ajax">Users</label>
        <multiselect v-model="selectedUsers"
                     id="ajax"
                     :custom-label="customLabel"
                     track-by="email"
                     placeholder="Type to search"
                     open-direction="bottom"
                     :options="users"
                     :multiple="true"
                     :searchable="true"
                     :loading="isLoading"
                     :internal-search="false"
                     :clear-on-select="false"
                     :close-on-select="false"
                     :options-limit="300"
                     :limit="3"
                     :limit-text="limitText"
                     :max-height="600"
                     :show-no-results="false"
                     :hide-selected="true"
                     @search-change="search"
        >
            <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ customLabel(option) }}</span>
                <span class="custom__remove" @click="remove(option)">❌</span></span>
            </template>
            <template slot="clear" slot-scope="props">
                <div class="multiselect__clear" v-if="selectedUsers.length" @mousedown.prevent.stop="clear(props.search)"></div>
            </template><span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
        </multiselect>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import {search} from "../api/users";

    export default {
        components: {
            Multiselect
        },
        data () {
            return {
                selectedUsers: [],
                users: [],
                isLoading: false
            }
        },
        methods: {
            customLabel(option) {
                return `${option.name} (${option.email})`
            },
            limitText (count) {
                return `and ${count} other users`
            },
            search(query) {
                this.isLoading = true
                search(query)
                    .then(res => {
                        console.log(res)
                        this.users = res.data.data.users
                        this.isLoading = false
                    })
            },
            clear() {
                this.selectedUsers = []
            }
        }
    }
</script>
