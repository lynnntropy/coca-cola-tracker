<template>
  <div class="reward">
    <div class="header">
      <img :src="reward.image_url">
      <h1>{{ reward.name }}</h1>
    </div>
    <div class="info">
      <p>Trenutno zaliha: <strong>{{ reward.last_known_quantity }}</strong></p>
      <p>Očekivano vreme isteka zaliha: <strong>{{ exhaustedTime | moment("Do MMMM YYYY") }} ({{ exhaustedTime | moment("from") }})</strong></p>
    </div>
    <highcharts v-if="chartOptions" :options="chartOptions"></highcharts>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "reward",
    props: ['reward'],

    data () {
      return {
        chartOptions: null,
        exhaustedTime: null
      }
    },

    methods: {

      mysqlToIsoDateTime: (dateTimeString) => dateTimeString.replace(' ', 'T'),

      extrapolateExhaustedTime: function (firstSnapshot, secondSnapshot) {

        const quantity1 = firstSnapshot.quantity
        const quantity2 = secondSnapshot.quantity

        const timestamp1 = Date.parse(this.mysqlToIsoDateTime(firstSnapshot.date_time))
        const timestamp2 = Date.parse(this.mysqlToIsoDateTime(secondSnapshot.date_time))

        const msPerUnit = (timestamp2 - timestamp1) / (quantity1 - quantity2)

        return (Date.now() + (quantity2 * msPerUnit))

      }

    },

    mounted () {
      axios.get(`/rewards/${this.reward.id}/snapshots`).then(({data}) => {
        console.log(data)

        const exhaustedTime = this.extrapolateExhaustedTime(data[0], data[data.length - 1])
        this.exhaustedTime = exhaustedTime

        const lastSnapshot = data[data.length - 1]

        const seriesData = []

        data.forEach(snapshot => {
          seriesData.push([Date.parse(this.mysqlToIsoDateTime(snapshot.date_time)), snapshot.quantity])
        })

        this.chartOptions = {

          chart: {
            type: 'line',
            backgroundColor: null
          },

          title: {
            text: undefined
          },

          xAxis: {
            type: 'datetime',
            ordinal: false,
            startOnTick : false,
            endOnTick : false,
            title: {
              text: 'Datum/vreme'
            },
            units: [[
              'day',
              [1]
            ], [
              'week',
              [1]
            ], [
              'month',
              [1, 3, 6]
            ], [
              'year',
              null
            ]],
            min: new Date(2018, 11, 3, 0, 0, 0, 0).getTime(),
            max: new Date(2018, 11, 25, 23, 59, 0, 0).getTime()
          },

          yAxis: {
            title: {
              text: 'Preostali broj'
            },
            // opposite: true,
            min: 0,
            max: 60000
          },

          plotOptions: {
            series: {
              lineWidth: 4,
              color: '#F44336'
            }
          },

          legend: {
            enabled: false
          },

          series: [{
            name: 'Preostali broj',
            data: seriesData
          }, {
            name: 'Prediction',
            dashStyle: 'Dash',
            color: 'rgb(244, 67, 54, 0.35)',
            enableMouseTracking: false,
            data: [
              [Date.parse(this.mysqlToIsoDateTime(lastSnapshot.date_time)), lastSnapshot.quantity],
              [exhaustedTime, 0]]
          }]

        }
      })
    }
  }
</script>

<style scoped lang="scss">
  .reward {
    background-color: #fff;
    margin-bottom: 2rem;

    min-width: 50rem;

    box-shadow: 0 .25rem .75rem rgba(black, .15);
    border-radius: .4rem;

    padding: 2rem;

    @media (max-width: 50rem) {
      min-width: 0;
    }

    .header {
      display: flex;
      flex-direction: row;
      align-items: center;

      margin-bottom: 1rem;

      img {
        height: 5rem;
        margin-right: 1rem;
      }

      h1 {
        font-size: 2.25rem;
        margin: 0;
        position: relative;

        font-family: 'Courgette', cursive;
      }
    }

    .info {

      margin-bottom: 2rem;

      p {
        margin: 0 0 .2rem 0;
      }
    }
  }
</style>