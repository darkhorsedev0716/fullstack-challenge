

<template>
  <div v-if="!apiResponsive">
    Loading Users...
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
      @row-clicked="openModal"
    >
      <template #cell(weather)="data">

        <img v-if="data.item.weather" :src="`http://openweathermap.org/img/wn/${ JSON.parse(data.item.weather).weather[0].icon }.png`" />
      </template>
    </b-table>
  </div>
  <!-- Info modal -->
  <modal ref="modalName">
    <template v-slot:header>
      <h5>{{ infoModal.title }}</h5>
    </template>

    <template v-slot:body>
      <p>
        <img :src="`http://openweathermap.org/img/wn/${ infoModal.content.weather[0].icon }@2x.png`" />
      </p>
      <p>Description: {{ infoModal.content.weather[0].description }} </p>
      <p>Temp: {{ infoModal.content.main.temp }} </p>
      <p>Humidity: {{ infoModal.content.main.humidity }} %</p>
      <p>Pressure: {{ infoModal.content.main.pressure }} hPa</p>
      <p>Visibility: {{ infoModal.content.visibility }} m</p>
      <p>Wind Speed: {{ infoModal.content.wind.speed }} m/s</p>
      <p>Wind Deg: {{ infoModal.content.wind.deg }} </p>
      <p>Wind Gust: {{ infoModal.content.wind.gust }} m/s</p>
    </template>

    <template v-slot:footer>
      <div class="right">
        <button class="btn btn--primary" @click="$refs.modalName.closeModal()">Close</button>
      </div>
    </template>
  </modal>

</template>


<script>
import Modal from "./Modal.vue";

export default {
  data: () => ({
    apiResponsive: null,
    striped: true,
    bordered: true,
    borderless: true,
    outlined: true,
    noCollapse: true,
    fields: ['id', 'name', 'email', 'latitude', 'longitude', 'weather'],
    headVariant: 'light',
    tableVariant: 'light',
    infoModal: {
      id: 'info-modal',
      title: '',
      content: null
    }
  }),
  components: {
    Modal
  },
  created() {
    this.fetchData()
  },
  mounted() {
    
  },
  methods: {
    async fetchData() {
      const url = 'http://localhost/'
      this.apiResponsive = await (await fetch(url)).json()
    },
    openModal(item) {
      if(item.weather){
        this.infoModal.content = JSON.parse(item.weather);
        console.log(this.infoModal.content);
        this.infoModal.title = item.name;
        this.$refs.modalName.openModal();
      }
      
    },
    onRowClicked(item) {
      this.info(item);
    },
    resetInfoModal() {
      this.infoModal.title = '';
      this.infoModal.content = null;
    },
    info(item) {
      this.infoModal.title = item.name;
    }
  }
}
</script>

<style lang="scss">
.btn {
  padding: 8px 16px;
  border-radius: 5px;
  &--primary {
    background-color: green !important;
    color: #fff !important;
  }
  &--secondary {
    background-color: #dddd;
    color: #000;
  }
}

// utilities
.overflow-hidden {
  overflow: hidden;
}
.mx-auto {
  margin-left: auto;
  margin-right: auto;
}
.d-flex {
  display: flex;
}
.align-items-center {
  align-items: center;
}
.justify-content-between {
  justify-content: space-between;
}
// reset
button {
  background: none;
  border: none;
  outline: inherit;
  cursor: pointer;
}
.right{
  text-align:right;

}
h1,
h2,
h3,
h4,
h5,
h6 {
  margin: 0;
}

</style>