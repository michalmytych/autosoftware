<template>
  <div>
    <div>
      <h1>Messages</h1>
      <div style="padding-bottom: 1rem;">
        <DxTextArea
            v-model="messageContent"
            :height="150"
            @input="validateJson"
        />
        <div v-if="error" style="color: red;">{{ error }}</div>
        <DxButton
            text="Create"
            :disabled="!isValidJson"
            @click="sendMessage"
        />
      </div>
    </div>
    <MessagesList/>
  </div>
</template>

<script>
import MessagesList from './components/MessagesList.vue'
import DxButton from "devextreme-vue/button";
import {DxEmptyItem} from "devextreme-vue/form";
import {DxTextArea} from "devextreme-vue";

export default {
  name: 'App',
  components: {
    MessagesList,
    DxEmptyItem,
    DxTextArea,
    DxButton,
  },
  data() {
    return {
      messageContent: '{"key": "Some value"}',
      isValidJson: true
    };
  },
  computed: {
    error() {
      return this.$store.state.error;
    }
  },
  methods: {
    sendMessage() {
      this.$store.dispatch('createMessage', {
        content: this.messageContent
      });
    },
    validateJson() {
      try {
        JSON.parse(this.messageContent);
        this.isValidJson = true;
      } catch (error) {
        this.isValidJson = false;
      }
    },
  }
}
</script>

