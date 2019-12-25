<template>
  <div class='row'>
    <div class="col-12">
        <h1 class="my-4">Pick a Quiz</h1>
        <ul class="nav nav-tabs mb-1" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#" role="tab" aria-controls="home" aria-selected="true">Animals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#" role="tab" aria-controls="profile" aria-selected="false">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#" role="tab" aria-controls="contact" aria-selected="false">Geography</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#" role="tab" aria-controls="contact" aria-selected="false">Chemistry</a>
            </li>   
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#" role="tab" aria-controls="contact" aria-selected="false">Art</a>
            </li>             
        </ul>
    </div>
    <div v-for="item in items" v-bind:key="item" class="col-sm-6 col-lg-4 mb-4">
        <div class="card card-animated mx-1" style="cursor: pointer">
            <img class="card-img-top" src="https://images.unsplash.com/photo-1497752531616-c3afd9760a11?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80" alt="Card image cap">
            <div class="card-body">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
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
    items: [1, 2, 3, 4, 5, 6, 7, 8, 9]
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
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
