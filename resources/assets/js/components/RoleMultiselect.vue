<template>
    <div>
        <label class="typo__label" for="ajax">Roles</label>
        <multiselect v-model="selectedRoles"
                     id="ajax"
                     label="name"
                     track-by="name"
                     placeholder="Type to search"
                     open-direction="bottom"
                     :options="roles"
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
            <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.name }}</span>
                <span class="custom__remove" @click="remove(option)">❌</span></span>
            </template>
            <template slot="clear" slot-scope="props">
                <div class="multiselect__clear" v-if="selectedRoles.length" @mousedown.prevent.stop="clear(props.search)"></div>
            </template><span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
        </multiselect>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import {search} from "../api/roles";

    export default {
        components: {
            Multiselect
        },
        data () {
            return {
                selectedRoles: [],
                roles: [],
                isLoading: false
            }
        },
        methods: {
            limitText (count) {
                return `and ${count} other roles`
            },
            search(query) {
                this.isLoading = true
                search(query)
                    .then(res => {
                        console.log(res)
                        this.roles = res.data.data.roles
                        this.isLoading = false
                    })
            },
            clear() {
                this.selectedRoles = []
            }
        }
    }
</script>
