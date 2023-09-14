<template>
  <div>
    <DxButton @click="prevPage" :disabled="messages.meta?.page === 1">Previous page</DxButton>
    <DxButton @click="nextPage" :disabled="messages.meta?.per_page === messages.meta?.total">Next page</DxButton>
    <DxDataGrid
        :data-source="messages.data"
        :remote-operations="true"
        :show-borders="true"
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
      <DxColumn data-field="content" caption="Content"/>
    </DxDataGrid>
  </div>
</template>

<script>
import DxButton from 'devextreme-vue/button';
import {DxDataGrid, DxColumn} from 'devextreme-vue/data-grid';

export default {
  components: {
    DxDataGrid,
    DxButton,
    DxColumn,
  },
  computed: {
    messages() {
      return this.$store.state.messages;
    },
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
    }
  },
  mounted() {
    this.$store.dispatch('fetchMessages', {page: 1});
  },
};
</script>