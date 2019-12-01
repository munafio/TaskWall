<template>
    <div class="card mb-2">
        <div class="card-body">
            <blockquote class="blockquote mb-0">
            <p class="mb-0"><b>{{ title }}</b></p>
            <slot name="body"></slot>
            <!-- delete-button -->
            <slot name="delete-button"></slot>
            </blockquote>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title']
}
</script>
