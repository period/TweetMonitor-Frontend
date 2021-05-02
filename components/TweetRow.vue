<template>
    <div class="row">
        <div class="col-4">
            <Tweet :id="tweet.id" :error-message="tweet.text" />
        </div>
        <div class="col-1">
            {{ tweet.metrics[0].impressions }}
        </div>
        <div class="col-7">
            <metrics-chart :metrics="tweet.metrics" :display="['Impressions']" />
        </div>
    </div>
</template>
<style scoped>
.row {
    border-top: 1px solid #ccd6dd;
}
</style>
<script>
import { Tweet } from 'vue-tweet-embed'
import MetricsChart from "~/components/MetricsChart";
export default {
    name: "TweetRow",
    components: {MetricsChart, Tweet},
    props: {
        tweet: {
            type: Object,
            default: {}
        }
    }
}
</script>