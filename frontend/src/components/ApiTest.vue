<script>
export default {
  data: () => ({
    apiResponsive: null,
    striped: true,
    bordered: true,
    borderless: true,
    outlined: true,
    noCollapse: true,
    fields: ['id', 'name', 'email', 'latitude', 'longitude'],
    headVariant: 'light',
    tableVariant: 'light'
  }),

  created() {
    this.fetchData()
  },

  methods: {
    async fetchData() {
      const url = 'http://localhost/'
      this.apiResponsive = await (await fetch(url)).json()
    }
  }
}
</script>

<template>
  <div v-if="!apiResponsive">
  </div>

  <div v-if="apiResponsive">
    Users Information: <br />
    <b-table
      :striped="striped"
      :bordered="bordered"
      :borderless="borderless"
      :outlined="outlined"
      :no-border-collapse="noCollapse"
      :items="apiResponsive.users"
      :fields="fields"
      :head-variant="headVariant"
      :table-variant="tableVariant"
    ></b-table>

  </div>
</template>