<template>
  <div>
    <h2>Questions</h2>

    <ul class="mt-3 list-group">
      <li class="list-group-item" v-for="question in questions" v-bind:key="question.id">
        {{ question.textOfQuestion }}
      </li>
    </ul>

    <div class="mt-3">
      <nav aria-label="Question list navigation">
        <ul class="pagination justify-content-center">
          <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
            <a @click="fetchQuestions(pagination.prev_page_url)" class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item disabled"><a class="page-link tex-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
          <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
            <a @click="fetchQuestions(pagination.next_page_url)" class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'default',

  metaInfo () {
    return { title: this.$t('questions') }
  },

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  data() {
    return {
      questions: [],
      question: {
        id: '',
        textOfQuestion: '',
        answerA: '',
        answerB: '',
        answerC: '',
        answerD: '',
        correctAnswer: ''
      },
      question_id: '',
      pagination: {}
    }
  },

  created() {
    this.fetchQuestions();
  },

  methods: {
    fetchQuestions(page_url) {
      let vm = this;
      page_url = page_url || '/api/questions';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.questions = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err))
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      }
      this.pagination = pagination;
    }
  }
}
</script>

<style scoped>

</style>
