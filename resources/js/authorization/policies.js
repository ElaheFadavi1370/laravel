export default {
    modify: function (user , model) {
        return user.id === model.user_id;
    },
    accept: function (user , answer) {
     return user.id === answer.question.user_id;
    },
   deleteQuestion: function (user , question) {
       return user.id === question.user_id && question.answers_count() < 1;

   }
}
