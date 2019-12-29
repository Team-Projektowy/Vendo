<template>
  <div>
    <h2 class="mb-4">Questions</h2>

    <div class="d-flex justify-content-between align-items-center">
      <ul class="nav nav-tabs mb-1">
        <li v-for="category in categories" :key="category" class="nav-item">
          <a :class="{ active: activeCategory == category }" @click="fetchQuestionsByCategory(category)" class="nav-link" href='#'>{{ category }}</a>
        </li>
      </ul>
      <div class="form-inline md-form form-sm mt-0">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input v-model="search" class="form-control form-control-sm ml-3" type="text" placeholder="Search" aria-label="Search">
        <!-- @change="fetchQuestionsBySearch(searchComputed)" -->
      </div>
    </div>

    <div v-for="question in questions" v-bind:key="question.id" class="card">
      <div class="card-header d-flex justify-content-between align-items-center" :id="'heading' + question.id">
        <h6 class="mb-0">
            {{ question.textOfQuestion }}
        </h6>
        <div>
          <button class="btn btn-link" style="color: var(--danger)">
            <i class="fas fa-trash-alt"></i>
          </button>
          <button @click="changeActive(question.id)" class="btn btn-link" style="color: var(--success)" data-toggle="collapse" :data-target="'#collapse' + question.id" aria-expanded="false" :aria-controls="'collapse' + question.id">
            <i class="fas" :class="{ 'fa-chevron-down': !activeQuestions.includes(question.id), 'fa-chevron-up': activeQuestions.includes(question.id) }"></i>
          </button>
        </div>
      </div>

      <div :id="'collapse' + question.id" class="collapse" :aria-labelledby="'heading' + question.id">
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item" :class="{'list-group-item-success': question.correctAnswer == '0'}">
              {{ question.answerA }}
            </li>
            <li class="list-group-item" :class="{'list-group-item-success': question.correctAnswer == '1'}">
              {{ question.answerB }}
            </li>
            <li class="list-group-item" :class="{'list-group-item-success': question.correctAnswer == '2'}">
              {{ question.answerC }}
            </li>
            <li class="list-group-item" :class="{'list-group-item-success': question.correctAnswer == '3'}">
              {{ question.answerD }}
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="mt-3">
      <nav aria-label="Question list navigation">
        <ul class="pagination justify-content-center">
          <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
            <a @click="fetchQuestions(pagination.prev_page_url)" class="page-link" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item disabled"><a class="page-link tex-dark">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
          <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
            <a @click="fetchQuestions(pagination.next_page_url)" class="page-link" aria-label="Next">
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
    return { title: this.$t('Questions') }
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
      pagination: {},

      activeQuestions: [],

      categories: ['All', 'Animals', 'History', 'Geography', 'Chemistry', 'Art'],
      activeCategory: 'All',

      search: '',

      changeActive(questionId) {
        let indexInArray = this.activeQuestions.indexOf(questionId);
        if (indexInArray > -1) {
          this.activeQuestions.splice(indexInArray, 1);
        } else {
          this.activeQuestions.push(questionId);
        }
      },
    }
  },

  created() {
    this.fetchQuestionsByCategory(this.activeCategory);
    this.debouncedFetchQuestionBySearch = _.debounce(this.fetchQuestionsBySearch, 500);
  },

  computed: {
    searchComputed: function() {
      return this.search.replace(/\s+/g,' ')
    }
  },

  methods: {
    fetchQuestions(page_url) {
      let vm = this;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.questions = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err))
    },

    fetchQuestionsByCategory(category, page_url) {
      this.activeCategory = category;
      let vm = this;
      page_url = page_url || '/api/questions';
      if (category != 'All') {
        page_url += '/' + category;
      }
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
      if (pagination.last_page == null) {
        pagination.last_page = 1;
      }
      this.pagination = pagination;
    },

    fetchQuestionsBySearch() {
      let vm = this;
      if (this.search != "" && this.search != " ") {
        let page_url = "/api/questions/bySearch/" + this.search;
        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.questions = res.data;
            vm.makePagination(res.meta, res.links);
          })
          .catch(err => console.log(err))
      } else {
        vm.fetchQuestionsByCategory(this.activeCategory);
      }
    }
  },

  watch: {
    search: function() {
      this.debouncedFetchQuestionBySearch()
    }
  }
}
</script>

<style scoped>

</style>