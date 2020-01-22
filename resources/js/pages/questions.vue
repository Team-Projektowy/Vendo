<template>
  <div style="height:auto">
    <h2 class="mb-4">Questions</h2>

    <div id="questions-header" class="d-flex justify-content-between align-items-center">
      <ul class="nav nav-tabs mb-1">
        <li v-for="category in categories" :key="category.id" class="nav-item">
          <a :class="{ active: activeCategory == category.id }" @click="fetchQuestionsByCategory(category.id)" class="nav-link" href='#'>{{ category.name }}</a>
        </li>
      </ul>
      <div class="form-inline md-form form-sm mt-0">
        <div class="input-group mx-2 search-bar">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-search" aria-hidden="true"></i>
            </span>
          </div>
          <input id="questions-search-bar" v-model="search" class="form-control form-control" type="text" placeholder="Search" aria-label="Search">
        </div>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#addQuestionModal">
          <i class="fas fa-plus"></i> Add
        </button>
      </div>
    </div>

    <div v-for="question in questions" v-bind:key="question.id" class="card">
      <div class="card-header d-flex justify-content-between align-items-center" :id="'heading' + question.id">
        <h6 class="mb-0 question-header">
            {{ question.text }}
        </h6>
        <div>
          <button @click="setQuestionToDelete(question)" class="btn btn-link question-icon" data-toggle="modal" data-target="#deleteQuestionModal">
            <i class="fas fa-trash-alt"></i>
          </button>
          <button @click="changeActive(question.id)" class="btn btn-link question-icon" data-toggle="collapse" :data-target="'#collapse' + question.id" aria-expanded="false" :aria-controls="'collapse' + question.id">
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
          <p class="mt-3 mb-0">Added by user: {{ question.users[0].name }}</p>
        </div>
      </div>
    </div>

    <div class="mt-3">
      <nav aria-label="Question list navigation">
        <ul class="pagination justify-content-center">
          <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
            <a @click="fetchQuestions(pagination.prev_page_url)" class="page-link" aria-label="Previous">
              <i class="fas fa-angle-double-left" aria-hidden="true"></i>
            </a>
          </li>
          <li class="page-item disabled"><a class="page-link tex-dark">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
          <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
            <a @click="fetchQuestions(pagination.next_page_url)" class="page-link" aria-label="Next">
              <i class="fas fa-angle-double-right" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="modal fade" id="deleteQuestionModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark d-flex align-items-center">
            <h5 class="modal-title text-light" id="deleteQuestionModalTitle">Delete question</h5>
            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body py-3">
            Are you sure you want to delete this question? <br>
            {{ questionToDelete.textOfQuestion }}
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
            <button @click="deleteQuestion()" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
          </div>
        </div>
      </div>
    </div>

     <div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addeQuestionModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark d-flex align-items-center">
            <h5 class="modal-title text-light" id="addQuestionModalTitle">Add question</h5>
            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="fas fa-times"></i>
            </button>
          </div>
          <form @submit.prevent="addQuestion">
            <div class="modal-body py-3">
              <label for="text">Question</label>
              <input v-model="question.text" class="form-control mb-2" type="text" placeholder="Question">
              <label for="category">Category</label>
              <select v-model="question.category" class="form-control mb-2">
                <option v-for="category in categoriesWithoutAll" v-bind:key="category.id" :value="category.id">{{ category.name }}</option>
              </select>
              <label>Answers</label>
              <input v-model="question.answerA" class="form-control mb-1" type="text" placeholder="Answer 1">
              <input v-model="question.answerB" class="form-control mb-1" type="text" placeholder="Answer 2">
              <input v-model="question.answerC" class="form-control mb-1" type="text" placeholder="Answer 3">
              <input v-model="question.answerD" class="form-control mb-1" type="text" placeholder="Answer 4">
              <label>Correct answer</label>
              <div name="correctAnswer">
                <div class="form-check form-check-inline">
                  <input v-model="question.correctAnswer" class="form-check-input" type="radio" id="radioAnswerA" value="0">
                  <label class="form-check-label" for="radioAnswerA">A</label>
                </div>
                <div class="form-check form-check-inline">
                  <input v-model="question.correctAnswer" class="form-check-input" type="radio" id="radioAnswerB" value="1">
                  <label class="form-check-label" for="radioAnswerB">B</label>
                </div>
                <div class="form-check form-check-inline">
                  <input v-model="question.correctAnswer" class="form-check-input" type="radio" id="radioAnswerC" value="2">
                  <label class="form-check-label" for="radioAnswerC">C</label>
                </div>
                <div class="form-check form-check-inline">
                  <input v-model="question.correctAnswer" class="form-check-input" type="radio" id="radioAnswerD" value="3">
                  <label class="form-check-label" for="radioAnswerD">D</label>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="submit" name="submit" class="btn btn-success" :disabled="!validateForm()">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',
  layout: 'default',

  metaInfo () {
    return { title: this.$t('Questions') }
  },

  computed: mapGetters({
    authenticated: 'auth/check',
  }),

  data() {
    return {
      questions: [],
      question: {
        id: '',
        text: '',
        answerA: '',
        answerB: '',
        answerC: '',
        answerD: '',
        correctAnswer: '',
        language: '',
        added_by_user: ''
      },
      // question_id: '',
      pagination: {},

      activeQuestions: [],

      categories: [],
      activeCategory: -1,

      search: '',
      questionToDelete: {},
      current_page_url: '',

      user: [],

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
    this.fetchCategories();
    this.fetchQuestionsByCategory(this.activeCategory);
    this.fetchUser();
    this.debouncedFetchQuestionBySearch = _.debounce(this.fetchQuestionsBySearch, 500);
  },

  computed: {
    searchComputed: function() {
      return this.search.replace(/\s+/g,' ')
    },
    categoriesWithoutAll: function() {
      return _.tail(this.categories);
    }
  },

  methods: {
    fetchCategories() {
      fetch('/api/categories')
        .then(res => res.json())
        .then(res => {
          this.categories = res.data
          this.categories.unshift({
            "id": -1,
            "name": "All"
          })
        })
        .catch(err => console.log(err))
    },

    fetchQuestions(page_url) {
      let vm = this;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.questions = res.data;
          vm.makePagination(res);
        })
        .catch(err => console.log(err))
      this.current_page_url = page_url;
    },

    fetchQuestionsByCategory(category, page_url) {
      this.activeCategory = category;
      let vm = this;
      page_url = page_url || '/api/questions';
      if (category != -1) {
        page_url += '/' + category;
      }
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.questions = res.data;
          vm.makePagination(res);
        })
        .catch(err => console.log(err))
        this.current_page_url = page_url;
    },

    fetchUser() {
      fetch('api/user')
      .then(res => res.json())
      .then(res => {
        this.user = res
      })
      .catch(err => console.log(err))
    },

    makePagination(res) {
      let pagination = {
        current_page: Math.ceil(res.to / 15.0),
        last_page: res.last_page,
        next_page_url: res.next_page_url,
        prev_page_url: res.prev_page_url
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
            vm.makePagination(res);
          })
          .catch(err => console.log(err))
        this.current_page_url = page_url
      } else {
        vm.fetchQuestionsByCategory(this.activeCategory);
      }
    },

    setQuestionToDelete(questionToDelete) {
      this.questionToDelete = questionToDelete;
    },

    deleteQuestion() {
      fetch('/api/question/' + this.questionToDelete.id, {
        method: 'delete'
      })
      .then(response => response.json())
      .catch(err => console.log(err));

      this.fetchQuestions(this.current_page_url)
    },

    addQuestion() {
      this.question.language = "en"
      this.question.added_by_user = this.user.id
      fetch('/api/question', {
        method: 'post',
        body: JSON.stringify(this.question),
        headers: {
          'content-type': 'application/json'
        }
      })
      .then(res => res.json())
      .then(data => {
        this.question.text = '';
        this.question.category = '';
        this.question.answerA = '';
        this.question.answerB = '';
        this.question.answerC = '';
        this.question.answerD = '';
        this.question.correctAnswer = '';
        this.question.language = '';
        this.question.added_by_user = this.user.id;
        $("#addQuestionModal .close").click();
        this.fetchQuestions(this.current_page_url);
      })
      .catch(err => console.log(err))
    },

    validateForm() {
      if (this.question.text.replace(/\s/g, "").length < 10 ||
          this.question.answerA.replace(/\s/g, "").length < 1 ||
          this.question.answerB.replace(/\s/g, "").length < 1 ||
          this.question.answerC.replace(/\s/g, "").length < 1 ||
          this.question.answerD.replace(/\s/g, "").length < 1 ||
          this.question.correctAnswer == '') {
        return false;
      }
      return true;
    }
  },

  watch: {
    search: function() {
      this.debouncedFetchQuestionBySearch()
    }
  }
}
</script>
