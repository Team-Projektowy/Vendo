<template>
  <div>
    <div class='row'>
      <div class="col-12">
          <h1 class="my-4">Pick a Quiz</h1>
      </div>
      <div v-for="category in categories" v-bind:key="category.id" class="col-sm-6 col-lg-4 mb-4">
          <div class="card card-animated mx-1" style="cursor: pointer" @click="chooseCategory(category)" data-toggle="modal" data-target="#takeQuizModal" data-backdrop="false">
              <img class="card-img-top" alt="Card image cap" :src="images[category.id-1].link">
              <div class="card-body">
              <p class="card-text text-center">{{ category.name }}</p>
              </div>
          </div>
      </div>
    </div>
    <div class="modal fade" id="takeQuizModal" tabindex="-1" role="dialog" aria-labelledby="takeQuizModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark d-flex align-items-center">
            <h5 class="modal-title text-light" id="takeQuizModalTitle">Take a quiz</h5>
            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body py-3">
            Category: {{ this.chosenCategory.name }}
            <label>Time for quiz (in minutes)</label>
            <input v-model="chosenTime" class="form-control mb-2" type="number" min="1" max="60">
            <label>Number of questions</label>
            <input v-model="chosenNumberOfQuestions" class="form-control" type="number" min="5" max="10">
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <router-link :to="{ name: 'quiz', params: { category: this.chosenCategory.id, numberOfQuestions: this.chosenNumberOfQuestions,  time: this.chosenTime,  } }" class="nav-link" active-class="active">
              <button type="button" class="btn btn-success">Go</button>
            </router-link>
          </div>
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
    images:[],
    chosenCategory: {},
    chosenNumberOfQuestions: 10,
    chosenTime: 5
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

    chooseCategory(category) {
      this.chosenCategory = category;
    }
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
