<template>
    <div class="container">
        <h1 class="text-center">Tweetlytics</h1>

        <div class="row">
            <div class="offset-md-6 col-2"><strong>Impressions</strong></div>
        </div>
        <tweet-row v-for="tweet in tweets" :tweet="tweet" :key="tweet.id" />
    </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css'

import TweetRow from "~/components/TweetRow.vue";

export default {
    name: "Index",
    components: {TweetRow},
    data() {
        return {
            tweets: []
        }
    },
    async mounted() {
        this.$axios.get("https://tweetlytics.thomas.gg/api/tweets", {}).then((res) => {
            this.tweets = res.data;
            console.log(this.tweets[0].metrics)
        })
    }
}
</script>
