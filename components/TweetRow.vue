<template>
    <div class="row">
        <div class="col-4">
            {{ tweet.text }}
        </div>
        <div class="col-1">
            {{ tweet.metrics[0].impressions }}
        </div>
        <div class="col-7">
            <line-chart style="height: 300px;" :data="{
                labels: tweet.metrics.map((el) => { return new Date(parseInt(el.timestamp)) }),
                datasets: [
                    {
                        label: 'Impressions',
                        data: tweet.metrics.map((el) => { return el.impressions }),
                        borderColor: '#1DA1F2',
                        backgroundColor: 'rgba(0,0,0,0)'
                    }
                ]}"
            :options="{
                responsive: true,
                spanGaps: true, 
                maintainAspectRatio: false, 
                scales: {
                    xAxes: [
                        {type:'time'}
                    ]
                }
            }" />
        </div>
    </div>
</template>
<style scoped>
.row {
    border-top: 1px solid #ccd6dd;
}
</style>
<script>
import LineChart from "~/components/LineChart";
export default {
    name: "TweetRow",
    components: {LineChart},
    props: {
        tweet: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
        }
    },
    mounted() {
    }
}
</script>