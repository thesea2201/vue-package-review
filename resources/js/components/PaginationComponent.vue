<template>
    <!-- <nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
        <a class="pagination-previous" @click.prevent="changePage(1)" :disabled="pagination.current_page <= 1">First page</a>
        <a class="pagination-previous" @click.prevent="changePage(pagination.current_page - 1)" :disabled="pagination.current_page <= 1">Previous</a>
        <a class="pagination-next" @click.prevent="changePage(pagination.current_page + 1)" :disabled="pagination.current_page >= pagination.last_page">Next page</a>
        <a class="pagination-next" @click.prevent="changePage(pagination.last_page)" :disabled="pagination.current_page >= pagination.last_page">Last page</a>
        <ul class="pagination-list">
            <li v-for="page in pages" v-bind:key="page.id">
                <a class="page-item" :class="isCurrentPage(page) ? 'is-current' : ''" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
        </ul>
    </nav> -->
    <nav aria-label="Page navigation example d-flex justify-content-center">
        <ul class="pagination justify-content-center">
            <li class="page-item" @click.prevent="changePage(1)" :disabled="pagination.current_page <= 1">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">First page</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item" :disabled="pagination.current_page <= 1">
                <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <li class="page-item" :class="isCurrentPage(page) ? 'active' : ''" v-for="page in pages" v-bind:key="page.id">
                <a class="page-link" @click.prevent="changePage(page)">{{ page }}</a>
            </li>

            <li class="page-item" :disabled="pagination.current_page >= pagination.last_page">
                <a class="page-link" href="#" aria-label="Last" @click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Last</span>
                </a>
            </li>
            <li class="page-item" :disabled="pagination.current_page >= pagination.last_page">
                <a class="page-link" href="#" aria-label="Last" @click.prevent="changePage(pagination.last_page)">
                    <span aria-hidden="true">Last page</span>
                    <span class="sr-only">Last</span>
                </a>
            </li>
        </ul>
    </nav>
    
</template>

<style>
    .pagination {
        margin-top: 40px;
    }
</style>

<script>
    export default {
        props: ['pagination', 'offset'],

        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },

            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }

                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },

        computed: {
            pages() {
                let pages = [];

                let from = this.pagination.current_page - Math.floor(this.offset / 2);

                if (from < 1) {
                    from = 1;
                }

                let to = from + this.offset - 1;

                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                while (from <= to) {
                    pages.push(from);
                    from++;
                }

                return pages;
            }
        }
    }
</script>