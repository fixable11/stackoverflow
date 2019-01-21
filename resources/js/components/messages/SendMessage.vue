<template>
    <div class="col-12">
        <form @submit.prevent="sendMessage($event)">
            <div class="lead">Send to @nickname</div>
            <vue-tribute class="form-group" :options="tributeOptions">  
                <input id="user_email" 
                @keydown.once="isTypeing($event.target)" 
                type="text"
                class="form-control"
                name="nickname"
                v-model="nickname"
                placeholder="@...">
            </vue-tribute>
            <div class="lead">Subject</div>
            <div class="form-group">
                <input name="subject" type="text" class="form-control" v-model="subject">
            </div>
            <div class="lead">Message body</div>
            <div class="form-group">
                <textarea v-model="body" class="form-control" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
            
        </form>
    </div>
</template>

<script>
import VueTribute from 'vue-tribute'
export default {
    components: {
        VueTribute
    },
    data() {
        return {
            nickname: '',
            subject: '',
            body: '',
            typingText: '',
            cb: null,
            tributeOptions: {
                values: (text, cb) => {
                    this.typingText = text;
                    this.cb = cb;
                },
            },
            
            
        }
    },
    methods: {

        isTypeing(input){
            let typingTimer; //timer identifier
            let doneTypingInterval = 500; //request delay

            //on keyup, start the countdown
            input.addEventListener('keyup', () => {

                clearTimeout(typingTimer);

                if (input.value) {
                    typingTimer = setTimeout(() => {
                        //user is "finished typing," do something
                        this.remoteSearch(this.typingText, users => this.cb(users));
                    }, doneTypingInterval);
                }

            });
            
        },

        remoteSearch(text, cb) {
            let URL = this.endpoint + '/?name=' + text;

            axios.get(URL)
            .then(({data}) => {
                cb(data.users);
            })
            .catch((error) => {

            });
        },

        sendMessage($event){

            let nickname = this.nickname;

            axios.post(this.sendMessageEndpoint, {
                nickname: nickname.replace(/@/g, ''),
                body: this.body,
                subject: this.subject,
            })
            .then(({data}) => {
                flash(data.message, 'success');
                $event.target.reset()
            })
            .catch((error) => {
                let errorsObj = error.response.data.errors;

                for(let key in errorsObj){
                    errorsObj[key].forEach(value => {
                        flash(value, 'error');
                    });
                }
            });
            
        }

    },
    computed: {
        endpoint(){
            return '/api/users';
        },
        sendMessageEndpoint(){
            return '/profiles/' + this.$store.getters.nickname + '/message/send';
        },
    }
}
</script>

<style lang="scss">
.tribute-container {
  position: absolute;
  top: 0;
  left: 0;
  height: auto;
  max-height: 300px;
  max-width: 500px;
  overflow: auto;
  display: block;
  z-index: 999999;

  ul {
    margin: 0;
    margin-top: 2px;
    padding: 0;
    list-style: none;
    background: #efefef;
  }

  li {
    padding: 5px 5px;
    cursor: pointer;

    &.highlight, &:hover {
      background: #ddd;
    }

    span {
      font-weight: bold;
    }

    &.no-match {
      cursor: default;
    }
  }

  .menu-highlighted {
    font-weight: bold;
  }

}
</style>
