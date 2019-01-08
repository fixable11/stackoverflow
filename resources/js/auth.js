let user = window.App.user;

module.exports = {

    updateAnswer(answer){
        return answer.user_id === user.id;
    },

    markAnswerAsBest(answer){
        return user.id === answer.question.user_id;  
    },
    
    updateQuestion(question){
        return user.id === question.user_id; 
        
    }

    // isAdmin(){
    //     return window.App.user.is_admin;
    // }

}