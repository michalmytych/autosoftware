<template>
  <div>
    <DxButton @click="prevPage" :disabled="messages.meta?.page === 1">Previous page</DxButton>
    <DxButton @click="nextPage" :disabled="messages.meta?.per_page === messages.meta?.total">Next page</DxButton>
    <DxDataGrid
        :data-source="messages.data"
        :remote-operations="true"
        :show-borders="true"
        @row-click="handleRowClick"
    >
      <DxColumn
          data-field="uuid"
          caption="ID"
          @update:sortOrder="(order) => handleColumnSortOrderChange(order, 'id')"
      />
      <DxColumn
          data-field="createdAt.date"
          caption="Created at"
          :data-type="'datetime'"
          @update:sortOrder="(order) => handleColumnSortOrderChange(order, 'createdAt')"
      />
      <DxColumn
          data-field="content"
          caption="Raw JSON content"
      />
    </DxDataGrid>
    <DxPopup
        :visible="isModalVisible"
        :drag-enabled="true"
        :hide-on-outside-click="true"
        title="Message Details"
        :width="500"
        :height="580"
        @update:visible="resetModalData"
    >
      <h3>{{ selectedMessage?.id }}</h3>
      <em>{{ selectedMessage?.createdAt.date }}</em>
      <h4>Raw message content</h4>
      <code>{{ selectedMessage?.content }}</code>
    </DxPopup>
  </div>
</template>

<script>
import DxButton from 'devextreme-vue/button';
import {DxDataGrid, DxColumn} from 'devextreme-vue/data-grid';
import DxPopup from "devextreme-vue/popup";

export default {
  components: {
    DxDataGrid,
    DxButton,
    DxColumn,
    DxPopup
  },
  computed: {
    messages() {
      return this.$store.state.messages;
    },
    selectedMessage() {
      return this.$store.state.selectedMessage;
    }
  },
  data() {
    return {
      isModalVisible: false
    };
  },
  methods: {
    prevPage() {
      if (this.messages.meta.page > 1) {
        this.$store.dispatch('fetchMessages', {page: this.messages.meta.page - 1});
      }
    },
    nextPage() {
      if (this.messages.meta.page < this.messages.meta.total) {
        this.$store.dispatch('fetchMessages', {page: this.messages.meta.page + 1});
      }
    },
    handleColumnSortOrderChange(sortOrder, column) {
      this.$store.dispatch('fetchMessages', {
        page: this.messages.meta?.page,
        sorterKey: column,
        sorterOrder: sortOrder
      });
    },
    handleRowClick(e) {
      this.$store.dispatch('fetchSingleMessage', {
        id: e.data.uuid
      });

      this.isModalVisible = true;
    },
    resetModalData() {
      this.isModalVisible = false;
      this.selectedMessage = null;
    },
  },
  mounted() {
    console.log(process.env)
    this.$store.dispatch('fetchMessages', {page: 1});
  },
};
</script>