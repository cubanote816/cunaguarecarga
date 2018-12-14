// import 'chart.js'
import {Doughnut} from 'vue-chartjs'
// import { mapState } from 'vuex'

export default {
  extends: Doughnut,
  props: {
    data: {
      required: true
    }
  },
  // computed: {
  //   ...mapState({
  //     last20_sales: state => state.report.last20_sales,
  //   }),
  // },
  mounted () {
    this.renderChart({
      // labels: this.$props.labels,
      labels: ['Completadas', 'Pendientes', 'Denegadas'],
      datasets: [
        {
          height: 250,
          data: this.$props.data,
          backgroundColor: [
            'green',
            'orange',
            'red'
          ],
          hoverBackgroundColor: [
            '#036103',
            '#c17f05',
            '#bb0000'
          ]
        }
      ],
      option: {
        responsive: true,
        maintainAspectRatio: true,
        title: {
          display: true,
          position: 'bottom',
          text: 'Ventas'
        }
      }
    })
  }
}
