<template>
  <div>
    <h4 class="mb-4">Your score is {{ score }}%</h4>
    <div v-for="question in questions" :key="question.id">
      <h5>{{ question.text }}</h5>
      <ul class="list-group mb-4">
        <li class="list-group-item" :class="get_answer_class(question, 0)">{{ question.answerA }}</li>
        <li class="list-group-item" :class="get_answer_class(question, 1)">{{ question.answerB }}</li>
        <li class="list-group-item" :class="get_answer_class(question, 2)">{{ question.answerC }}</li>
        <li class="list-group-item" :class="get_answer_class(question, 3)">{{ question.answerD }}</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'default',

  metaInfo () {
    return { title: 'Results' }
  },

  data() {
    return {
      questions: [],
    }
  },

  methods: {
    fetch_questions() {
      fetch('/api/quiz', {
          method: 'post',
          body: JSON.stringify(this.$route.params.answers),
          headers: {
            'content-type': 'application/json'
          }
        })
        .then(res => res.json())
        .then(res => {
          this.questions = res.data
        })
        .catch(err => console.log(err))
    },

    get_answer_class(question, answerId) {
      if (question.userAnswer == answerId && question.correctAnswer == answerId) {
        return 'list-group-item-success'
      } else if (question.userAnswer == answerId && question.correctAnswer != answerId) {
        return 'list-group-item-danger'
      } else if (question.correctAnswer == answerId) {
        return 'list-group-item-success'
      }
    }
  },

  computed: {
    score: function(){
      let correctAnswersCount = 0;
      for (const id in this.questions) {
        if (this.questions[id].correctAnswer == this.questions[id].userAnswer) {
          correctAnswersCount++;
        }
      }
      console.log(correctAnswersCount)
      console.log(this.questions.length * 100)
      return correctAnswersCount / this.questions.length * 100
    }
  },


  created() {
    this.fetch_questions()
  }
}
</script>
