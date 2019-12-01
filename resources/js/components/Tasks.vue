<template>
    <div>
        <!-- Task Items -->
        <task-item v-for="(task, index) in tasks" :key="index" :title="task.title">
        {{ task.body }}
        <p class="mb-0" slot="body">{{ task.body }}</p>
        <!-- delete-button -->
        <a href="#" class="delete-item" slot="delete-button" @click.prevent="deleteItem(index)">X</a>
        </task-item>

        <!-- No Tasks Item -->
        <task-item v-show="noTasksYet">
            <div slot="body" class="text-center">
                <p class="mb-0 text-secondary">There is no tasks in your list yet.</p>
            </div>
        </task-item>

        <!-- Loading Item -->
        <task-item v-show="loading">
            <div slot="body" class="text-center">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
        </task-item>
    </div>
</template>

<script>
export default {
    data(){
        return {
            tasks: [],
            loading: true,
            noTasksYet: false,
        }
    },
    methods: {
        deleteItem(index){
            let taskID = this.tasks[index].id;
            // Delete from [tasks] list
            this.tasks.splice(index, 1);
            // Delete request
            axios.post('./deleteTask',{id:taskID})
            .then((response) => {
                response
                ? console.log('Task Deleted')
                : console.error('Error occured while deleting the task!');;

            })
            .catch(function (error) {
                console.log(error);
            });
            // Show no tasks card if [tasks] = 0
            if (this.tasks.length < 1) {
                this.noTasksYet = true;
            }
        }
    },
    created(){
        axios.post('./fetchTasks')
        .then((response) => {
            // hide loading
            this.loading = false;

            // View results
            response.data.userTotalTasks < 1
            ? this.noTasksYet = true
            : this.tasks = response.data.tasks;
        });

        // Listen on events
        Event.$on('newTask', (task) => {
            this.tasks.push(task);
        });
        Event.$on('no-results', data => this.noTasksYet = data);
    }

}
</script>
