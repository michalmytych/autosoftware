<template>
  <div>
    <h1>Messages</h1>
    <ul>
      <li v-for="message in messages.data" :key="message.id">{{ message.content }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  computed: {
    messages() {
      return this.$store.state.messages;
    }
  },
  mounted() {
    this.$store.dispatch('fetchMessages');
  }
};
</script>



