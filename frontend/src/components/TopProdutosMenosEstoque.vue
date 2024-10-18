<!-- TopProdutosMenosEstoque.vue -->
<template>
  <ChartComponent
    title="Top 10 Produtos com Menos Estoque"
    :chartOptions="options"
    :series="series"
  />
</template>

<script>
import ChartComponent from './ChartComponent.vue';

export default {
  name: 'TopProdutosMenosEstoque',
  components: { ChartComponent },
  data() {
    return {
      series: [
        {
          name: 'Quantidade em Estoque',
          data: [10, 15, 20, 25, 30, 35, 40, 45, 50, 55]
        }
      ],
      options: {
        chart: {
          type: 'bar'
        },
        xaxis: {
          categories: ['Produto K', 'Produto L', 'Produto M', 'Produto N', 'Produto O', 'Produto P', 'Produto Q', 'Produto R', 'Produto S', 'Produto T']
        }
      }
    };
  }
};
</script>
