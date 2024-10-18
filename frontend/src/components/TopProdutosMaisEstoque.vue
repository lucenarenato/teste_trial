<!-- TopProdutosMaisEstoque.vue -->
<template>
  <ChartComponent
    title="Top 10 Produtos com Mais Estoque"
    :chartOptions="options"
    :series="series"
  />
</template>

<script>
import ChartComponent from './ChartComponent.vue';

export default {
  name: 'TopProdutosMaisEstoque',
  components: { ChartComponent },
  data() {
    return {
      series: [
        {
          name: 'Quantidade em Estoque',
          data: [150, 140, 130, 120, 110, 100, 90, 80, 70, 60]
        }
      ],
      options: {
        chart: {
          type: 'bar'
        },
        xaxis: {
          categories: ['Produto A', 'Produto B', 'Produto C', 'Produto D', 'Produto E', 'Produto F', 'Produto G', 'Produto H', 'Produto I', 'Produto J']
        }
      }
    };
  }
};
</script>
