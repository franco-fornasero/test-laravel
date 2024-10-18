<template>
    <div class="d-flex align-items-center my-auto justify-content-center mx-auto">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li @click="changePage(currentPage - 1)" class="page-item"><a class="page-link" href="#" :class="{ disabled: currentPage == 1 }">Previous</a></li>
                <li @click="changePage(page)"  v-for="page in lastPage" class="page-item" :class="{ active: currentPage == page }"><a class="page-link" href="#">{{ page }}</a></li>
                <li @click="changePage(this.currentPage + 1)"  class="page-item"><a class="page-link" href="#" :class="{ disabled: currentPage == lastPage || totalItems == 0 }">Next</a></li>
            </ul>
        </nav>
    </div>
</template>
<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        lastPage: {
            type: Number,
            required: true,
        },
        totalItems: {
            type: Number,
            required: true,
        },
        perPage: {
            type: Number,
            required: true,
        },
    },
    methods: {
        changePage(page) {
            this.$emit('page-changed', page);
        }
    }
}
</script>
<style>

</style>