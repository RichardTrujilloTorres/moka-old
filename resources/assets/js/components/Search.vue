<template>
    <form action="#" @submit.prevent="send">
        <div class="form-group">
            <input class="form-control" style="btn btn-primary" type="search" id="search" name="search">
            <!-- <input type="text" name="search" id="search" class="form-control"> -->
            
            <button type="submit" class="btn btn-primary" style="display:none;">Send</button>
        </div>

        <!-- 
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    -->
    </form>
</template>

<script>
    import autocomplete from 'autocomplete.js'
    import algolia from 'algoliasearch'


    export default {
        methods: {
            send() {
                console.log('all good');
            }
        },
        mounted() {
            const index = algolia('YD4HTLXE2D', '1de7dc633c963f256beb1d91205b2ad2').initIndex('users')

            autocomplete('#search', {
                hint: true
            }, {
                source: autocomplete.sources.hits(index, { hitsPerPage: 10 }),
                displayKey: 'name', 
                templates: {
                    suggestion (suggestion) {
                        return '<span>' + suggestion._highlightResult.name.value + '</span>';
                    },
                    empty: '<div class="aa-empty">No users found</div>'
                }
            })

        }
    }
</script>
