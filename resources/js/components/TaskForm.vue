<template>

    <form @submit.prevent="addTask()" method="POST">
    <div class="form-group">
        <label for="taskBody">Task title</label>
        <input autocomplete="off" type="text" v-model="taskTitle" @keyup="disabledBtn()" id="taskBody" class="form-control" placeholder="e.g. Making a coffe">
        <label class="mt-4" for="taskTitle">Task Body</label>
        <textarea autocomplete="off" v-model="taskBody" @keyup="disabledBtn()" id="taskTitle" class="form-control" placeholder="Write something.." cols="30" rows="5"></textarea>
    </div>
    <button :disabled="isDisabled" type="submit" class="btn btn-primary">
        <span v-show="sending" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Add Task
        </button>
    </form>

</template>

<script>
    export default {
        data(){
            return{
                taskBody : '',
                taskTitle : '',
                isDisabled : true,
                sending : false,
            }
        },
        methods:{
            disabledBtn(){
                if ($.trim(this.taskTitle).length > 0 && $.trim(this.taskBody).length > 0) {
                    this.isDisabled = false;
                }else{
                    this.isDisabled = true;
                }
            },
            addTask(){
                let vm = this;
                // Enable [add] button
                this.sending = true;
                this.isDisabled = true;

                // Send the request
                this.sending = true;
                axios.post('./addTask', {
                    title: this.taskTitle,
                    body: this.taskBody
                })
                .then(function (response) {
                    console.log('Task Added Successfully');

                    // Emitting the event with the data
                    Event.$emit('newTask', response.data);

                    // Tell [Tasks] component to hide [NoResults] Item
                    Event.$emit('no-results',false);

                    // Reset data
                    vm.taskTitle = "";
                    vm.taskBody = "";

                    // Enable [add] button
                    vm.sending = false;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
