<template>
    <div class="container" v-if="loaded">
        <h1 class="text-center">Tweetlytics - Tweet #{{ tweet.id }}</h1>
        <div class="row">
            <Tweet class="col-3" :id="tweet.id" :error-message="tweet.text" />
            <metrics-chart class="col-9" :metrics="tweet.metrics" :display="['Impressions']" />
            <metrics-chart class="col-6" :metrics="tweet.metrics" :display="['Retweets', 'Quotes', 'Likes']" />
            <metrics-chart class="col-6" :metrics="tweet.metrics" :display="['Profile Clicks']" />
        </div>
    </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css'
import { Tweet } from 'vue-tweet-embed'

import MetricsChart from "~/components/MetricsChart.vue";

export default {
    name: "TweetView",
    components: {MetricsChart, Tweet},
    data() {
        return {
            loaded: false,
            tweet: {},
        }
    },
    async mounted() {
        this.loadTweet();
    },
    methods: {
        async loadTweet() {
            this.$axios.get("https://tweetlytics.thomas.gg/api/tweets", {params: {tweet: this.$route.params.tweet}}).then((res) => {
                this.tweet = res.data[0];
                this.loaded = true;
            })
        },
    }
}
</script>
