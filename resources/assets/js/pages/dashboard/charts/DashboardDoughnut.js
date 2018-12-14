import { Doughnut, mixins } from 'vue-chartjs'

export default {
  extends: Doughnut,
  mixins: [mixins.reactiveProp],
  props: ['options'],
  mounted () {
    this.renderChart(this.chartData, {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        position: 'bottom',
        text: 'Ventas'
      }
    })
  }
}
