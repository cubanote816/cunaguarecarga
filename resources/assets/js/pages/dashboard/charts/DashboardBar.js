import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  props: {
    data: {
      required: true
    }
  },
  // mounted () {
  //   this.renderChart(this.data, this.options)
  // }
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          height: 250,
          label: 'Recargas',
          backgroundColor: '#f87979',
          data: this.$props.data
        }
      ]
    })
  }
}
