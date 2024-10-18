<template>
    <div class="d-flex my-auto container-lg px-0">
        <Filters @filter-changed="filterChanged" />
        <Logout />
    </div>

    <div v-if="totalItems != 0" class="table-responsive card container-lg">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Country</th>
                    <th scope="col">City</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="brewery in this.breweries">
                    <td>{{ brewery.name }}</td>
                    <td>{{ brewery.brewery_type }}</td>
                    <td>{{ brewery.country }}</td>
                    <td>{{ brewery.city }}</td>
                </tr>
            </tbody>
        </table>

    </div>

    <div v-if="totalItems == 0" class="alert alert-info container-lg" role="alert">
        No breweries found!
    </div>

    <Pagination :currentPage="currentPage" :lastPage="lastPage" :totalItems="totalItems" :perPage="perPage"
        @page-changed="pageChange" />
</template>

<script>
import axios from 'axios';
import Pagination from './Pagination.vue';
import Filters from './Filters.vue';
import Logout from './Logout.vue';


export default {
    name: 'Breweries',
    components: {
        Pagination,
        Filters,
        Logout
    },
    data() {
        return {
            breweries: [],
            currentPage: 1,
            lastPage: 1,
            totalItems: 0,
            perPage: 10,
            selectedFilters: {
                brewery_type: '',
                country: '',
                city: '',
                name: '',
            }
        };
    },
    mounted() {
        this.fetchBreweries();
    },
    methods: {
        async fetchBreweries() {
            try {
                const response = await axios.get('/api/breweries',
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`,
                        },
                        params: {
                            page: this.currentPage,
                            per_page: this.perPage,
                            ...(this.selectedFilters.brewery_type !== '' && { brewery_type: this.selectedFilters.brewery_type }),
                            ...(this.selectedFilters.country !== '' && { country: this.selectedFilters.country }),
                            ...(this.selectedFilters.city !== '' && { city: this.selectedFilters.city }),
                            ...(this.selectedFilters.name !== '' && { name: this.selectedFilters.name }),
                        }
                    }
                );
                this.breweries = response.data.data;
                this.currentPage = response.data.meta.current_page;
                this.lastPage = response.data.meta.last_page;
                this.totalItems = response.data.meta.total_items;
                this.perPage = response.data.meta.per_page;
            } catch (error) {
                console.log(error);
            }
        },
        pageChange(page) {
            // When the page is changed, we need to fetch the breweries again
            this.currentPage = page;
            this.fetchBreweries();
        },
        filterChanged(type, value) {
            // When a filter is changed, we need to update the selectedFilters object and fetch the breweries again
            this.selectedFilters[type] = value;
            // If any filter is changed, we need to reset the current page to 1
            this.currentPage = 1;
            this.fetchBreweries();
        },
    },
};
</script>

<style scoped></style>