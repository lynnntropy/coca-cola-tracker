<template>
  <div id="app">
    <h1>Coca-Cola Tracker</h1>
    <h2>Stranica za praćenje preostalih zaliha nagrada na <a target="_blank" rel="noopener" href="http://novogodisnjapromocija.coca-cola.rs">novogodisnjapromocija.coca-cola.rs</a>.</h2>
    <reward v-for="reward in rewards" :reward="reward"></reward>
  </div>
</template>

<script>
  import axios from 'axios'

  import Reward from './components/Reward'

  export default {
    name: 'app',
    components: { Reward },

    data () {
      return {
        rewards: []
      }
    },

    mounted () {
      axios.get('/rewards').then(({data}) => {
        this.rewards = data
        console.log(data)
      })
    }
  }
</script>

<style lang="scss">
  @import url('https://fonts.googleapis.com/css?family=Courgette');
  @import url('https://fonts.googleapis.com/css?family=Lora');

  body {
    padding: 4rem 1rem;

    background-color: #fafafa;
    font-family: 'Lora', serif;

    h1 {
      margin-bottom: .5rem;
    }

    h2 {
      color: #666;
      text-align: center;
      max-width: 30rem;
      font-size: 1rem;
      margin: 0 0 4rem 0;
    }

  }

  #app {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
</style>
