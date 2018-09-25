<template>
    <button v-on:click="store.score += increment">
        +{{ increment }}
    </button>
</template>

<script>
    export default {
        props: ['increment']
    }
</script>
