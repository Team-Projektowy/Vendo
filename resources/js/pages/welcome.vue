<template>
  <div class='row'>
    <div class="col-12">
        <h1 class="my-4">Pick a Quiz</h1>
    </div>
    <div v-for="category in categories" v-bind:key="category.id" class="col-sm-6 col-lg-4 mb-4">
        <div class="card card-animated mx-1" style="cursor: pointer">
            <img class="card-img-top" alt="Card image cap" :src="images[category.id-1].link">
            <div class="card-body">
            <p class="card-text text-center">{{ category.name }}</p>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'default',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    categories: [],
    images:[]
  }),

  computed: mapGetters({
    authenticated: 'auth/check',
  }),

  created() {
    this.fetchCategories();
    this.fetchImages();
  },

  methods: {
    fetchCategories() {
      fetch('/api/categories')
        .then(res => res.json())
        .then(res => {
          this.categories = res.data
        })
        .catch(err => console.log(err))
    },

    fetchImages() {
      fetch('/api/categories/image')
        .then(res => res.json())
        .then(res => {
          this.images = res.data
        })
        .catch(err => console.log(err))
    },
  }
}
</script>

<style scoped>
  .card-animated {
      transition: background-color 0.5s ease-in-out;
  }
  .card-animated:hover {
      background-color: #ccc;
  }
</style>
