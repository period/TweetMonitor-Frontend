<template>
    <div class="container my-5">
        <h1 class="text-center">Tweetlytics</h1>
        <div class="row">
            <div class="offset-lg-9 col-3">
                <div class="input-group">
                    <input type="number" class="form-control" v-model="minimum_impressions" placeholder="Min views">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" @click="filter">Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-4 col-2"><strong>Impressions</strong></div>
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
            tweets: [],
            minimum_impressions: null,
        }
    },
    async mounted() {
        window.addEventListener("scroll", this.onScroll);
        this.loadTweets();
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.onScroll);
    },
    methods: {
        filter() {
            this.tweets = [];
            this.loadTweets();
        },
        async loadTweets() {
            let params = {};
            if(this.tweets.length != 0) params.offset = this.tweets[this.tweets.length-1].created_at;
            if(this.minimum_impressions != null && this.minimum_impressions > 0) params.minimum_impressions = this.minimum_impressions;
            this.$axios.get("https://tweetlytics.thomas.gg/api/tweets", {params: params}).then((res) => {
                for(let tweet of res.data) this.tweets.push(tweet);
            })
        },
        async onScroll() {
            let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight
            if(bottomOfWindow) this.loadTweets();
        }
    }
}
</script>
