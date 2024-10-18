<template>
  <q-card class="q-mb-md">
    <q-card-section>
      <h5>{{ title }}</h5>
    </q-card-section>
    <q-card-section>
      <apexchart type="bar" :options="chartOptions" :series="series" />
    </q-card-section>
  </q-card>
</template>

<script>
import ApexCharts from 'vue3-apexcharts';

export default {
  name: 'ChartComponent',
  components: { apexchart: ApexCharts },
  props: {
    title: {
      type: String,
      default: ''
    },
    chartOptions: {
      type: Object,
      required: true
    },
    series: {
      type: Array,
      required: true
    }
  }
};
</script>

<style scoped>
.q-card {
  max-width: 600px;
  margin: 0 auto;
}
</style>
