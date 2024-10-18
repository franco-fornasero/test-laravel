<template>
    <div class="d-flex align-items-center my-auto justify-content-center mx-auto">

        <div class="dropdown mx-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ selectedFilters['brewery_type'] === '' ? 'Brewery Type' : selectedFilters['brewery_type'] }}
            </button>
            <ul class="dropdown-menu">
                <li @click="filterChanged('brewery_type', '')"><a class="dropdown-item" href="#">Brewery Type</a></li>
                <li @click="filterChanged('brewery_type', type)" v-for="type in filters['brewery_types']"><a
                        class="dropdown-item" href="#">{{ type }}</a></li>
            </ul>
        </div>

        <div class="dropdown mx-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ selectedFilters['country'] === '' ? 'Country' : selectedFilters['country'] }}
            </button>
            <ul class="dropdown-menu">
                <li @click="filterChanged('country', '')"><a class="dropdown-item" href="#">Country</a></li>
                <li @click="filterChanged('country', country)" v-for="country in filters['countries']"><a
                        class="dropdown-item" href="#">{{ country }}</a></li>
            </ul>
        </div>

        <div class="dropdown mx-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ selectedFilters['city'] === '' ? 'City' : selectedFilters['city'] }}
            </button>
            <ul class="dropdown-menu" id="dropdown-cities">
                <li @click="filterChanged('city', '')"><a class="dropdown-item" href="#">City</a></li>
                <li @click="filterChanged('city', city)" v-for="city in filters['cities']"><a class="dropdown-item"
                        href="#">{{ city }}</a></li>
            </ul>
        </div>

        <div class="input-group mx-2">
            <input v-model="this.inputName" @input="filterChanged('name', inputName)" type="text" class="form-control"
                placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
        </div>

    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            filters: [],
            selectedFilters: {
                brewery_type: '',
                country: '',
                city: '',
            },
            inputName: '',
        };
    },
    methods: {
        // Get filters from the server
        async getFilters() {
            try {
                const response = await axios.get('/api/breweries/filters',
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`,
                        },
                    }
                );
                this.filters = response.data;
            } catch (error) {
                console.log(error);
            }
        },
        filterChanged(type, value) {
            // Update the selected filters
            this.selectedFilters[type] = value;
            this.$emit('filter-changed', type, value);
        },

    },
    mounted() {
        this.getFilters();
    }

}
</script>
<style>
#dropdown-cities {
    max-height: 200px;
    overflow-y: auto;
}
</style>