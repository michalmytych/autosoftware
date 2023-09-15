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
        <div style="display: flex; align-items: center; padding-top: 1rem; justify-content: end;">
          <div v-if="!isValidJson" style="color: red; padding-left: 1rem;">Json is invalid!</div>
          <DxButton
              text="Send"
              :disabled="!isValidJson"
              @click="sendMessage"
          />
        </div>
      </div>
    </div>
    <MessagesList/>
  </div>
</template>

<script>
import MessagesList from './components/MessagesList.vue'
import DxButton from "devextreme-vue/button";
import {DxTextArea} from "devextreme-vue";

export default {
  name: 'App',
  components: {
    MessagesList,
    DxTextArea,
    DxButton,
  },
  data() {
    return {
      messageContent: '{"message": "Hello world!"}',
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
      this.validateJson();
      if (!this.isValidJson) return;
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

