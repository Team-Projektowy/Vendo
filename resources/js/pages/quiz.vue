<template>
  <div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
      <!-- <ol class="carousel-indicators mt-5">
        <li v-for="question in questions" :key="questions.indexOf(question)" :data-target="'#carousel' + questions.indexOf(question)" :data-slide-to="questions.indexOf(question)" :class="{ active: questions.indexOf(question) == 0 }"></li>
      </ol> -->
      <div class="carousel-inner">
        <div v-for="question in questions" :key="questions.indexOf(question)" class="carousel-item" :class="{ active: questions.indexOf(question) == 0 }" :id="'carousel' + questions.indexOf(question)">
          <div class="card">
            <div class="card-header">
              <h5>
                {{ "#" + (questions.indexOf(question) + 1) + " " + question.text }}
              </h5>
            </div>
            <div class="card-body">
              <div class="custom-control custom-radio">
                <input type="radio" :id="'customRadio0' + questions.indexOf(question)" :name="'customRadio' + questions.indexOf(question)" class="custom-control-input" value="0" v-model="answers[question.id]">
                <label class="custom-control-label" :for="'customRadio0' + questions.indexOf(question)">{{ question.answerA }}</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" :id="'customRadio1' + questions.indexOf(question)" :name="'customRadio' + questions.indexOf(question)" class="custom-control-input" value="1" v-model="answers[question.id]">
                <label class="custom-control-label" :for="'customRadio1' + questions.indexOf(question)">{{ question.answerB }}</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" :id="'customRadio2' + questions.indexOf(question)" :name="'customRadio' + questions.indexOf(question)" class="custom-control-input" value="2" v-model="answers[question.id]">
                <label class="custom-control-label" :for="'customRadio2' + questions.indexOf(question)">{{ question.answerC }}</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" :id="'customRadio3' + questions.indexOf(question)" :name="'customRadio' + questions.indexOf(question)" class="custom-control-input" value="3" v-model="answers[question.id]">
                <label class="custom-control-label" :for="'customRadio3' + questions.indexOf(question)">{{ question.answerD }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-2">
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <router-link :to="{ name: 'results', params: { answers: this.answers }}" class="nav-link" active-class="active">
        <button class="btn btn-success">Submit</button>
      </router-link>
    </div>
  </div>

</template>

<script>
export default {
  layout: 'default',

  metaInfo () {
    return { title: "Quiz" }
  },

  data() {
    return {
      questions: [],
      answers: {}
    }
  },

  created() {
    this.fetchQuestions();
  },

  methods: {
    fetchQuestions() {
      fetch('/api/quiz/' + this.$route.params.category + '/' + this.$route.params.numberOfQuestions)
        .then(res => res.json())
        .then(res => {
          this.questions = res.data
          for (const i in this.questions) {
          console.log(this.questions[i].id)
          this.answers[this.questions[i].id] = "-1"
          }
        })
        .catch(err => console.log(err))
        // this.answers.number = this.$route.params.numberOfQuestions
    },

    // answerToQuestion(question_id, answer_id) {
    //   this.answers[question_id] = answer_id;
    // },

    checkQuiz() {
      fetch('/api/quiz', {
        method: 'post',
        body: JSON.stringify(this.answers),
        headers: {
          'content-type': 'application/json'
        }
      })
      .then(res => res.json())
      .catch(err => console.log(err))
    },

    // checkQuiz() {
    //   let correctAnswers = {};

    //   console.log("Correct answers")
    //   for (const question in this.questions) {
    //     correctAnswers[this.questions[question].id] = this.questions[question].correctAnswer.toString();
    //     console.log(this.questions[question].correctAnswer.toString());
    //   }

    //   console.log("User answers")
    //   for (const answer in this.answers) {
    //     console.log(this.answers[answer])
    //   }

    //   for (const id in correctAnswers){
    //     if (correctAnswers[id] == this.answers[id])
    //       this.numberCorrect++;
    //   }
    //   console.log("Number correct " + this.numberCorrect)
    // }
  }
}
</script>
